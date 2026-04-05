<?php

namespace App\Http\Requests\Marketplace;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
        ];
    }
}
