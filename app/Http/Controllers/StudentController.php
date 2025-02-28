<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Booking;
use App\Models\Category;
use App\Models\ClassDate;
use App\Models\Classes;
use App\Models\Instructor;
use App\Models\Location;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use App\Models\UserVerify;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Mail; 
use Validator;
use Hash;
use Session;
class StudentController extends Controller
{
    /**
     * Dashboard function
     */
    public function dashboard()
    {
        if(Auth::check()){
            try {
                $user = Auth::user();
                $bookings = Booking::where('user_id',$user->_id)->where('status',1)->get();
                $reviews = Review::where('reviewer_id',$user->_id)->get();
                $payments = 0;
                foreach($bookings as $booking){
                    $payment = Payment::where('booking_id',$booking->_id)->firstOrFail();
                    $payments += $payment->amount;
                }
                return view('student.dashboard',compact('user','bookings','reviews','payments'));
            } catch(\Exception $exception) {
                return redirect()->route('student.error')->with('error-page','Unable to find your request');
            }    
        }
    }

    /**
     * Bookings function
     */
    public function bookings()
    {
        try {
            $user = Auth::user();
            $bookings =  Booking::where('user_id', $user->_id)->get();
            return view('student.bookings',compact('bookings','user'));
        } catch(\Exception $exception) {
            return redirect()->route('student.error')->with('error-page','Unable to find your request');
        }
    }

    /**
     * Booking function
     */
    public function booking(string $id)
    {
        try {
            $user = Auth::user();
            $booking = Booking::find($id);
            return view('student.booking', compact('booking','user'));
        } catch(\Exception $exception) {
            return redirect()->route('student.error')->with('error-page','Unable to find your request');
        }
    }

    /**
     * Reviews function
     */
    public function reviews()
    {
        try {
            $user = Auth::user();
            $reviews =  Review::where('reviewer_id', $user->_id)->get();
            return view('student.reviews',compact('reviews','user'));
        } catch(\Exception $exception) {
            return redirect()->route('student.error')->with('error-page','Unable to find your request');
        }
    }

    /**
     * Review function
     */
    public function review(string $id)
    {
        try {
            $user = Auth::user();
            $review = Review::where('_id', $id)->where('reviewer_id', $user->_id)->firstOrFail();
            $booking = Booking::where('user_id', $user->_id)->where('class_id', $review->class_id)->firstOrFail();
            $edit = true;
            return view('student.review', compact('review','user','booking','edit'));
        } catch(\Exception $exception) {
            return redirect()->route('student.error')->with('error-page','Unable to find your request');
        }
    }

