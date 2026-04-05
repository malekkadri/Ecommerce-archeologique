<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MIDA') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { terracotta: '#C96A4A', sand: '#EDE0D4', olive: '#5F6F52', deepred: '#8C2F39', charcoal: '#2F2A28' } } }
        }
    </script>
</head>
<body class="bg-[#FAF7F2] text-charcoal min-h-screen flex flex-col">
<header class="border-b border-sand bg-white/90 backdrop-blur">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-2xl font-semibold tracking-wide text-deepred">MIDA</a>
        <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
            <a href="{{ route('contents.index') }}">{{ __('messages.nav_content') }}</a>
            <a href="{{ route('courses.index') }}">{{ __('messages.nav_courses') }}</a>
            <a href="{{ route('workshops.index') }}">{{ __('messages.nav_workshops') }}</a>
            <a href="{{ route('marketplace.index') }}">{{ __('messages.nav_marketplace') }}</a>
            @auth
                <a href="{{ route('cart.index') }}">{{ __('messages.cart') }}</a>
            @endauth
            <a href="{{ route('about') }}">{{ __('messages.nav_about') }}</a>
            <a href="{{ route('contact.create') }}">{{ __('messages.nav_contact') }}</a>
        </nav>
        <div class="flex items-center gap-2 text-xs">
            <a class="px-2 py-1 rounded {{ app()->getLocale() === 'fr' ? 'bg-terracotta text-white' : 'bg-sand' }}" href="{{ route('locale.switch', 'fr') }}">FR</a>
            <a class="px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-terracotta text-white' : 'bg-sand' }}" href="{{ route('locale.switch', 'en') }}">EN</a>
        </div>
    </div>
</header>

<main class="flex-1">
    @if(session('success'))<div class="max-w-7xl mx-auto mt-4 px-4"><div class="bg-olive text-white px-4 py-3 rounded-xl">{{ session('success') }}</div></div>@endif
    @if(session('error'))<div class="max-w-7xl mx-auto mt-4 px-4"><div class="bg-deepred text-white px-4 py-3 rounded-xl">{{ session('error') }}</div></div>@endif
    @yield('content')
</main>

<footer class="bg-charcoal text-sand mt-16">
    <div class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-3 gap-6">
        <div><h4 class="text-lg font-semibold">MIDA</h4><p class="mt-2 text-sm">{{ __('messages.footer_tagline') }}</p></div>
        <div><h5 class="font-semibold">{{ __('messages.footer_discover') }}</h5><ul class="mt-2 space-y-1 text-sm"><li><a href="{{ route('contents.index') }}">{{ __('messages.nav_content') }}</a></li><li><a href="{{ route('courses.index') }}">{{ __('messages.nav_courses') }}</a></li></ul></div>
        <div><h5 class="font-semibold">{{ __('messages.footer_contact') }}</h5><p class="text-sm mt-2">contact@mida.tn</p></div>
    </div>
</footer>
</body>
</html>
