<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\Transporter;
use Illuminate\Support\Facades\Auth;
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
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
          return redirect()->intended('dashboard')->withSuccess('Signed in');
        }
        $validator['emailPassword'] = 'Email address or password is incorrect.';
        return redirect("/")->withErrors($validator);
    }
}