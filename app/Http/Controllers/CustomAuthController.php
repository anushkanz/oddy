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

class CustomAuthController extends Controller
{
    /**
     * Welcome / Login Screen
     */

    public function index()
    {
        return view('auth.login');
    }

    /**
     * Login function
     */

    public function customLogin(Request $request)
    {
       $validator =  $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
          return redirect()->intended('dashboard')->withSuccess('Signed in');
        }
        $validator['emailPassword'] = 'Email address or password is incorrect.';
        return redirect("/")->withErrors($validator);
    }

    /**
     * Logout function
     */

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('/');
    }

    /**
     * Dashboard function
     */

    public function dashboard()
    {
        if(Auth::check()){
            $user = Auth::user();
            //Based on user type redirect to different dashboard
            if($user->role == 'admin'){
                return redirect()->intended('administrator/dashboard')->withSuccess('Signed in');
            }
            if($user->role == 'instructor'){
                //return view('transporter.dashboard');
                return redirect()->intended('instructor/dashboard');
            }
            if($user->role == 'student'){
                return redirect()->intended('student/dashboard');
                //return view('customer.dashboard', compact('user'));  
            }
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function forgetPassword(){

    }
}