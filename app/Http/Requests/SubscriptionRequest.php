<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'paymentMethodId' => 'required|string',
            'type' => 'required|boolean',
            'plan.id' => 'required',
            'plan.name' => 'required|string',
            'plan.short_description' => 'required|string',
            'plan.monthly_price' => 'required|numeric',
            'plan.year_price' => 'required|numeric',
            'plan.trial' => 'required|boolean',
            'method' => 'required|integer',
        ];
    }
}
