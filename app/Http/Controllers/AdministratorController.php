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

class AdministratorController extends Controller
{
    /**
     * Dashboard function
     */
    public function dashboard()
    {
      if(Auth::check()){
        $user = Auth::user();
        return view('administrator.dashboard',compact('user'));
      }
    }

    /**
     * Categories function
     */
    public function categories(string $id = null)
    {
      if(Auth::check()){
        $categories = Category::all();
        $user = Auth::user();
        return view('administrator.categories', compact('categories','user')); 
      
      }
    }

    /**
     * category function
     */
    public function category(string $id)
    {
      if(Auth::check()){
        $category = Category::where('id', $id)->first();
        $user = Auth::user();
        return view('administrator.category', compact('category','user'));
      }
    }

    /**
     * Create / Update category function
     */
    public function updateCategory(Request $request)
    {
      if(Auth::check()){
        $user = Auth::user();
        $request->validate([
          'name' => 'required',
          'description' => 'required',
          'slug'=>'required'
        ]);

        if($request->task == 'update'){
          $category = Category::find($request->id);
          if($category)
          {
            $category->update($request->all());
            return redirect()->route('administrator.categories')->with('success','Category updated successfully');
          }
        }else{
          Category::create($request->all());
          return redirect()->route('administrator.categories')->with('success','Category created successfully');
        }
      }
    }

    /**
     * Courses function
     */
    public function courses()
    {
      if(Auth::check()){
        $courses = Classes::all();
        $user = Auth::user();
        return view('administrator.courses', compact('courses','user')); 
      }
    }

    /**
     * Course function
     */
    public function course(string $id)
    {
      if(Auth::check()){
        $course = Classes::find($id);
        $user = Auth::user();
        return view('administrator.course', compact('course','user'));
      }
    }

    /**
     * Update Course function
     */
    public function updateCourse(Request $request)
    {

    }

    /**
     * Payments function
     */
    public function payments()
    {
      if(Auth::check()){
        $payments =  Payment::all();
        $user = Auth::user();
        return view('administrator.payments',compact('payments','user'));
      } 
    }

    /**
     * payments function
     */
    public function payment(string $id)
    {

    }

    /**
     * Update payments function
     */
    public function updatePayments(Request $request)
    {

    }


    /**
     * Members function
     */
    public function members()
    {
      if(Auth::check()){
        $users =  User::all();
        $user = Auth::user();
        return view('administrator.members',compact('users','user'));
      } 
    }

    /**
     * Member function
     */
    public function member(string $id)
    {
      if(Auth::check()){
        $user_edit = User::find($id);
        $user = Auth::user();
        return view('administrator.member', compact('user_edit','user'));
      } 
    }

    /**
     * Update Members function
     */
    public function updateMembers(Request $request)
    {

    }

    /**
     * Bookings function
     */
    public function bookings()
    {
      if(Auth::check()){
          $bookings =  Booking::all();
          $user = Auth::user();
          return view('administrator.bookings',compact('bookings','user'));
      } 
    }

    /**
     * Booking function
     */
    public function booking(string $id)
    {
      if(Auth::check()){
        $booking = Booking::find($id);
        $user = Auth::user();
        return view('administrator.booking', compact('booking','user'));
      }
    }
    
    /**
     * Reviews function
     */
    public function reviews()
    {
      if(Auth::check()){
          $reviews =  Review::all();
          $user = Auth::user();
          return view('administrator.reviews',compact('reviews','user'));
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
          return view('administrator.review', compact('review','user'));
        
      }
    }

    /**
     * Update Reviews function
     */
    public function updateReviews(Request $request)
    {
      if(Auth::check()){
          $user = Auth::user();
          if($user->type == 'admin'){
              $request->validate([
                  'class_id'=>'required',
                  'rating'=>'required',
                  'comment'=>'required'
              ]);
              if($request->task == 'update'){
                  $review = Review::find($request->id);
                  if($review)
                  {
                      $review->receiver_id = $request->receiver_id;
                      $review->reviewer_id = $request->reviewer_id;
                      $review->class_id = $request->class_id;
                      $review->rating = $request->rating;
                      $review->comment = $request->comment;
                      $review->save();
                      return redirect()->route('administrator.reviews')->with('success','Review updated successfully');
                  }
              }else{
                  Review::create([
                      'receiver_id' => $request->receiver_id,
                      'reviewer_id' => $request->reviewer_id,
                      'class_id' => $request->class_id,
                      'rating' => $request->rating,
                      'comment' => $request->comment
                  ]);
                  return redirect()->route('administrator.reviews')->with('success','Review created successfully');
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
          $user = Auth::user();
          return view('administrator.account',compact('user'));
      } 
    }

    /**
     * Update Account function
     */
    public function updateAccount(Request $request)
    {
      if(Auth::check()){
        $user = Auth::user();
        if($user->type == 'admin'){
            if($request->task == 'details'){
                $request->validate([
                    'name' => 'required',
                    'email'  => 'required|string|email|max:255|unique:users,email,' . $request->id,
                    'phone'=>'required'
                ]);
                if ($validator->fails()) {
                    $error = $validator->errors()->all();
                    return redirect()->route('administrator.account')->with('error','Unable to validate your data');
                }
                $currentUser = User::find($request->id);
                if($currentUser)
                {
                    $currentUser->name = $request->name;
                    $currentUser->email = $request->email;
                    $currentUser->phone = $request->phone;
                    $currentUser->save();
                    return redirect()->route('administrator.account')->with('success','Account updated successfully');
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
                    return redirect()->route('administrator.account')->with('error','Unable to validate your data');
                }else{
                    $currentUser = User::find($request->id);
                    $currentUser->password = \Hash::make($password);
                    $currentUser->update(); //or $currentUser->save();
                    return redirect()->route('administrator.account')->with('success','Account updated successfully');
                }
            }
        }
      }
    } 
}
