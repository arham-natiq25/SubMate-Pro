<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class PasswordUpdateController extends Controller
{
    function __invoke(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|min:8|max:20|confirmed'
        ]);

        $reminder = Reminder::where('code', $token)->first();

        if ($reminder && !$reminder->completed) {
            $user = Sentinel::findById($reminder->user_id);

            if ($user) {
                $result = Reminder::complete($user, $token, $request->password);

                if ($result) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Password updated successfully'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to update password'
                    ], 500);
                }
            }

            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => false,
            'message' => 'Link has expired or already used. Request a new link.'
        ], 400);
    }
}
