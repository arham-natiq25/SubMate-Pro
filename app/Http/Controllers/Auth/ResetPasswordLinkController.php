<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordLink;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResetPasswordLinkController extends Controller
{
   public function __invoke(Request $request)
   {
    $request->validate(['email' => 'required|email']);

    $user = Sentinel::findByCredentials(['email' => $request->input('email')]);

    if ($user) {
        $reminder = Sentinel::getReminderRepository()->create($user);
        // Mail::to($user->email)->send(new ResetPasswordLink($reminder->code));

        return response()->json([
            'status'=>true,
            'message'=>'Reset password link successfully'
        ]);

    }else {
        return response()->json([
            'status'=>false,
            'message'=>'User not found'
        ]);
    }

   }
}
