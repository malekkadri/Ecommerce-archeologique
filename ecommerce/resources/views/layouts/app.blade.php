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
            theme: {
                extend: {
                    colors: {
                        terracotta: '#C96A4A',
                        sand: '#EDE0D4',
                        olive: '#5F6F52',
                        deepred: '#8C2F39',
                        charcoal: '#2F2A28'
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; }
        .fo-panel { background: #fff; border: 1px solid rgba(201, 106, 74, 0.12); border-radius: 1.25rem; box-shadow: 0 12px 30px rgba(47, 42, 40, 0.06); }
        .fo-page-title { font-size: clamp(1.8rem, 3vw, 2.6rem); line-height: 1.2; font-weight: 650; color: #2F2A28; }
        .fo-page-subtitle { color: rgba(47, 42, 40, 0.72); font-size: 1rem; }
        .fo-kicker { text-transform: uppercase; letter-spacing: .14em; font-size: .72rem; color: #8C2F39; font-weight: 600; }
        .fo-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: .8rem; font-weight: 600; font-size: .9rem; padding: .7rem 1rem; transition: .2s ease; }
        .fo-btn-primary { background: linear-gradient(135deg, #C96A4A, #8C2F39); color: #fff; }
        .fo-btn-primary:hover { transform: translateY(-1px); filter: brightness(1.03); }
        .fo-btn-secondary { background: #EDE0D4; color: #2F2A28; }
        .fo-btn-secondary:hover { background: #e4d1c1; }
        .fo-input, .fo-select, .fo-textarea { width: 100%; border-radius: .8rem; border: 1px solid rgba(47,42,40,.18); background: #fff; padding: .65rem .85rem; font-size: .95rem; }
        .fo-input:focus, .fo-select:focus, .fo-textarea:focus { outline: none; border-color: #C96A4A; box-shadow: 0 0 0 3px rgba(201,106,74,.2); }
        .fo-card { background: #fff; border: 1px solid rgba(47,42,40,.08); border-radius: 1rem; box-shadow: 0 8px 22px rgba(47,42,40,.05); transition: .2s ease; }
        .fo-card-hover:hover { transform: translateY(-2px); box-shadow: 0 16px 32px rgba(47,42,40,.1); }
        .fo-chip { border: 1px solid rgba(47,42,40,.12); border-radius: 999px; padding: .5rem .9rem; font-size: .85rem; background: #fff; color: rgba(47,42,40,.88); }
        .fo-chip-active { background: #2F2A28; color: #fff; border-color: #2F2A28; }
    </style>
</head>
<body class="bg-[#FAF7F2] text-charcoal min-h-screen flex flex-col">
<header class="border-b border-sand/80 bg-white/95 backdrop-blur sticky top-0 z-40" x-data="{open:false}">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between gap-3">
        <a href="{{ route('home') }}" class="text-2xl font-semibold tracking-wide text-deepred">MIDA</a>
        <button class="md:hidden fo-btn fo-btn-secondary !px-3 !py-2" @click="open = !open">Menu</button>
        <nav class="hidden md:flex items-center gap-5 text-sm font-medium">
            <a href="{{ route('contents.index') }}" class="hover:text-deepred">{{ __('messages.nav_content') }}</a>
            <a href="{{ route('courses.index') }}" class="hover:text-deepred">{{ __('messages.nav_courses') }}</a>
            <a href="{{ route('workshops.index') }}" class="hover:text-deepred">{{ __('messages.nav_workshops') }}</a>
            <a href="{{ route('marketplace.index') }}" class="hover:text-deepred">{{ __('messages.nav_marketplace') }}</a>
            <a href="{{ route('about') }}" class="hover:text-deepred">{{ __('messages.nav_about') }}</a>
            <a href="{{ route('contact.create') }}" class="hover:text-deepred">{{ __('messages.nav_contact') }}</a>
        </nav>
        <div class="hidden md:flex items-center gap-2 text-xs">
            <a class="px-2 py-1 rounded {{ app()->getLocale() === 'fr' ? 'bg-terracotta text-white' : 'bg-sand' }}" href="{{ route('locale.switch', 'fr') }}">FR</a>
            <a class="px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-terracotta text-white' : 'bg-sand' }}" href="{{ route('locale.switch', 'en') }}">EN</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a class="fo-btn fo-btn-secondary !py-1.5" href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a>
                @elseif(auth()->user()->isVendor())
                    <a class="fo-btn fo-btn-secondary !py-1.5" href="{{ route('vendor.dashboard') }}">{{ __('messages.vendor_dashboard') }}</a>
                @else
                    <a class="fo-btn fo-btn-secondary !py-1.5" href="{{ route('dashboard.index') }}">{{ __('messages.user_dashboard') }}</a>
                @endif
                <a class="fo-btn fo-btn-secondary !py-1.5" href="{{ route('cart.index') }}">{{ __('messages.cart') }}</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="fo-btn fo-btn-secondary !py-1.5">{{ __('messages.logout') }}</button></form>
            @else
                <a class="fo-btn fo-btn-secondary !py-1.5" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                <a class="fo-btn fo-btn-primary !py-1.5" href="{{ route('register') }}">{{ __('messages.register') }}</a>
            @endauth
        </div>
    </div>

    <div x-show="open" class="md:hidden border-t border-sand/80 bg-white px-4 py-4 space-y-2" x-cloak>
        <a href="{{ route('contents.index') }}" class="block py-2">{{ __('messages.nav_content') }}</a>
        <a href="{{ route('courses.index') }}" class="block py-2">{{ __('messages.nav_courses') }}</a>
        <a href="{{ route('workshops.index') }}" class="block py-2">{{ __('messages.nav_workshops') }}</a>
        <a href="{{ route('marketplace.index') }}" class="block py-2">{{ __('messages.nav_marketplace') }}</a>
        <a href="{{ route('about') }}" class="block py-2">{{ __('messages.nav_about') }}</a>
        <a href="{{ route('contact.create') }}" class="block py-2">{{ __('messages.nav_contact') }}</a>
        <div class="flex gap-2 pt-2">
            <a class="px-2 py-1 rounded {{ app()->getLocale() === 'fr' ? 'bg-terracotta text-white' : 'bg-sand' }}" href="{{ route('locale.switch', 'fr') }}">FR</a>
            <a class="px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-terracotta text-white' : 'bg-sand' }}" href="{{ route('locale.switch', 'en') }}">EN</a>
        </div>
    </div>
</header>

<main class="flex-1 pb-8">
    @if($errors->any())
        <div class="max-w-7xl mx-auto mt-4 px-4"><div class="bg-deepred text-white px-4 py-3 rounded-xl">{{ $errors->first() }}</div></div>
    @endif
    @if(session('success'))<div class="max-w-7xl mx-auto mt-4 px-4"><div class="bg-olive text-white px-4 py-3 rounded-xl">{{ session('success') }}</div></div>@endif
    @if(session('error'))<div class="max-w-7xl mx-auto mt-4 px-4"><div class="bg-deepred text-white px-4 py-3 rounded-xl">{{ session('error') }}</div></div>@endif
    @yield('content')
</main>

<footer class="bg-charcoal text-sand mt-16">
    <div class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-3 gap-6">
        <div><h4 class="text-lg font-semibold">MIDA</h4><p class="mt-2 text-sm text-sand/80">{{ __('messages.footer_tagline') }}</p></div>
        <div><h5 class="font-semibold">{{ __('messages.footer_discover') }}</h5><ul class="mt-2 space-y-1 text-sm"><li><a class="hover:text-white" href="{{ route('contents.index') }}">{{ __('messages.nav_content') }}</a></li><li><a class="hover:text-white" href="{{ route('courses.index') }}">{{ __('messages.nav_courses') }}</a></li></ul></div>
        <div><h5 class="font-semibold">{{ __('messages.footer_contact') }}</h5><p class="text-sm mt-2 text-sand/80">contact@mida.tn</p></div>
    </div>
</footer>
</body>
</html>
