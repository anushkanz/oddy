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
      $user = Auth::user();
      return view('administrator.dashboard',compact('user'));
    }

    /**
     * Categories function
     */
    public function categories()
    {

    }

    /**
     * category function
     */
    public function category(string $id)
    {

    }

    /**
     * Update category function
     */
    public function updateCategory(Request $request)
    {

    }

    /**
     * Courses function
     */
    public function courses()
    {

    }

    /**
     * Course function
     */
    public function course(string $id)
    {

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

    }

    /**
     * Member function
     */
    public function member(string $id)
    {

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

    }

    /**
     * Booking function
     */
    public function booking(string $id)
    {

    }
    
    /**
     * Reviews function
     */
    public function reviews()
    {

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

    }

    /**
     * Account function
     */
    public function account()
    {

    }

    /**
     * Update Account function
     */
    public function updateAccount(Request $request)
    {

    } 
}