    public function reviewCreate(string $booking_id)
    {
        if(Auth::check()){
            $edit = false;
            try {
                $user = Auth::user();
                $booking = Booking::where('user_id', $user->_id)->where('_id', $booking_id)->firstOrFail();
                $review = Review::where('reviewer_id', $user->_id)->where('class_id', $booking->class_id)->firstOrFail();
                if(!empty($review)){
                    return redirect()->route('student.review.edit',$review->_id);
                }else{
                    return view('student.review.create', compact('booking','user','edit'));
                }
            } catch(\Exception $exception) {
                return redirect()->route('student.error')->with('error-page','Unable to find your request');
            }    
        }
    }

    
    /**
     * Update Reviews function
     */
    public function updateReviews(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
                $validator = Validator::make($request->all(), [
                    'rating'  => 'required',
                    'comment'=>'required'
                  ],
                  [
                    'rating.required' => 'Your rating is Required', 
                    'comment.required'=> 'Your comment is Required', 
                  ]
                );
                if ($validator->fails()) {
                    $error = $validator->errors()->all();
                    return redirect()->route('student.reviews')->with('error-review','Unable to validate your data');
                }
      
                if($request->task == 'update'){
                    try {
                        $review = Review::find($request->id);
                        //Get receiver_id id from course
                        $course = Classes::find($request->course);
                        if($review)
                        {
                            $review->receiver_id = $request->receiver_id;
                            $review->reviewer_id = $user->_id;
                            $review->class_id = $request->course;
                            $review->rating = $request->rating;
                            $review->comment = $request->comment;
                            $review->save();
                            return redirect()->route('student.reviews')->with('success-review','Review updated successfully');
                        }
                    } catch(\Exception $exception) {
                        return redirect()->route('student.error')->with('error-page','Unable to find your request');
                    }
                }else if($request->task == 'update'){
                    try {
                        Review::create([
                            'receiver_id' => $request->receiver_id,
                            'reviewer_id' => $user->_id,
                            'class_id' => $request->course,
                            'rating' => $request->rating,
                            'comment' => $request->comment
                        ]);
                        return redirect()->route('student.reviews')->with('success-review','Review created successfully');
                    } catch(\Exception $exception) {
                        return redirect()->route('student.error')->with('error-page','Unable to find your request');
                    }
                }
            
        }
    }

    /**
     * Account function
     */
    public function account()
    {
        if(Auth::check()){
            try {
                $user = Auth::user();
                return view('student.account',compact('user'));
            } catch(\Exception $exception) {
                return redirect()->route('student.error')->with('error-page','Unable to find your request');
            }
        } 
    }

    /**
     * Update Account function
     */
    public function updateAccount(Request $request)
    {
      if(Auth::check()){
        $user = Auth::user();
            if($request->task == 'details'){
                  $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email'  => 'required|string|email|max:255|unique:users,email,' . $request->id,
                    'phone'=>'required'
                  ],
                  [
                    'name.required' => 'Your First Name is Required', 
                    'email.required' => 'Your Email is Required', 
                    'phone.required'=> 'Your phone number is Required', 
                  ]
                );
                if ($validator->fails()) {
                    $error = $validator->errors()->all();
                    return redirect()->route('student.account')->with('error-account','Unable to validate your data');
                }

                $files = '';
                if($request->hasFile('file_upload')){
                    //Set files array
                    $location = 'users';
                    $files = $this->upload($request->file('file_upload'),$location,'true');
                }

                $currentUser = User::find($request->id);
                if($currentUser)
                {
                    $currentUser->name = $request->name;
                    $currentUser->email = $request->email;
                    $currentUser->phone = $request->phone;
                    $currentUser->photo_gallery = $files;
                    $currentUser->save();
                    return redirect()->route('student.account')->with('success-account','Account updated successfully');
                }
            }elseif($request->task == 'password'){
                $inputs = [
                    'old_password'          => $request->password_current,
                    'password'              => $request->password,
                    'password_confirmation' => $request->password_confirmation,
                ];
                $rules = [
                    'password_current'    => 'required',
                    'password_confirmation' => 'required',
                    'password' => [
                        'required',
                        'confirmed',
                        'string',
                        'min:10',             // must be at least 10 characters in length
                        'regex:/[a-z]/',      // must contain at least one lowercase letter
                        'regex:/[A-Z]/',      // must contain at least one uppercase letter
                        'regex:/[0-9]/',      // must contain at least one digit
                        'regex:/[@$!%*#?&]/', // must contain a special character
                    ],
                ];
                $validator = Validator::make( $inputs, $rules );
                if ( $validator->fails() ) {
                    $error = $validator->errors()->all();
                    return redirect()->route('student.account')->with('error-password','Unable to validate your data');
                }else{
                    $currentUser = User::find($request->id);
                    $currentUser->password = \Hash::make($password);
                    $currentUser->update(); //or $currentUser->save();
                    return redirect()->route('student.account')->with('success-password','Account updated successfully');
                }
            }
        }
    } 


    public function upload($request,$type = null,$multiple = null){
        $arr = [];
        $location = '';
        
        if(!empty($type) && ($type == 'users')){
            $location = 'public/uploads/users';
        }else{
            $location = 'public/uploads/courses';
        }
        
        if(!empty($multiple) && ($multiple == 'false')){
            $string = Str::random(32);
            $size = filesize($request);
            $ext = $request->guessExtension();
            $file_name = $string . '.' .  $ext;
            
            if($type == 'users'){
                $filePath = $request->storeAs($location, $file_name);
            }else{
                $filePath = $request->storeAs($location, $file_name);
            }
            array_push($arr, [
                'name' => $file_name,
                'path' => $filePath,
            ]);
             
        }else{
            foreach($request as $file){
                $string = Str::random(32);
                $size = filesize($file);
                $ext = $file->guessExtension();
                $file_name = $string . '.' .  $ext;
                
                if($type == 'users'){
                    $filePath = $file->storeAs($location, $file_name);
                }else{
                    $filePath = $file->storeAs($location, $file_name);
                }
                array_push($arr, [
                    'name' => $file_name,
                    'path' => $filePath,
                ]);
            }    
        }

        return json_encode($arr);
    }

    public function error(){
        return view('error.error'); 
    }
}
 