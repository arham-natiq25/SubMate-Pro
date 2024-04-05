<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetLoggedInUserTeamMembers extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $Logged_user = JWTAuth::parseToken()->authenticate();


        $userSubscriptions = $Logged_user->addedUserSubscriptions()->with('user','subscription.plan.plan_feature.feature')->get();

        return response()->json([
            'logged_in_user' => $Logged_user,
            'team_members' =>$userSubscriptions
        ]);
    }
}
