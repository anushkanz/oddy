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
use App\Models\PasswordResetToken;
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
        // Validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        // Find user first
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !\Hash::check($request->password, $user->password)) {
            return redirect("/")->withErrors(['emailPassword' => 'Email or password is incorrect.']);
        }
    
        // Check if user is inactive
        if ($user->status == 0) {
            return redirect("/")->withErrors(['emailPassword' => 'Your account is inactive. Please contact support.']);
        }
    
        // Attempt login
        if (Auth::attempt($credentials)) {
            if($user->role == 'admin'){
                return redirect()->intended('administrator/dashboard')->withSuccess('Signed in');
            }
            if($user->role == 'tutor'){
                //return view('transporter.dashboard');
                return redirect()->intended('instructor/dashboard');
            }
            if($user->role == 'customer'){
                return redirect()->intended('student/dashboard');
                //return view('customer.dashboard', compact('user'));  
            }
            //return redirect()->intended('dashboard')->withSuccess('Signed in');
        }
    
        return redirect("/")->withErrors(['emailPassword' => 'Login failed. Please try again.']);
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
        return redirect("/")->withSuccess('You are not allowed to access');
    }


    public function forgetPassword(){
        return view('auth.forget_password');
    }


    public function forgetPasswordPost(Request $request){
        $user = User::where('email',$request->email)->firstOrFail();
       
        if (!empty($user) && (count($user->toArray()) < 1)) {
            $validator = "If this email address in our system, You will get email to how to reset password.";
            return redirect("forget_password")->withErrors($validator);
        }

        //Create Password Reset Token
        $reset_token = PasswordResetToken::create([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);
        
        $tokenData = PasswordResetToken::where('email',$request->email)->get();

        //$user->notify(new UserForgetPasswordMailNotification($user,$tokenData));
        $validator = "A reset link has been sent to your email address.";
        return redirect("forget_password")->withSuccess($validator);

    }

    public function resetPassword(){
        return view('auth.reset_password');
    }
    
    public function resetPasswordPost(Request $request){
        $password = $request->password;// Validate the token
        // Redirect the user back to the password reset request form if the token is invalid
        $tokenData = PasswordResetToken::where('token',$request->token)->count();    
        $validator = Validator::make($request->all(), 
            [
                'password' => 'required|confirmed|min:9',
                'password_confirmation' => 'required'
            ],
            [
                'password.required' => 'Your password is Required', 
                'password_confirmation.required' => 'Your password confirmation is Required', 
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return redirect("forget_password")->withErrors($error);
        }
            
        if ($tokenData< 1) {
            $validator = "Password reset token is invalid.";
            return redirect("forget_password")->withErrors($validator);
        }

        $userCount = User::where('email', $request->email)->count();
   
        // Redirect the user back if the email is invalid
        if ($userCount < 1){
            $validator = "Email addaress is not valid";
            return redirect("forget_password")->withErrors($validator);
        }
        
        $user = User::where('email', $request->email)->first();
        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        Auth::login($user);

        //Delete the token
        //DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        
        //Send Email Reset Success Email
        //$user->notify(new UserResetPasswordSuccessfullyMailNotification($user));
        $validator = "Password reset successfully.";
        return redirect("login")->withSuccess($validator);

    }


    public function verifyAccount($token){
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = 'Sorry your email cannot be identified.';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->email_verified_at = Carbon::now();
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

      return redirect()->route('login')->with('message', $message);
    }

    public function sendEmailVerification(Request $request){
        $id = $request->id;
        $verifyUser = UserVerify::where('user_id', $id)->first();
        $user = User::where('id',$id)->firstOrFail();
        //$user->notify(new UserEmailVerificationMailNotification($user,$userVerifiy));
        
        /**
         * TO DO : NEED SUITABLE ACTION AFTER SEND EMAIL
         **/ 
        return $user;
        
    }

    public function registration(){
        return view('auth.registration');
    }

    public function customRegistration(Request $request){
        
        if(($request->type == 'student') || ($request->type == 'tutor')){
            //Registration role change based on type, only accept student or tutor
            $user = User::where('email', $request->email)->first();
            
            if($user == null){
            
                $this->validate($request, [
                    'name' => 'required|min:3|max:50',
                    'email' => 'email',
                    'mobile' => 'required',
                    'password' => 'min:10|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'min:10'
                ]);
                
                $user_created = User::create([
                    'name' => $request->name,
                    'phone'=> $request->mobile,
                    'email' => $request->email,
                    'status'=> 1,
                    'role'  => $request->type,
                    'password'=> Hash::make($request->password),
                    'photo_gallery'=>''
                ]);

                //After create user send email to given email address with code    
                $token = Str::random(64);

                UserVerify::create([
                    'user_id' => $user_created->id, 
                    'token' => $token
                ]);

                $verifyUser = UserVerify::where('user_id', $user_created->id)->first();
                //$user_created->notify(new UserEmailVerificationMailNotification($user_created,$verifyUser));

                return redirect()->intended('/')->withSuccess('Successfully sign up');
            } 
        }    
    }

}