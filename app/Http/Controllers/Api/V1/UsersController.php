<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Mail; 

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user == null){
            $user_created = User::create([
                    'name' => $request->name,
                    'phone'=> $request->phone,
                    'email' => $request->email,
                    'status'=> $request->status,
                    'password'=> Hash::make($request->password),
            ]);
                
            //After create user send email to given email address with code    
            $token = Str::random(64);

            UserVerify::create([
                  'user_id' => $user_created->id, 
                  'token' => $token
                ]);
            
            //Send Welcome email
            $verifyUser = UserVerify::where('user_id', $user_created->id)->first();
            //$user->notify(new UserWelcomeMailNotification($user));
                      
            //If role == tutor then create tutor profile
            if($request->role == 'tutor'){
                $tutor_created = Instructor::create([
                    'user_id' => $user_created->_id,
                    'name'=> $request->name,
                    'bio' => $request->bio,
                    'skills'=> $request->skills,
                    'profile_picture'=> $request->profile_picture
                ]); 
            }    
            $return = array('user'=>$user_created);
            
            return response()->json([
                'status' => true,
                'message' => 'Customer created successfully',
                'data' => $return
            ], 201);

        }else{

            return response()->json([
                'status' => false,
                'message' => 'Email address already in our system',
                'data' => ''
            ], 202);

        }
    }
}