<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserSubscriptionVerifyController extends Controller
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

        if ($user) {
            # code...
            $userSubscription = UserSubscription::where('end_date','>=',Carbon::now())->where('user_id',$user->id)->latest()->first();

            if ($userSubscription) {
                    return response()->json(['has_subscription' => true]);
             } else {
                    return response()->json(['has_subscription' => false]);
                }
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }
}
