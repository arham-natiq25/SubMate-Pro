<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    function __invoke(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        try {
            // user from User Model
            $user = Sentinel::findByCredentials($credentials);

            // user from Eloquent User

            if ($user) {
                // check weather the user is activated or not
                if (Activation::completed($user)) {

                    $userSubscription = UserSubscription::where('end_date','>=',Carbon::now())->where('user_id',$user->id)->latest()->first();
                    if ($userSubscription) {
                        $subscription = true;
                    }else{
                        $subscription = false;
                    }
                    // Authenticate successfull
                    $token = JWTAuth::attempt([
                        'email' => $request->email,
                        'password' => $request->password
                    ]);
                    // if token is not empty make sure user is authenticated and success is true now
                    if (!empty($token)) {
                        return response()->json([
                            'status' => true,
                            'message' => "User logged in Successfully",
                            'token' => $token,
                            'subscription'=>$subscription
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => "Invalid Credentials"
                        ]);
                    }
                } // account not activated
                else {
                    return response()->json([
                        'status' => false,
                        'message' => "Your account is not activated"
                    ]);
                }
            } else {
                // user not found
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Credentials , User not found"
                ]);
            }
        } // thorthle for multiple tries
        catch (ThrottlingException $e) {
            return response()->json([
                'status' => false,
                'message' => "Too many attempts , Please try again later"
            ]);
        }
    }
}
