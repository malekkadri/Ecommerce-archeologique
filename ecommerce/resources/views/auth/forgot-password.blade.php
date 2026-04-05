@extends('layouts.app')

@section('content')
<section class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h1 class="text-2xl font-semibold">{{ __('messages.forgot_password') }}</h1>
        <p class="text-sm text-charcoal/70 mt-2">{{ __('messages.forgot_password_hint') }}</p>
        <form method="POST" action="{{ route('password.email') }}" class="mt-5 space-y-4">
            @csrf
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="w-full border rounded-lg px-3 py-2" required>
            <button class="w-full bg-terracotta text-white rounded-lg py-2">{{ __('messages.send_reset_link') }}</button>
        </form>
    </div>
</section>
@endsection
