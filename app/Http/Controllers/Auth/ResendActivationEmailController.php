<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserActivationMail;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResendActivationEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $user = Sentinel::findByCredentials(['login' => $request->input('email')]);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found.'
                ]);
            }

            // Check if there is an existing activation
            $activation = Activation::where('user_id', $user->id)->first();

            // Delete existing activation if found
            if ($activation) {
               $activation->delete();
            }

            // Create a new activation
            $newActivation = Activation::create($user);

            // Send activation email
            Mail::to($user->email)->send(new UserActivationMail($newActivation->code));

            return response()->json([
                'status' => true,
                'message' => 'Activation email sent successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }
}
