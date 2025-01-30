<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class CustomAuthController extends Controller
{
    public function customLogin(Request $request)
    {
        $validator =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }else{
            $validator['emailPassword'] = 'Email address or password is incorrect.';
            return response()->json([
                'status' => true,
                'message' => $validator,
                'data' => ''
            ], 200);
        }
    }
}