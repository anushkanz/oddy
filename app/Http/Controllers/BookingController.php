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

class BookingController extends Controller
{
    /**
     * Loading with course id
     * Then after select class date, Then create booking
     * No payment id 
     * Status 0 (0 mean not confirmed)
     */
    public function booking(String $id){

    }

    /**
     * Loding with booking id
     * Then take payment, then if payment success / unsuccess, update booking
     * if success payment then status 1, mean booking confirmed
     * Then -1 on available seat
     */
    public function checkout(String $id){
        
    }
}