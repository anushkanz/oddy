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
use App\Models\InstructorQualification;
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
            try {
                $user = Auth::user();
                $courses = Classes::where('instructor_id',$user->_id)->get();
                $coursesId = array();
                foreach($courses as $course){
                    $coursesId[] = $course->_id;
                }
                $bookings = Booking::whereIn('class_id',$coursesId)->where('status',1)->get();
                $payments = 0;
                foreach($bookings as $booking){
                    if($booking->classes->instructor_id == $user->_id){
                        $payment = Payment::where('booking_id',$booking->_id)->firstOrFail();
                        $payments += $payment->amount; //Need to remove commission
                    }
                }
                return view('instructor.dashboard',compact('user','courses','bookings','payments'));
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            }    
        }
    }

    /**
     * Courses function
     */
    public function courses()
    {
        if(Auth::check()){
            try {
                $user = Auth::user();
                $courses = Classes::where('instructor_id',$user->_id)->get();
                $categories = Category::all();    
                $locations = Location::where('user_id',$user->_id)->get();    
                return view('instructor.courses', compact('courses','user','categories','locations')); 
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            }
        }
    }

    /**
     * Course function
     */
    public function course(string $id)
    {
        if(Auth::check()){
            try {
                $user = Auth::user();
                $course = Classes::where('instructor_id',$user->_id)
                            ->where('_id',$id)
                            ->firstOrFail();
                $categories = Category::all();   
                $locations = Location::where('user_id',$user->_id)->get();  
                $classdates = ClassDate::where('class_id',$id)->get();      
                return view('instructor.course', compact('course','user','categories','locations','classdates'));
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            }
        }
    }

    /**
     * Update Course function
     */
    public function updateCourse(Request $request)
    {
        $user = Auth::user();
        if(Auth::check() && ($request->task == 'create')){
            try {
                if($request->location_selected == 'create_new'){
                    $validator = Validator::make($request->all(), [
                        'title' => 'required',
                        'description'  => 'required',
                        'price'=>'required',
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
                        'max_capacity' => ['required', 'array'],
                        'max_capacity.*' => ['required',], 
                      ],
                      [
                        'title.required' => 'Your title is Required', 
                        'description.required' => 'Your description is Required', 
                        'price.required'=> 'Your cost per seat is Required', 
                        'location_name.required'=> 'Your location name is Required', 
                        'location_address.required'=> 'Your address is Required', 
                        'location_city.required'=> 'Your city is Required', 
                        'duration.required'=> 'Your course duration is Required', 
                        'dates.required'=> 'Your course dates is Required', 
                        'start_times.required'=> 'Your course start times is Required', 
                        'end_times.required'=> 'Your course end times is Required', 
                        'max_capacity.required'=> 'Your max capacity is Required', 
                      ]
                    );
                }else{
                    $validator = Validator::make($request->all(), [
                        'title' => 'required',
                        'description'  => 'required',
                        'price'=>'required',
                        'duration'=>'required',
                      ],
                      [
                        'title.required' => 'Your title is Required', 
                        'description.required' => 'Your description is Required', 
                        'price.required'=> 'Your cost per seat is Required', 
                        'duration.required'=> 'Your course duration is Required', 
                      ]
                    );
                }
    
                if ($validator->fails()) {
                    $error = $validator->errors()->all();
                    return redirect()->route('instructor.courses')->with('error-course','Unable to validate your data');
                }
    
                /**
                * Get locataion codinates / create location
                */ 
                if($request->location_selected == 'create_new'){
                    $address = $request->location_address.' '.$request->location_city.' '.$request->location_country;
                    $results = app("geocoder")
                        ->doNotCache()
                        ->geocode($address)
                        ->get();
                    $coordinates = $results[0]->getCoordinates();
    
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
                    $location_id = $request->selected_location;
                } 
                
                //Set files array
                $location = 'courses';
                $files = $this->upload($request->file('file_upload'),$location,'true');
    
                //Create Course
                $course = new Classes();
                $course->instructor_id = $user->id;
                $course->title = strip_tags($request->title);
                $course->description = strip_tags($request->description);
                $course->category_id = $request->category;
                $course->location_id = $location_id;
                $course->duration = $request->duration;
                $course->duration_type = $request->duration_type;
                $course->price = $request->price;
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
                    $date_times->max_capacity = $request->max_capacity[$key];
                    $date_times->save();
                }
    
                return redirect()->route('instructor.courses')->with('success-course','New Course added');
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            }
        }elseif($request->task == 'update'){
            try {
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description'  => 'required',
                    'price'=>'required',
                    'selected_location'=> 'required',
                  ],
                  [
                    'title.required' => 'Your title is Required', 
                    'description.required' => 'Your description is Required', 
                    'price.required'=> 'Your cost per seat is Required', 
                    'selected_location.required'=> 'Your location is Required', 
    
                  ]
                );
    
                if ($validator->fails()) {
                    $error = $validator->errors()->all();
                    return redirect()->route('instructor.courses')->with('error-course','Unable to validate your data');
                }
    
    
                /**
                * Get locataion codinates / create location
                */ 
                if($request->location_selected == 'create_new'){
                    $address = $request->location_address.' '.$request->location_city.' '.$request->location_country;
                    $results = app("geocoder")
                        ->doNotCache()
                        ->geocode($address)
                        ->get();
                    $coordinates = $results[0]->getCoordinates();
    
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
                    $location_id = $request->selected_location;
                } 
    
                //Adding course dates and times
                if(!empty($request->dates)){
                    foreach($request->dates as $key => $value){
                        $date_times = new ClassDate();
                        $date_times->class_id = $request->id;
                        $date_times->class_date = $value;
                        $date_times->start_at = $request->start_times[$key];
                        $date_times->end_at = $request->end_times[$key];
                        $date_times->max_capacity = $request->max_capacity[$key];
                        $date_times->save();
                    }
                }
                
    
                $course = Classes::where('_id',$request->id)->first();
                $course->instructor_id = $user->id;
                $course->title = strip_tags($request->title);
                $course->description = strip_tags($request->description);
                $course->category_id = $request->category;
                $course->location_id = $location_id;
                $course->duration = $request->duration;
                $course->duration_type = $request->duration_type;
                $course->price = $request->price;
                $course->level = $request->course_level;
                $course->save();
    
                return redirect()->route('instructor.courses')->with('success-course','New Course updated');
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            }
            
        }elseif($request->task == 'update_images'){
            //Set files array
            $location = 'courses';
            $files = $this->upload($request->file('file_upload'),$location,'true');
            
            //Get current images
            $course_images = Classes::where('_id',$request->id)->first();
            $current_photos = json_decode($course_images->photo_gallery,true);

            if(!empty(json_decode($files,true))){
                $gallery = array_merge(json_decode($files,true), $current_photos);
                $course_images->photo_gallery = json_encode($gallery);
                $course_images->save();
            }
            return redirect()->route('instructor.courses')->with('success-course','Update course images');
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
            try {
                $user = Auth::user();
                $bookings = array();
                $courses = Classes::where('instructor_id',$user->_id)->get();
                if($courses != null){
                    foreach($courses as $course){
                        $booking = Booking::where('class_id',$course->_id)->get();
                        if(!$booking->isEmpty()){
                            $bookings[$course->_id] = $booking;
                        }
                    }
                }
                return view('instructor.bookings', compact('bookings','user')); 
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            } 
        }
    }

    /**
     * Booking function
     */
    public function booking(string $id)
    {
        if(Auth::check()){
            try {
                $user = Auth::user();
                $booking = Booking::find($id);
                if($booking != null){
                    $course = Classes::find($booking->class_id);
                    if($course != null){
                        return view('instructor.booking', compact('booking','user'));
                    }
                }
                return redirect("instructor.bookings")->withSuccess('Trust me this is not belongs to you');
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            } 
        }
    }

    /**
     * Reviews function
     */
    public function reviews()
    {
        if(Auth::check()){
            try {
                $user = Auth::user();
                $reviewer =  Review::where('reviewer_id', $user->_id)->get();
                $receiver =  Review::where('receiver_id', $user->_id)->get();
                return view('instructor.reviews',compact('reviewer','receiver','user'));
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            } 
        } 
    }

    /**
     * Review function
     */
    public function review(string $id)
    {
        try {
            $user = Auth::user();
            $review = Review::where('_id', $id)->where('receiver_id', $user->_id)->firstOrFail();
            return view('instructor.review', compact('review','user'));
        } catch(\Exception $exception) {
            return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
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
                    
                    try {
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
                    } catch(\Exception $exception) {
                        return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
                    }  
                }else{
                    try {
                        Review::create([
                            'receiver_id' => $course->_id,
                            'reviewer_id' => $user->_id,
                            'class_id' => $request->class_id,
                            'rating' => $request->rating,
                            'comment' => $request->comment
                        ]);
                        return redirect()->route('instructor.reviews')->with('success','Review created successfully');
                    } catch(\Exception $exception) {
                        return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
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
                return view('instructor.account',compact('user')); 
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
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
                try {
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
                        return redirect()->route('instructor.account')->with('error-account','Unable to validate your data');
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
                        return redirect()->route('instructor.account')->with('success-account','Account updated successfully');
                    }
                } catch(\Exception $exception) {
                    return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
                } 
            }elseif($request->task == 'password'){
                try {
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
                        return redirect()->route('instructor.account')->with('error-password','Unable to validate your data');
                    }else{
                        $currentUser = User::find($request->id);
                        $currentUser->password = \Hash::make($password);
                        $currentUser->update(); //or $currentUser->save();
                        return redirect()->route('instructor.account')->with('success-password','Account updated successfully');
                    }
                } catch(\Exception $exception) {
                    return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
                } 
                
            }
        }
    } 

    public function location(string $id)
    {
        if(Auth::check()){
            try {
                $user = Auth::user();
                $location =  Location::where('user_id', $user->_id)->where('_id', $id)->firstOrFail();
                return view('instructor.location',compact('location','user'));
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            } 
        } 
    }

    public function updateLocation(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            if($request->task == 'create'){
                try {
                    $validator = Validator::make($request->all(), [
                        'location_name'=> 'required',
                        'location_address'=>'required',
                        'location_city'=>'required',
                      ],
                      [
                        'location_name.required'=> 'Your location name is Required', 
                        'location_address.required'=> 'Your address is Required', 
                        'location_city.required'=> 'Your city is Required', 
                      ]
                    );
                    if ($validator->fails()) {
                        $error = $validator->errors()->all();
                        return redirect()->route('instructor.locations')->with('error-location','Unable to validate your data');
                    }
    
                    $address = $request->location_address.' '.$request->location_city.' '.$request->location_country;
                    $results = app("geocoder")
                        ->doNotCache()
                        ->geocode($address)
                        ->get();
                    $coordinates = $results[0]->getCoordinates();
    
                    $location = Location::create([
                        'user_id' => $user->_id,
                        'name' => $request->location_name,
                        'address' => $request->location_address,
                        'city' => $request->location_city,
                        'country' => $request->location_country,
                        'latitude' => $coordinates->getLatitude(),
                        'longitude' => $coordinates->getLongitude(),
                    ]);
                    return redirect()->route('instructor.locations')->with('success-location','Created new location.');
                } catch(\Exception $exception) {
                    return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
                } 
            }else{
                try {
                    $validator = Validator::make($request->all(), [
                        'location_name'=> 'required',
                        'location_address'=>'required',
                        'location_city'=>'required',
                      ],
                      [
                        'location_name.required'=> 'Your location name is Required', 
                        'location_address.required'=> 'Your address is Required', 
                        'location_city.required'=> 'Your city is Required', 
                      ]
                    );
                    if ($validator->fails()) {
                        $error = $validator->errors()->all();
                        return redirect()->route('instructor.locations')->with('error-location','Unable to validate your data');
                    }
                    $location =  Location::where('user_id', $user->_id)->where('_id', $request->id)->first();
                    $location->name = $request->location_name;
                    $location->address = $request->location_address;
                    $location->city = $request->location_city;
                    $location->save();
                    return redirect()->route('instructor.locations')->with('success-location','Update location');
                } catch(\Exception $exception) {
                    return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
                } 
            }
        }        
    }

    /**
     * 
     */
    public function locations()
    {
        if(Auth::check()){
            try {
                $user = Auth::user();
                $locations =  Location::where('user_id', $user->_id)->get();
                return view('instructor.locations',compact('locations','user'));
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            } 
        } 
    }

    /**
     * Location function 
     */
    public function ajaxLocations(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            $location = Location::where('user_id', $user->_id)
                        ->where('_id', $request->location_id)
                        ->firstOrFail()->toArray();
            return response()->json([
                'status' => true,
                'message' => 'Location returns.',
                'data' => $location
            ], 200);              
        }
    }


    /**
     * Class Date delete function 
     */
    public function ajaxClassdateDelete(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            $class_dates = ClassDate::where('_id', $request->classdate_id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'deleted',
                'data' => 'deleted'
            ], 200);  
            
        }
    }

    /**
     * Given course id then return images
     */
    public function courseImage(string $id){
        if(Auth::check()){
            try {
                $user = Auth::user();
                $course_images = Classes::where('instructor_id',$user->_id)
                            ->where('_id',$id)
                            ->firstOrFail();
             
                return view('instructor.image',compact('course_images','user')); 
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            }           
        }

    }

    public function courseImageUpdate(Request $request)
    {
        if(Auth::check()){
              
            try {
                $user = Auth::user();
                //Set files array
                $location = 'courses';
                $files = $this->upload($request->file('file_upload'),$location,'true');
                $file_decode = json_decode($files,true);

                $course_images = Classes::where('user_id', $user->_id)
                            ->where('_id', $id)
                            ->firstOrFail()->toArray();

                if(!empty($course_images->photo_gallery)){
                    $course_images_updates = array_merge($file_decode, $course_images->photo_gallery);
                    $course_images->photo_gallery = json_encode($course_images_updates);
                    $course_images->save();
                }  
                        
                return redirect()->route('instructor/course', ['id' => $course_images->_id])->with('message', 'Images saved correctly!!!'); 
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            }    
        }
    }

    public function ajaxImage(Request $request){
        $input = $request->all();
        $user = Auth::user();
        //Current images
        $course_images = Classes::where('instructor_id', $user->_id)
                        ->where('_id', $request->id)
                        ->firstOrFail();

        //Image from request
        $getImages = $request->images;   
        
        $collection = array();
        
        foreach(json_decode($course_images->photo_gallery,true) as $file){
            if (!in_array($file['name'], $getImages)) {
                $collection[] = $file;
            }
        }

        $course_images->photo_gallery = json_encode($collection);
        $course_images->save();

        return response()->json([
            'status' => true,
            'message' => 'deleted',
            'data' => 'deleted'
        ], 200);  
    }


    public function qualifications(){
        try {
            $user = Auth::user();
            $qualifications = InstructorQualification::where('instructor_id', $user->_id)->get();
            return view('instructor.qualifications',compact('qualifications','user'));  
        } catch(\Exception $exception) {
            return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
        }    
    }

    public function ajaxQualificationDelete(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            $qualification = InstructorQualification::where('instructor_id', $user->_id)->where('_id',  $request->qualification_id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'deleted',
                'data' => 'deleted'
            ], 200);  
            
        }
    }

    public function updateQualification(Request $request){
        if($request->task == 'create'){
            try {
                $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'title'=> 'required',
                'description'=>'required',
              ],
              [
                'title.required'=> 'Your name is Required', 
                'description.required'=> 'Your description is Required', 
              ]
            );
            if ($validator->fails()) {
                $error = $validator->errors()->all();
                return redirect()->route('instructor.qualifications')->with('error-qualifications','Unable to validate your data');
            }


            $qulification = new InstructorQualification();
            $qulification->instructor_id = $user->_id;
            $qulification->title = $request->title;
            $qulification->description = $request->description;

            //Set files array
            $files = '';
            $location = 'users';
            if($request->hasFile('file_upload')){
                $files = $this->upload($request->file('file_upload'),$location,'true');
            }

            $qulification->photo_gallery = $files;
            $qulification->save();
            
            return redirect()->route('instructor.qualifications')->with('success-qualifications','Created new qualification.');
            } catch(\Exception $exception) {
                return redirect()->route('instructor.error')->with('error-page','Unable to find your request');
            }
        }
    }

    public function error(){
        return view('error.error'); 
    }

    public function generatePDF(String $id){
        $user = Auth::user();
        $booking =  Booking::where('_id', $id)->firstOrFail();
        $payment = '';

        if($booking->status){
            $payment = Payment::where('booking_id', $id)->firstOrFail();
            $fee = ($booking->payment->amount * 0.0375)+0.30;
            //10% admin commission
            $commission = ($booking->payment->amount - $fee)*0.1;
            $tutorpayment = $booking->payment->amount - $fee - $commission;
        }

        

        $data = ['booking' => $booking,'user'=>$user,'payment'=>$payment,'fee'=>$fee,'fee'=>$fee,'commission'=>$commission,'tutorpayment'=>$tutorpayment];
        $pdf = PDF::loadView('pdf.booking-pdf-Instructor', $data);
        $file = $booking->_id.'.pdf';
        return $pdf->download($file);

    }
}
