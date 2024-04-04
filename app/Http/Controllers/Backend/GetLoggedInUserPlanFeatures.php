<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetLoggedInUserPlanFeatures extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $subscribedPlanFeature = $user->subscriptions()->with('subscription.plan.plan_feature.feature')->first();

        return response()->json([
            'user'=>$subscribedPlanFeature
        ]);
    }
}
