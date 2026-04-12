@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="grid md:grid-cols-2 gap-6 items-stretch">
        <div class="fo-surface p-7 md:p-8 flex flex-col justify-center order-2 md:order-1">
            <h2 class="text-xl font-semibold">Join the MIDA community.</h2>
            <p class="text-sm text-charcoal/70 mt-3">Create your account to save favorites, enroll in courses, and manage orders.</p>
        </div>
        <div class="fo-panel p-7 md:p-8 order-1 md:order-2">
            <p class="fo-kicker">Create account</p>
            <h1 class="text-3xl font-semibold mt-2">{{ __('messages.register') }}</h1>
            <form method="POST" action="{{ route('register.store') }}" class="mt-5 space-y-4">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.name') }}" class="fo-input" required>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="fo-input" required>
                <input type="password" name="password" placeholder="{{ __('messages.password') }}" class="fo-input" required>
                <input type="password" name="password_confirmation" placeholder="{{ __('messages.password_confirmation') }}" class="fo-input" required>
                <button class="w-full fo-btn fo-btn-primary">{{ __('messages.register') }}</button>
            </form>
            <p class="mt-4 text-sm"><a class="text-deepred" href="{{ route('login') }}">{{ __('messages.already_have_account') }}</a></p>
        </div>
    </div>
</section>
@endsection
