<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|alpha_dash',
            'body' => 'required|string',
            'type' => 'required|in:recipe,article,tradition,ingredient,nutrition',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'is_featured' => 'nullable|boolean',
        ];
    }
}
