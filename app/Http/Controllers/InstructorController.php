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
class InstructorController extends Controller
{
    /**
     * Dashboard function
     */
    public function dashboard()
    {
        if(Auth::check()){
            $user = Auth::user();
            return view('instructor.dashboard',compact('user'));
        } 
    }

    /**
     * Courses function
     */
    public function courses()
    {
        if(Auth::check()){
            
            $user = Auth::user();
            $courses = Classes::where('instructor_id',$user->_id)->get();
            $categories = Category::all();    
            $locations = Location::where('user_id',$user->_id)->get();    
            return view('instructor.courses', compact('courses','user','categories','locations')); 
        
        }
    }

    /**
     * Course function
     */
    public function course(string $id)
    {
        if(Auth::check()){
            $user = Auth::user();
            $course = Classes::where('instructor_id',$user->_id)
                        ->where('_id',$id)
                        ->get();
            $categories = Category::all();   
            $locations = Location::where('user_id',$user->_id)->get();    
            return view('instructor.course', compact('course','user','categories','locations'));
        }
    }

    /**
     * Update Course function
     */
    public function updateCourse(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            if($request->location_selected == ''){
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description'  => 'required',
                    'price'=>'required',
                    'max_capacity'=>'required',
                    'location_name'=> 'required',
                    'location_address'=>'required',
                    'location_city'=>'required',
                    'duration'=>'required',
                    'dates' => ['required', 'array', 'min:1'],  // Ensure at least one date is provided
                    'dates.*' => ['required', 'date'], // Validate each date as a valid date format
                    'start_times' => ['required', 'array', 'min:1'], // Ensure at least one time is provided
                    'start_times.*' => ['required', 'date_format:H:i'], // Validate each time as a valid time format (24-hour format)
                    'end_times' => ['required', 'array', 'min:1'], // Ensure at least one time is provided
                    'end_times.*' => ['required', 'date_format:H:i'], // Validate each time as a valid time format (24-hour format)
                  ],
                  [
                    'title.required' => 'Your title is Required', 
                    'description.required' => 'Your description is Required', 
                    'price.required'=> 'Your cost per seat is Required', 
                    'max_capacity.required'=> 'Your max capacity is Required', 
                    'location_name.required'=> 'Your location name is Required', 
                    'location_address.required'=> 'Your address is Required', 
                    'location_city.required'=> 'Your city is Required', 
                    'duration.required'=> 'Your course duration is Required', 
                    'dates.required'=> 'Your course dates is Required', 
                    'start_times.required'=> 'Your course start times is Required', 
                    'end_times.required'=> 'Your course end times is Required', 
                  ]
                );
            }else{
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description'  => 'required',
                    'price'=>'required',
                    'max_capacity'=>'required',
                    'duration'=>'required',
                    'dates'=>'required',
                    'times'=>'required',
                  ],
                  [
                    'title.required' => 'Your title is Required', 
                    'description.required' => 'Your description is Required', 
                    'price.required'=> 'Your cost per seat is Required', 
                    'max_capacity.required'=> 'Your max capacity is Required', 
                    'duration.required'=> 'Your course duration is Required', 
                    'dates.required'=> 'Your course dates is Required', 
                    'times.required'=> 'Your course times is Required', 
                  ]
                );
            }

            if ($validator->fails()) {
                $error = $validator->errors()->all();
                dd($error);
                //return redirect()->route('instructor.courses')->with('error','Unable to validate your data');
                //return back()->withErrors($validator)->withInput();
            }

            /**
            * Get locataion codinates / create location
            */ 
            if($request->location_selected == ''){
                $address = $request->location_address.' '.$request->location_city.' '.$request->location_country;
                $results = app("geocoder")
                    ->doNotCache()
                    ->geocode($address)
                    ->get();
                $coordinates = $result[0]->getCoordinates();

                $location = Location::create([
                    'user_id' => $user->_id,
                    'name' => $request->location_name,
                    'address' => $request->location_address,
                    'city' => $request->location_city,
                    'country' => $request->location_country,
                    'latitude' => $coordinates->getLatitude(),
                    'longitude' => $coordinates->getLongitude(),
                ]);
                $location_id = $location->_id;
            }else{
                $location_id = $request->location_selected;
            } 
            
            //Set files array
            $location = 'courses';
            $files = $this->upload($request->file('file_upload'),$location,'true');

            //Create Course
            $course = new Course();
            $course->instructor_id = $user->id;
            $course->title = $request->title;
            $course->description = $request->description;
            $course->category_id = $request->category_id;
            $course->location_id = $location_id;
            $course->duration = $request->duration;
            $course->duration_type = $request->duration_type;
            $course->price = $request->price;
            $course->max_capacity = $request->max_capacity;
            $course->level = $request->course_level;
            $course->photo_gallery = $files;
            $course->save();

            //Adding course dates and times
            foreach($request->dates as $key => $value){
                $date_times = new ClassDate();
                $date_times->class_id = $course->_id;
                $date_times->class_date = $value;
                $date_times->start_at = $request->start_times[$key];
                $date_times->end_at = $request->end_times[$key];
                $date_times->save();
            }
            dd($request);
            
            

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
    

     /**
     * Bookings function
     */
    public function bookings()
    {
        if(Auth::check()){
            $user = Auth::user();
            $bookings = array();
            $courses = Classes::where('instructor_id',$user->_id)->get();
            if($courses != null){
                foreach($courses as $course){
                    $bookings[$course->_id] = Booking::where('_id',$course->_id)->get();
                }
            }
            return view('instructor.bookings', compact('bookings','user')); 
        }
    }

    /**
     * Booking function
     */
    public function booking(string $id)
    {
        if(Auth::check()){
            $user = Auth::user();
            $booking = Booking::find($id);
            if($booking != null){
                $course = Classes::find($booking->class_id);
                if($course != null){
                    return view('instructor.booking', compact('booking','user'));
                }
            }
            return redirect("instructor.bookings")->withSuccess('Trust me this is not belongs to you');
        }
    }

    /**
     * Reviews function
     */
    public function reviews()
    {
        if(Auth::check()){
            $user = Auth::user();
            $reviewer =  Review::where('reviewer_id', $user->_id)->get();
            $receiver =  Review::where('receiver_id', $user->_id)->get();
            return view('instructor.reviews',compact('reviewer','receiver','user'));
        } 
    }

    /**
     * Review function
     */
    public function review(string $id)
    {
        
    }

    /**
     * Update Reviews function
     */
    public function updateReviews(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
                $validator = Validator::make($request->all(), [
                    'class_id' => 'required',
                    'rating'  => 'required',
                    'comment'=>'required'
                  ],
                  [
                    'class_id.required' => 'Your class is Required', 
                    'rating.required' => 'Your rating is Required', 
                    'comment.required'=> 'Your comment is Required', 
                  ]
                );
                if ($validator->fails()) {
                    $error = $validator->errors()->all();
                    return redirect()->route('instructor.reviews')->with('error','Unable to validate your data');
                }
      
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
                        return redirect()->route('instructor.reviews')->with('success','Review updated successfully');
                    }
                }else{
                    Review::create([
                        'receiver_id' => $course->_id,
                        'reviewer_id' => $user->_id,
                        'class_id' => $request->class_id,
                        'rating' => $request->rating,
                        'comment' => $request->comment
                    ]);
                    return redirect()->route('instructor.reviews')->with('success','Review created successfully');
                }
            
        }
    }

    /**
     * Account function
     */
    public function account()
    {
        if(Auth::check()){
            $user = Auth::user();
            return view('instructor.account',compact('user'));  
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
                    return redirect()->route('instructor.account')->with('error','Unable to validate your data');
                }
                $currentUser = User::find($request->id);
                if($currentUser)
                {
                    $currentUser->name = $request->name;
                    $currentUser->email = $request->email;
                    $currentUser->phone = $request->phone;
                    $currentUser->save();
                    return redirect()->route('instructor.account')->with('success','Account updated successfully');
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
                    return redirect()->route('instructor.account')->with('error','Unable to validate your data');
                }else{
                    $currentUser = User::find($request->id);
                    $currentUser->password = \Hash::make($password);
                    $currentUser->update(); //or $currentUser->save();
                    return redirect()->route('instructor.account')->with('success','Account updated successfully');
                }
            }
        }
    } 
}
