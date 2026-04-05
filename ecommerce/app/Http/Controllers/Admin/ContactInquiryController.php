<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactInquiryController extends Controller
{
    public function index(Request $request)
    {
        $items = ContactInquiry::with('user')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim((string) $request->q);
                $query->where('name', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%')
                    ->orWhere('subject', 'like', '%' . $term . '%');
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.shared-index', [
            'items' => $items,
            'title' => 'Contact inquiries',
            'routePrefix' => 'admin.contact-inquiries',
            'columns' => [
                ['label' => 'Name', 'key' => 'name'],
                ['label' => 'Email', 'key' => 'email'],
                ['label' => 'Type', 'key' => 'inquiry_type'],
                ['label' => 'Status', 'key' => 'status'],
                ['label' => 'Created', 'key' => 'created_at', 'type' => 'datetime'],
            ],
        ]);
    }

    public function create()
    {
        return view('admin.shared-form', [
            'title' => 'Create Inquiry',
            'routePrefix' => 'admin.contact-inquiries',
            'method' => 'POST',
            'item' => new ContactInquiry(),
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        ContactInquiry::create($this->validated($request));

        return redirect()->route('admin.contact-inquiries.index')->with('success', __('messages.saved'));
    }

    public function show(ContactInquiry $contact_inquiry)
    {
        $contact_inquiry->load('user');

        return view('admin.shared-show', [
            'title' => 'Inquiry details',
            'routePrefix' => 'admin.contact-inquiries',
            'item' => $contact_inquiry,
            'displayFields' => [
                ['label' => 'Name', 'key' => 'name'],
                ['label' => 'Email', 'key' => 'email'],
                ['label' => 'User', 'key' => 'user.name'],
                ['label' => 'Type', 'key' => 'inquiry_type'],
                ['label' => 'Subject', 'key' => 'subject'],
                ['label' => 'Message', 'key' => 'message', 'type' => 'multiline'],
                ['label' => 'Status', 'key' => 'status'],
            ],
        ]);
    }

    public function edit(ContactInquiry $contact_inquiry)
    {
        return view('admin.shared-form', [
            'title' => 'Edit Inquiry',
            'routePrefix' => 'admin.contact-inquiries',
            'method' => 'PUT',
            'item' => $contact_inquiry,
            'fields' => $this->fields(),
        ]);
    }

    public function update(Request $request, ContactInquiry $contact_inquiry)
    {
        $contact_inquiry->update($this->validated($request));

        return redirect()->route('admin.contact-inquiries.edit', $contact_inquiry)->with('success', __('messages.updated'));
    }

    public function destroy(ContactInquiry $contact_inquiry)
    {
        $contact_inquiry->delete();

        return redirect()->route('admin.contact-inquiries.index')->with('success', __('messages.deleted'));
    }

    private function fields()
    {
        return [
            ['name' => 'user_id', 'label' => 'User (optional)', 'type' => 'select', 'options' => User::orderBy('name')->pluck('name', 'id')->toArray()],
            ['name' => 'inquiry_type', 'label' => 'Inquiry type', 'type' => 'select', 'required' => true, 'options' => [
                'general' => 'General',
                'collaboration' => 'Collaboration',
                'vendor_request' => 'Vendor request',
            ]],
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
            ['name' => 'subject', 'label' => 'Subject', 'type' => 'text', 'required' => true],
            ['name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'required' => true],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => true, 'options' => [
                'new' => 'New',
                'in_progress' => 'In progress',
                'closed' => 'Closed',
            ]],
        ];
    }

    private function validated(Request $request)
    {
        return $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'inquiry_type' => ['required', Rule::in(['general', 'collaboration', 'vendor_request'])],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'status' => ['required', Rule::in(['new', 'in_progress', 'closed'])],
        ]);
    }
}
