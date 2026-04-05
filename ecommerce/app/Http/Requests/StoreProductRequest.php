<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|alpha_dash|unique:products,slug,' . $productId,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $productId,
            'is_active' => 'sometimes|boolean',
        ];
    }
}
