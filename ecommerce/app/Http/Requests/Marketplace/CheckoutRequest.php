<?php

namespace App\Http\Requests\Marketplace;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'nullable|string|max:50',
            'billing_address' => 'required|string|max:500',
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'nullable|string|max:50',
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
