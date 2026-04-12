@extends('layouts.app')

@section('content')
<section class="max-w-3xl mx-auto px-4 py-12">
    <div class="fo-panel p-7 md:p-8">
        <p class="fo-kicker">Account support</p>
        <h1 class="text-3xl font-semibold mt-2">{{ __('messages.forgot_password') }}</h1>
        <p class="text-sm text-charcoal/72 mt-2 leading-relaxed max-w-prose">{{ __('messages.forgot_password_hint') }} We'll send instructions to get you back into your account quickly.</p>
        <form method="POST" action="{{ route('password.email') }}" class="mt-5 space-y-4 max-w-lg" novalidate>
            @csrf
            <div>
                <label for="reset-email" class="block text-sm font-medium mb-1.5">Email</label>
                <input id="reset-email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" class="fo-input" autocomplete="email" required aria-describedby="reset-email-help">
                <p id="reset-email-help" class="text-xs text-charcoal/60 mt-1">Use the same email used for login.</p>
                @error('email')<p class="text-xs text-deepred mt-1">{{ $message }}</p>@enderror
            </div>
            <button class="fo-btn fo-btn-primary">{{ __('messages.send_reset_link') }}</button>
            <a href="{{ route('login') }}" class="inline-flex text-sm text-charcoal/80 hover:text-deepred hover:underline focus-visible:underline">{{ __('messages.login') }}</a>
        </form>
        <div class="mt-6">
            @include('components.front.reassurance-list', ['title' => 'Reset reassurance', 'items' => ['Reset links are sent securely to your email address.', 'You can return to login anytime after resetting.', 'Your learning and order history stays intact.']])
        </div>
    </div>
</section>
@endsection
