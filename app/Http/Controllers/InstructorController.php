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
            return view('instructor.courses', compact('courses','user')); 
        
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
            return view('instructor.course', compact('course','user'));

        }
    }

    /**
     * Update Course function
     */
    public function updateCourse(Request $request)
    {

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
            return view('instructor.reviews',compact('reviews','receiver','user'));
        } 
    }

    /**
     * Review function
     */
    public function review(string $id)
    {
        if(Auth::check()){
            $user = Auth::user();
            $review = Review::find($id);
            return view('instructor.review', compact('review','user'));
            
        }
    }

    /**
     * Update Reviews function
     */
    public function updateReviews(Request $request)
    {
        
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
                $request->validate([
                    'name' => 'required',
                    'email'  => 'required|string|email|max:255|unique:users,email,' . $request->id,
                    'phone'=>'required'
                ]);
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
