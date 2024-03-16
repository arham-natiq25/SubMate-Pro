<?php

namespace App\Gateways;

use App\Interfaces\PaymentGateway;
use App\Models\CustomerProfile;
use App\Models\TransactionRecords;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class StripePaymentGateway implements PaymentGateway
{
    public function charge($request,$user)
    {
       Stripe::setApiKey(config('stripe.stripe_sk'));

       if ($request->method===0) {
        $paymentMethodId = $request->paymentMethodId;
        }
        elseif ($request->method===1) {
            $paymentMethodId= $request->card['payment_method_id'];
            $stripeCustomer=$request->card['customer_profile_id'];
        }
        $paymentMethod = PaymentMethod::retrieve($paymentMethodId);

        $cardType = $paymentMethod->card->brand;

        $lastFourDigits = $paymentMethod->card->last4;

        $price = ($request->type == 0) ? $request->plan['monthly_price'] : $request->plan['year_price'];


        try {

            if ($request->method===0) {
                $stripeCustomer = Customer::create([
                    'email' => $request->email,
                    'name' => $request->name,
                    'payment_method' => $paymentMethodId,
                ]);
            }

            $intent = PaymentIntent::create([
                'payment_method' => $paymentMethodId,
                'amount' => $price * 100, // Set the amount to be charged (in cents)
                'currency' => 'usd',
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => 'https://127.0.0.1:8000',
                'customer' => $stripeCustomer,
            ]);

            $chargeId = $intent->latest_charge;

            if($request->method===0){
                CustomerProfile::create([
                    'user_id'=>$user->id,
                    'last_four_digit'=>$lastFourDigits,
                    'card_brand'=>$cardType,
                    'customer_profile_id'=>$stripeCustomer->id,
                    'payment_method_id'=>$paymentMethodId,
                    'method'=>1
                ]);
            }
            TransactionRecords::create([
                'user_id'=>$user->id,
                'payment'=>$price,
                'transaction_id'=>$chargeId,
                'method'=>1
            ]);

            return response()->json(['success' => true, 'message' => 'Payment successfully received, Your subscription is Created']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

    }
}
