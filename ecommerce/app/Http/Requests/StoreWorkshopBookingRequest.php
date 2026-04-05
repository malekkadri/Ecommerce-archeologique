<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkshopBookingRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'workshop_id' => 'required|exists:workshops,id',
            'seats' => 'required|integer|min:1|max:10',
        ];
    }
}
