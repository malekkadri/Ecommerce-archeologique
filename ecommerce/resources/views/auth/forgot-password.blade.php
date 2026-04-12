@extends('layouts.app')

@section('content')
<section class="max-w-md mx-auto px-4 py-12">
    <div class="fo-panel p-7">
        <h1 class="text-3xl font-semibold">{{ __('messages.forgot_password') }}</h1>
        <p class="text-sm text-charcoal/70 mt-2">{{ __('messages.forgot_password_hint') }}</p>
        <form method="POST" action="{{ route('password.email') }}" class="mt-5 space-y-4">
            @csrf
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="fo-input" required>
            <button class="w-full fo-btn fo-btn-primary">{{ __('messages.send_reset_link') }}</button>
        </form>
    </div>
</section>
@endsection
