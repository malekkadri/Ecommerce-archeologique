@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="grid md:grid-cols-2 gap-6 items-stretch">
        <div class="fo-panel p-7 md:p-8">
            <p class="fo-kicker">Welcome back</p>
            <h1 class="text-3xl font-semibold mt-2">{{ __('messages.login') }}</h1>
            <p class="text-sm text-charcoal/70 mt-2">Continue your courses, workshops, orders, and saved discoveries in one account.</p>
            <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-4">
                @csrf
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="fo-input" required>
                <input type="password" name="password" placeholder="{{ __('messages.password') }}" class="fo-input" required>
                <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> {{ __('messages.remember_me') }}</label>
                <button class="w-full fo-btn fo-btn-primary">{{ __('messages.login') }}</button>
            </form>
            <div class="mt-4 text-sm flex justify-between">
                <a class="text-deepred" href="{{ route('password.request') }}">{{ __('messages.forgot_password') }}</a>
                <a class="text-deepred" href="{{ route('register') }}">{{ __('messages.register') }}</a>
            </div>
        </div>
        <div class="fo-surface p-7 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl font-semibold">Member continuity, designed in.</h2>
            <p class="text-sm text-charcoal/70 mt-3">Your account keeps learning progress, bookings, and orders connected so every next action feels clear and consistent.</p>
            @include('components.front.reassurance-list', ['items' => ['Monitor learning, bookings, and orders from one calm dashboard.', 'Save favorites to build your personal learning journey.', 'Checkout and confirmation built for transparency.']])
        </div>
    </div>
</section>
@endsection
