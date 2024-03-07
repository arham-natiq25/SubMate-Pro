<?php

namespace App\Gateways;

use App\Interfaces\PaymentGateway;

class StripePaymentGateway implements PaymentGateway
{
    public function charge($request)
    {
        dd('stripe called');
    }
}
