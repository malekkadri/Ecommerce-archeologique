@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="grid md:grid-cols-2 gap-6 items-stretch">
        <div class="fo-surface p-7 md:p-8 flex flex-col justify-center order-2 md:order-1">
            <h2 class="text-xl font-semibold">Create your guided MIDA account.</h2>
            <p class="text-sm text-charcoal/70 mt-3 leading-relaxed">Use one account for editorial saves, structured courses, workshop bookings, and checkout history.</p>
            @include('components.front.reassurance-list', ['items' => ['Save favorites across content, courses, and products.', 'Enroll and track progress with clear milestones.', 'Manage bookings and orders in one place.']])
        </div>
        <div class="fo-panel p-7 md:p-8 order-1 md:order-2">
            <p class="fo-kicker">Create account</p>
            <h1 class="text-3xl font-semibold mt-2">{{ __('messages.register') }}</h1>
            <p class="text-sm text-charcoal/72 mt-2 leading-relaxed max-w-prose">Join MIDA to centralize your learning journey, workshop activity, and marketplace history.</p>
            <form method="POST" action="{{ route('register.store') }}" class="mt-5 space-y-4" novalidate>
                @csrf
                <div>
                    <label for="register-name" class="block text-sm font-medium mb-1.5">{{ __('messages.name') }}</label>
                    <input id="register-name" type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.name') }}" class="fo-input" autocomplete="name" required>
                    @error('name')<p class="text-xs text-deepred mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="register-email" class="block text-sm font-medium mb-1.5">Email</label>
                    <input id="register-email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" class="fo-input" autocomplete="email" required aria-describedby="register-email-help">
                    <p id="register-email-help" class="text-xs text-charcoal/60 mt-1">We use this for sign-in, confirmations, and learning updates.</p>
                    @error('email')<p class="text-xs text-deepred mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="register-password" class="block text-sm font-medium mb-1.5">{{ __('messages.password') }}</label>
                    <input id="register-password" type="password" name="password" placeholder="{{ __('messages.password') }}" class="fo-input" autocomplete="new-password" required aria-describedby="register-password-help">
                    <p id="register-password-help" class="text-xs text-charcoal/60 mt-1">Choose a secure password you'll remember.</p>
                    @error('password')<p class="text-xs text-deepred mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="register-password-confirmation" class="block text-sm font-medium mb-1.5">{{ __('messages.password_confirmation') }}</label>
                    <input id="register-password-confirmation" type="password" name="password_confirmation" placeholder="{{ __('messages.password_confirmation') }}" class="fo-input" autocomplete="new-password" required>
                    @error('password_confirmation')<p class="text-xs text-deepred mt-1">{{ $message }}</p>@enderror
                </div>
                <button class="w-full fo-btn fo-btn-primary">Create account</button>
            </form>
            <p class="mt-5 pt-4 border-t border-charcoal/10 text-sm"><a class="text-charcoal/80 hover:text-deepred hover:underline focus-visible:underline" href="{{ route('login') }}">{{ __('messages.already_have_account') }} {{ __('messages.login') }}</a></p>
        </div>
    </div>
</section>
@endsection
