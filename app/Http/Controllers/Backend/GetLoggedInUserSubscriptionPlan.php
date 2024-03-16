<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetLoggedInUserSubscriptionPlan extends Controller
{
    public function __invoke(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $subscription = Subscription::where('user_id', $user->id)->first();

        if ($subscription) {
            $plan = Plan::where('id', $subscription->plan_uuid)->first();
            if ($subscription->type === 0) {
                $price = $plan->monthly_price;
            } elseif ($subscription->type === 1) {
                $price = $plan->year_price;
            }
            return response()->json([
                'success'=>true,
                'price'=>$price,
                'plan'=>$plan
            ]);
        } else {

            return response()->json([
                'success'=>false,
                'message'=>'Somethings went wrong'
            ]);
        }
    }

}
