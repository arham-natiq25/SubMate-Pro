<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CustomerProfile;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetCustomerCardsController extends Controller
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

        $userId = $user->id;

        $cards = CustomerProfile::where('user_id',$userId)->get();


        if ($cards){
            return response()->json([
                'success'=>true,
                'cards'=>$cards
            ]);
        }else{
            return response()->json([
                'success'=>false,
            ]);
        }


    }
}
