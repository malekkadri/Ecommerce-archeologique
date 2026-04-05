<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactInquiryController extends Controller
{
    public function index()
    {
        $items = ContactInquiry::latest()->paginate(15);
        return view('admin.shared-index', ['items' => $items, 'title' => 'ContactInquiry']);
    }

    public function create() { return view('admin.shared-form', ['title' => 'ContactInquiry']); }
    public function store(Request $request) { return back()->with('success', __('messages.saved')); }
    public function show(ContactInquiry $item) { return view('admin.shared-show', ['item' => $item, 'title' => 'ContactInquiry']); }
    public function edit(ContactInquiry $item) { return view('admin.shared-form', ['item' => $item, 'title' => 'ContactInquiry']); }
    public function update(Request $request, ContactInquiry $item) { return back()->with('success', __('messages.updated')); }
    public function destroy(ContactInquiry $item) { $item->delete(); return back()->with('success', __('messages.deleted')); }
}
