<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Hash;
use Session;
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
use Mail; 
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Dashboard function
     */
    public function dashboard()
    {

        if(Auth::check()){
            $user = Auth::user();
            if($user->type == 'student'){
                return view('student.dashboard',compact('user'));
            }
            return redirect("/")->withSuccess('Trust me this is not belongs to you');
        } 
        return redirect("/")->withSuccess('Trust me this is not belongs to you');
    }

    /**
     * Bookings function
     */
    public function bookings()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->type == 'student'){
                $bookings =  Booking::where('user_id', $user->_id)->get();
                return view('student.bookings',compact('bookings'));
            }
            return redirect("/")->withSuccess('Trust me this is not belongs to you');
        } 
        return redirect("/")->withSuccess('Trust me this is not belongs to you');
    }

    /**
     * Booking function
     */
    public function booking(string $id)
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->type == 'student'){
              $booking = Booking::find($id);
              return view('student.booking', compact('booking'));
            }
            return redirect("/")->withSuccess('Trust me this is not belongs to you');  
        }
        return redirect("/")->withSuccess('Trust me this is not belongs to you');   
    }

    /**
     * Update Booking function
     */
    public function updateBooking(Request $request)
    {

    }

    /**
     * Reviews function
     */
    public function reviews()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->type == 'student'){
                $reviews =  Review::where('reviewer_id', $user->_id)->get();
                return view('student.reviews',compact('reviews'));
            }
            return redirect("/")->withSuccess('Trust me this is not belongs to you');
        } 
        return redirect("/")->withSuccess('Trust me this is not belongs to you');
    }

    /**
     * Review function
     */
    public function review(string $id)
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->type == 'student'){
              $review = Review::find($id);
              return view('student.review', compact('review'));
            }
            return redirect("/")->withSuccess('Trust me this is not belongs to you');  
        }
        return redirect("/")->withSuccess('Trust me this is not belongs to you');   
    }

    /**
     * Update Reviews function
     */
    public function updateReviews(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->type == 'student'){
                $request->validate([
                    'class_id'=>'required',
                    'rating'=>'required',
                    'comment'=>'required'
                ]);
      
                if($request->task == 'update'){
                    $review = Review::find($request->id);
                    //Get receiver_id id from course
                    $course = Classes::find($request->class_id);
                    if($review)
                    {
                        $review->receiver_id = $course->_id;
                        $review->reviewer_id = $user->_id;
                        $review->class_id = $request->class_id;
                        $review->rating = $request->rating;
                        $review->comment = $request->comment;
                        $review->save();
                        return redirect()->route('student.reviews')->with('success','Review updated successfully');
                    }
                }else{
                    Review::create([
                        'receiver_id' => $course->_id,
                        'reviewer_id' => $user->_id,
                        'class_id' => $request->class_id,
                        'rating' => $request->rating,
                        'comment' => $request->comment
                    ]);
                    return redirect()->route('student.reviews')->with('success','Review created successfully');
                }
            }
            return redirect("/")->withSuccess('Trust me this is not belongs to you');
        }
        return redirect("/")->withSuccess('Trust me this is not belongs to you');  
    }

    /**
     * Account function
     */
    public function account()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->type == 'student'){
                return view('student.account',compact('user'));
            }
            return redirect("/")->withSuccess('Trust me this is not belongs to you');
        } 
        return redirect("/")->withSuccess('Trust me this is not belongs to you');
    }

    /**
     * Update Account function
     */
    public function updateAccount(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->type == 'student'){
                if($request->task == 'details'){
                    $request->validate([
                        'name' => 'required',
                        'email'  => 'required|string|email|max:255|unique:users,email,' . $request->id,
                        'phone'=>'required'
                    ]);
                    if ($validator->fails()) {
                        $error = $validator->errors()->all();
                        return redirect()->route('student.account')->with('error','Unable to validate your data');
                    }
                    $currentUser = User::find($request->id);
                    if($currentUser)
                    {
                        $currentUser->name = $request->name;
                        $currentUser->email = $request->email;
                        $currentUser->phone = $request->phone;
                        $currentUser->save();
                        return redirect()->route('student.account')->with('success','Account updated successfully');
                    }
                }elseif($request->task == 'password'){
                    $inputs = [
                        'old_password'          => $request->old_password,
                        'password'              => $request->password,
                        'password_confirmation' => $request->password_confirmation,
                    ];
                    $rules = [
                        'old_password'    => 'required',
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
                        return redirect()->route('student.account')->with('error','Unable to validate your data');
                    }else{
                        $currentUser = User::find($request->id);
                        $currentUser->password = \Hash::make($password);
                        $currentUser->update(); //or $currentUser->save();
                        return redirect()->route('student.account')->with('success','Account updated successfully');
                    }
                }
            }
            return redirect("/")->withSuccess('Trust me this is not belongs to you');
        }
        return redirect("/")->withSuccess('Trust me this is not belongs to you');  
    }
}
