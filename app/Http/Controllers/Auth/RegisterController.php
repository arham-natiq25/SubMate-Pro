<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserActivationMail;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    function __invoke(Request $request)
    {
        $request->validate([
            'first_name'=>'required|string|max:255|min:3|alpha',
            'last_name'=>'required|string|max:255|min:3|alpha',
            'email'=>'required|unique:users,email|email',
            'password'=>'required|min:8|max:20|confirmed',
        ]);


        $user =  Sentinel::register([

            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        $activation = Activation::create($user);

        if ($user) {
            $mail = Mail::to($user->email)->send(new UserActivationMail($activation->code));

            if ($mail) {
                return response()->json([
                    'status'=>true,
                    'message'=>"Mail Send successfully"
                ]);
            }else{
                return response()->json([
                    'status'=>true,
                    'message'=>"Something went wrong"
                ]);

            }
         }else {
            return response()->json([
                'status'=>true,
                'message'=>"Something went wrong while creating your account"
            ]);
         }

    }
}
