<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetPaymentAPIKeyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $primary_key = config('stripe.stripe_pk');

        return response()->json([
            'stripe_pk'=>$primary_key
        ]);
    }
}
