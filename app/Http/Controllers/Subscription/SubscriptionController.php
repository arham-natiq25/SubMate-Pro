<?php

namespace App\Http\Controllers\Subscription;

use App\Gateways\StripePaymentGateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SubscriptionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SubscriptionRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate(); // Access the authenticated user using JWT

        $plan = Plan::where('id',$request->plan['id'])->first();

        $payment = new StripePaymentGateway();

        $result = $payment->charge($request,$user);

        $type = ($request->type == 0) ? 0 : 1;
        if ($result->isSuccessful()){
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_uuid'=>$plan->id,
                'type'=>$type
            ]);
            $endDate = Carbon::now();
            if ($type === 0) {
                // If type is 0, add 30 days to the current date
                $endDate->addDays(30);
            } else {
                // If type is 1, add 365 days to the current date
                $endDate->addDays(365);
            }


            $UserSubscription = UserSubscription::create([
                'subscription_id'=>$subscription->id,
                'user_id'=>$user->id,
                'added_by'=>$user->id,
                'start_date'=> Carbon::now(),
                'end_date'=> $endDate
            ]);

            return $result;
        }


    }
}
