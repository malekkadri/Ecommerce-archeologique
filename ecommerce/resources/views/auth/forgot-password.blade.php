@extends('layouts.app')

@section('content')
<section class="max-w-3xl mx-auto px-4 py-12">
    <div class="fo-panel p-7 md:p-8">
        <p class="fo-kicker">Account support</p>
        <h1 class="text-3xl font-semibold mt-2">{{ __('messages.forgot_password') }}</h1>
        <p class="text-sm text-charcoal/70 mt-2">{{ __('messages.forgot_password_hint') }}</p>
        <form method="POST" action="{{ route('password.email') }}" class="mt-5 space-y-4 max-w-lg">
            @csrf
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="fo-input" required>
            <button class="fo-btn fo-btn-primary">{{ __('messages.send_reset_link') }}</button>
        </form>
        @include('components.front.reassurance-list', ['title' => 'Need reassurance?', 'items' => ['Reset links are sent securely to your email address.', 'You can return to login anytime after resetting.', 'Your learning and order history stays intact.']])
    </div>
</section>
@endsection
