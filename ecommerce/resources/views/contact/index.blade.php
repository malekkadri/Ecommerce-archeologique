@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['title' => __('messages.nav_contact'), 'subtitle' => __('messages.footer_tagline')])
<section class="max-w-3xl mx-auto px-4 py-8">
    <form method="post" action="{{ route('contact.store') }}" class="fo-panel p-6 space-y-4">
        @csrf
        <select name="inquiry_type" class="fo-select"><option value="general">{{ __('messages.general') }}</option><option value="collaboration">{{ __('messages.collaboration') }}</option><option value="vendor">{{ __('messages.vendor_request') }}</option></select>
        <input name="name" class="fo-input" placeholder="{{ __('messages.name') }}">
        <input name="email" class="fo-input" placeholder="Email">
        <input name="subject" class="fo-input" placeholder="{{ __('messages.subject') }}">
        <textarea name="message" class="fo-textarea" rows="6" placeholder="{{ __('messages.message') }}"></textarea>
        <button class="fo-btn fo-btn-primary">{{ __('messages.send') }}</button>
    </form>
</section>
@endsection
