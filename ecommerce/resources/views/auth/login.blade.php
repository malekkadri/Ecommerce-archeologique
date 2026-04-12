@extends('layouts.app')

@section('content')
<section class="max-w-md mx-auto px-4 py-12">
    <div class="fo-panel p-7">
        <h1 class="text-3xl font-semibold mt-2">{{ __('messages.login') }}</h1>
        <form method="POST" action="{{ route('login.attempt') }}" class="mt-5 space-y-4">
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
</section>
@endsection
