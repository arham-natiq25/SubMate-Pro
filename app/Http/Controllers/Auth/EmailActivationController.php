<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmailActivationController extends Controller
{
    function __invoke($token)
    {
        $activation = Activation::where('code',$token)->first();

        if(!$activation){
            return response()->json([
                'status'=>false,
                'message'=>'Email Link Expires or not found'
            ]);
        }


        if ($activation) {

            $userId = $activation->user_id;

        if (!$userId) {
            return response()->json([
                'status'=>false,
                'message'=>'User not found'
            ]);
        }

        $user = Sentinel::findUserById($userId);


        if ($user) {
            Activation::complete($user, $token);
            // Session::forget('registered_user');
            // Sentinel::login($user);
            return  response()->json([
                'status'=>true,
                'message'=>'Your Activation is successfully Completed'
            ]);
        } else {
            return  response()->json([
                'status'=>false,
                'message'=>'User Not found'
            ]);

        }


    }

    }
}
