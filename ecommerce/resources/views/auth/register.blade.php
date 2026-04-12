@extends('layouts.app')

@section('content')
<section class="max-w-md mx-auto px-4 py-12">
    <div class="fo-panel p-7">
        <h1 class="text-3xl font-semibold">{{ __('messages.register') }}</h1>
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
</section>
@endsection
