<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TransactionRecords;
use Illuminate\Http\Request;
use Stripe\Refund;
use Stripe\Stripe;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionRefundController extends Controller
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


        try {
            // Set your Stripe secret key
            Stripe::setApiKey(config('stripe.stripe_sk'));

            // Get the transaction ID and refund amount from the request
            $transactionId = $request->input('transaction_id');
            $amount = $request->input('amount');
            $reason = $request->input('notes');

            // Refund the payment using Stripe API
            $refund = Refund::create([
                'charge' => $transactionId,
                'amount' => $amount,
                'reason' => 'requested_by_customer',
            ]);

            $trasactionRecord = TransactionRecords::create([
                'user_id'=>$user->id,
                'payment'=>$amount,
                'transaction_id'=>$refund->id,
                'notes'=>$reason,
                'parent_trans_id'=>$transactionId,
                'method'=>1,
                'type_of_charge'=>1
            ]);

            // Return success response
            return response()->json(['message' => 'Refund successful', 'refund' => $refund]);

        } catch (\Exception $e) {
            // Return error response if refund fails
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
