<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class HasSubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate(); // Access the authenticated user using JWT

        if ($user) {
            $userSubscription = UserSubscription::where('end_date','>=',Carbon::now())->where('user_id',$user->id)->latest()->first();

            if($userSubscription){
                return $next($request);
            }
        }
        return redirect()->back();
    }
}
