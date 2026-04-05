<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactInquiryRequest;
use App\Models\ContactInquiry;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.index');
    }

    public function store(StoreContactInquiryRequest $request)
    {
        ContactInquiry::create($request->validated() + ['user_id' => optional($request->user())->id]);

        return back()->with('success', __('messages.contact_sent'));
    }
}
