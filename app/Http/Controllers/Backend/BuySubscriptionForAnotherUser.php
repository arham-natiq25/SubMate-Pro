<?php

namespace App\Http\Controllers\Backend;

use App\Gateways\StripePaymentGateway;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class BuySubscriptionForAnotherUser extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $LoggedInUser = JWTAuth::parseToken()->authenticate();
        $subscription = Subscription::where('user_id',$LoggedInUser->id)->first();
        $request->validate([
            'NewUserEmail'=>'required|email',
            'method'=>'required',
            'price'=>'required',
            'plan'=>'array'
        ]);
        $charge = new StripePaymentGateway();
        $result = $charge->charge($request,$LoggedInUser);

        $type=$request->type;

        if ($result->isSuccessful()){
            $endDate = Carbon::now();
            if ($type === 0) {
                // If type is 0, add 30 days to the current date
                $endDate->addDays(30);
            } else {
                // If type is 1, add 365 days to the current date
                $endDate->addDays(365);
            }

            $user = User::where('email',$request->NewUserEmail)->first();


            $UserSubscription = UserSubscription::create([
                'subscription_id'=>$subscription->id,
                'user_id'=>$user->id,
                'added_by'=>$LoggedInUser->id,
                'start_date'=> Carbon::now(),
                'end_date'=> $endDate
            ]);
            return $result;
        }
    }
}
