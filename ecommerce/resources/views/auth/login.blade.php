@extends('layouts.app')

@section('content')
<section class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h1 class="text-2xl font-semibold">{{ __('messages.login') }}</h1>
        <form method="POST" action="{{ route('login.attempt') }}" class="mt-5 space-y-4">
            @csrf
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="w-full border rounded-lg px-3 py-2" required>
            <input type="password" name="password" placeholder="{{ __('messages.password') }}" class="w-full border rounded-lg px-3 py-2" required>
            <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> {{ __('messages.remember_me') }}</label>
            <button class="w-full bg-terracotta text-white rounded-lg py-2">{{ __('messages.login') }}</button>
        </form>
        <div class="mt-4 text-sm flex justify-between">
            <a class="text-terracotta" href="{{ route('password.request') }}">{{ __('messages.forgot_password') }}</a>
            <a class="text-terracotta" href="{{ route('register') }}">{{ __('messages.register') }}</a>
        </div>
    </div>
</section>
@endsection
