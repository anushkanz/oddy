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
        $user = Auth::user();   
        return view('student.dashboard',compact('user'));
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
