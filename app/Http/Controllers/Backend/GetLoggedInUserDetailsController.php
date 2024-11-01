<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetLoggedInUserDetailsController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $user = User::with('subscriptions.subscription.plan')->where('id',$user->id)->first();


        return response()->json($user);
    }
}
