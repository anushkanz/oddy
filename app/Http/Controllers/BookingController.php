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
use Stripe;
use Config;

class BookingController extends Controller
{
    /**
     * Loading with course id
     * Then after select class date, Then create booking
     * No payment id 
     * Status 0 (0 mean not confirmed)
     */
    public function booking(String $id){
        //Check booking status
        $user = Auth::user();
        $class =  Classes::where('_id', $id)->firstOrFail();
        

        if(empty($class)){
            return redirect()->intended('booking/status/{$id}/noclass');
        }
        
        if(empty($user)){
            $message = "Need to login for doing booking.";
            return redirect()->route('login')->with('message', $message);
        }

        //create booking
        $booking = Booking::create([
            'user_id' => $user->_id,
            'class_id'=> $id,
            'payment_id' => '',
            'status'=> 0,
            'class_date_id'  => '',
        ]);

        return redirect()->intended('booking/cart/'.$booking->_id);
        //return view('student.booking.checkout',compact('booking','user'));
    }

    public function bookingCart(String $id){
        $user = Auth::user();
        $booking =  Booking::where('_id', $id)->where('user_id', $user->_id)->firstOrFail();
        $course_dates = ClassDate::where('class_id', $booking->class_id)->get();
        
        return view('booking.cart',compact('booking','user','course_dates'));
    }

    public function updateBooking(Request $request){
        $booking_id = $request->booking_id;
        $user_id = $request->user_id;
        $class_date_id = $request->class_date_id;

        $request->validate([
            'class_date_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'class_date_id' => 'required',
          ],
          [
            'class_date_id.required' => 'Class date is required', 
          ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withErrors($validator)->withInput();
        }

        $booking =  Booking::where('_id', $booking_id)->where('user_id', $user_id)->firstOrFail();
        
        if(!empty($booking) && ($booking->status == 0)){
            $booking-> class_date_id = $class_date_id;
            $booking->update();
        }

        return redirect()->intended('booking/checkout/'.$booking_id);

    }

    /**
     * Loding with booking id
     * Then take payment, then if payment success / unsuccess, update booking
     * if success payment then status 1, mean booking confirmed
     * Then -1 on available seat
     */
    public function checkout(String $id){
        $user = Auth::user();
        $booking =  Booking::where('_id', $id)->where('user_id', $user->_id)->firstOrFail();
        return view('booking.checkout',compact('booking','user'));
    }

    public function updateCheckout(Request $request){
        $user = Auth::user();
        $booking =  Booking::where('_id', $request->booking_id)->where('user_id', $request->user_id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'cardNumber' => 'required',
            'cardholderName' => 'required',
            'expMonth' => 'required',
            'expYear' => 'required',
            'cvc' => 'required',
            'amount' => 'required',
        ]);
        
        $input = $request->all();
        dd($input);
        if ($validator->fails()) {
            $error = $validator->errors()->all();
            //return redirect()->route('instructor.courses')->with('error','Unable to validate your data');
            return back()->withErrors($validator)->withInput();
        }
        
        $stripe_key = Config::get('services.stripe');
        Stripe\Stripe::setApiKey($stripe_key['secret']);

        

        //Transfering transaction fee to Student
        $amount = $request->amount;
        // $fee_percentage = 0.963; // Change this value to set the desired fee percentage
        // $payment_processing_fee =  (($amount + 0.3)/0.963) - $amount;
        // $charge = round($amount + $payment_processing_fee, 2);

        $booking_description = '#'.$booking->_id.' '.$booking->classes->title;
        $payment = Stripe\Charge::create ([
            "amount" => $amount * 100,
            "currency" => "nzd",
            "source" => $request->stripeToken,
            "description" => $booking_description, 
        ]);

        //If payment get result then base on return save and send message
        if($payment->id){
            $payment_add = new Payment();
            $payment_add->booking_id = $booking->_id;
            $payment_add->transaction_id = $payment->id;
            $payment_add->status = $payment->status;
            $payment_add->amount = $amount;
            $payment_add->transaction_return = json_encode($payment);
            $payment_add->payment_method = "Stripe";
            $payment_add->save();
            $payment_id = $payment_add->id;

            return redirect()->intended('booking/status/'.$id.'/success');   
        }
        
    }

    public function bookingStatus(String $id, String $status){
        $user = Auth::user();
        $booking =  Booking::where('_id', $id)->where('user_id', $user->_id)->firstOrFail();
        return view('booking.status',compact('booking','user','status'));
    }
}