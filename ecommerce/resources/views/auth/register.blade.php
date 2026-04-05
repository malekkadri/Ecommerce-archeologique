@extends('layouts.app')

@section('content')
<section class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h1 class="text-2xl font-semibold">{{ __('messages.register') }}</h1>
        <form method="POST" action="{{ route('register.store') }}" class="mt-5 space-y-4">
            @csrf
            <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.name') }}" class="w-full border rounded-lg px-3 py-2" required>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="w-full border rounded-lg px-3 py-2" required>
            <input type="password" name="password" placeholder="{{ __('messages.password') }}" class="w-full border rounded-lg px-3 py-2" required>
            <input type="password" name="password_confirmation" placeholder="{{ __('messages.password_confirmation') }}" class="w-full border rounded-lg px-3 py-2" required>
            <button class="w-full bg-terracotta text-white rounded-lg py-2">{{ __('messages.register') }}</button>
        </form>
        <p class="mt-4 text-sm"><a class="text-terracotta" href="{{ route('login') }}">{{ __('messages.already_have_account') }}</a></p>
    </div>
</section>
@endsection
