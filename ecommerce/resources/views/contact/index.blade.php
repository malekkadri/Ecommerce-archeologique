@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['variant' => 'editorial', 'kicker' => __('messages.nav_contact'), 'title' => __('messages.nav_contact'), 'subtitle' => 'Reach our team for support, collaboration, or vendor inquiries. We route each request by intent for faster answers.'])
<section class="max-w-4xl mx-auto px-4 py-8" data-page="contact">
    <div class="grid md:grid-cols-[1.2fr_.8fr] gap-6 items-start">
        <form method="post" action="{{ route('contact.store') }}" class="fo-panel p-6 space-y-4" id="contact-form">
            @csrf
            <select name="inquiry_type" class="fo-select"><option value="general">{{ __('messages.general') }}</option><option value="collaboration">{{ __('messages.collaboration') }}</option><option value="vendor">{{ __('messages.vendor_request') }}</option></select>
            <input name="name" class="fo-input" placeholder="{{ __('messages.name') }}">
            <input name="email" class="fo-input" placeholder="Email">
            <input name="subject" class="fo-input" placeholder="{{ __('messages.subject') }}">
            <textarea name="message" class="fo-textarea" rows="6" placeholder="{{ __('messages.message') }}"></textarea>
            <button class="fo-btn fo-btn-primary" data-cta="contact-submit">{{ __('messages.send') }}</button>
        </form>
        <aside class="fo-surface p-6 space-y-4">
            <div>
                <h3 class="font-semibold text-lg">{{ __('messages.footer_contact') }}</h3>
                <p class="text-sm text-charcoal/70 mt-3">contact@mida.tn</p>
                <p class="text-sm text-charcoal/70 mt-1">Typical response window: within 24 hours on business days.</p>
            </div>
            @include('components.front.reassurance-list', ['tone' => 'calm', 'items' => ['Each inquiry type is routed to the right team.', 'Account-related requests are handled with continuity in mind.', 'Vendor and collaboration requests receive clear next steps.']])
        </aside>
    </div>
</section>
@endsection
