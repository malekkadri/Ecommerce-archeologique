@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="grid md:grid-cols-2 gap-6 items-stretch">
        <div class="fo-panel p-7 md:p-8">
            <p class="fo-kicker">Welcome back</p>
            <h1 class="text-3xl font-semibold mt-2">{{ __('messages.login') }}</h1>
            <p class="text-sm text-charcoal/72 mt-2 leading-relaxed max-w-prose">Continue your courses, workshops, orders, and saved discoveries in one account.</p>
            <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-4" novalidate>
                @csrf
                <div>
                    <label for="login-email" class="block text-sm font-medium mb-1.5">Email</label>
                    <input id="login-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="you@example.com" class="fo-input" required aria-describedby="login-email-help">
                    <p id="login-email-help" class="text-xs text-charcoal/60 mt-1">Use the email address linked to your MIDA account.</p>
                    @error('email')<p class="text-xs text-deepred mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="login-password" class="block text-sm font-medium mb-1.5">{{ __('messages.password') }}</label>
                    <input id="login-password" type="password" name="password" autocomplete="current-password" placeholder="{{ __('messages.password') }}" class="fo-input" required>
                    @error('password')<p class="text-xs text-deepred mt-1">{{ $message }}</p>@enderror
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-charcoal/80"><input type="checkbox" name="remember" class="h-4 w-4 rounded border-charcoal/30"> {{ __('messages.remember_me') }}</label>
                <button class="w-full fo-btn fo-btn-primary">Continue to dashboard</button>
            </form>
            <div class="mt-5 pt-4 border-t border-charcoal/10 text-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <a class="text-deepred font-medium hover:underline focus-visible:underline" href="{{ route('password.request') }}">{{ __('messages.forgot_password') }}</a>
                <a class="text-charcoal/80 hover:text-deepred hover:underline focus-visible:underline" href="{{ route('register') }}">Need an account? {{ __('messages.register') }}</a>
            </div>
        </div>
        <div class="fo-surface p-7 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl font-semibold">Member continuity, designed in.</h2>
            <p class="text-sm text-charcoal/70 mt-3 leading-relaxed">Your account keeps learning progress, bookings, and orders connected so every next action feels clear and consistent.</p>
            @include('components.front.reassurance-list', ['items' => ['Monitor learning, bookings, and orders from one calm dashboard.', 'Save favorites to build your personal learning journey.', 'Checkout and confirmation built for transparency.']])
        </div>
    </div>
</section>
@endsection
