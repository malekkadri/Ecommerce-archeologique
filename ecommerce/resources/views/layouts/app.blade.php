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
        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            background:
                radial-gradient(circle at 8% 0%, rgba(201, 106, 74, 0.12), transparent 32%),
                radial-gradient(circle at 100% 10%, rgba(95, 111, 82, 0.1), transparent 28%),
                #FAF7F2;
        }
        [x-cloak] { display: none !important; }

        .fo-section { margin-top: 2.4rem; }
        .fo-section-soft { background: rgba(237, 224, 212, 0.38); border-block: 1px solid rgba(47, 42, 40, 0.06); }
        .fo-panel {
            background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.9));
            border: 1px solid rgba(201, 106, 74, 0.16);
            border-radius: 1.25rem;
            box-shadow: 0 18px 40px rgba(47, 42, 40, 0.09);
        }
        .fo-surface {
            background: rgba(255,255,255,0.82);
            border: 1px solid rgba(47,42,40,.08);
            border-radius: 1.1rem;
        }
        .fo-page-title { font-size: clamp(1.9rem, 3.1vw, 2.9rem); line-height: 1.13; font-weight: 680; letter-spacing: -.01em; color: #2F2A28; }
        .fo-page-subtitle { color: rgba(47, 42, 40, 0.74); font-size: 1.02rem; max-width: 65ch; }
        .fo-kicker { text-transform: uppercase; letter-spacing: .16em; font-size: .69rem; color: #8C2F39; font-weight: 700; }
        .fo-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: .82rem; font-weight: 600; font-size: .9rem; padding: .72rem 1.05rem; transition: transform .18s ease, box-shadow .2s ease, background .2s ease, color .2s ease; }
        .fo-btn:focus-visible { outline: none; box-shadow: 0 0 0 3px rgba(201, 106, 74, 0.22); }
        .fo-btn-primary { background: linear-gradient(135deg, #C96A4A, #8C2F39); color: #fff; box-shadow: 0 10px 22px rgba(140, 47, 57, 0.25); }
        .fo-btn-primary:hover { transform: translateY(-1px); filter: brightness(1.03); box-shadow: 0 16px 28px rgba(140, 47, 57, 0.3); }
        .fo-btn-secondary { background: #EDE0D4; color: #2F2A28; border: 1px solid rgba(47,42,40,.1); }
        .fo-btn-secondary:hover { background: #e4d1c1; transform: translateY(-1px); }
        .fo-btn-ghost { background: transparent; color: #2F2A28; border: 1px solid rgba(47,42,40,.16); }
        .fo-btn-ghost:hover { background: rgba(237, 224, 212, 0.5); }

        .fo-input, .fo-select, .fo-textarea { width: 100%; border-radius: .84rem; border: 1px solid rgba(47,42,40,.2); background: #fff; padding: .68rem .9rem; font-size: .95rem; transition: border-color .18s ease, box-shadow .18s ease; }
        .fo-input:focus, .fo-select:focus, .fo-textarea:focus { outline: none; border-color: #C96A4A; box-shadow: 0 0 0 3px rgba(201,106,74,.2); }
        .fo-card { background: rgba(255,255,255,.94); border: 1px solid rgba(47,42,40,.09); border-radius: 1.05rem; box-shadow: 0 8px 22px rgba(47,42,40,.06); transition: transform .22s ease, box-shadow .24s ease, border-color .22s ease; }
        .fo-card-hover:hover { transform: translateY(-3px); box-shadow: 0 20px 34px rgba(47,42,40,.12); border-color: rgba(201, 106, 74, 0.32); }
        .fo-chip { border: 1px solid rgba(47,42,40,.14); border-radius: 999px; padding: .45rem .9rem; font-size: .82rem; background: #fff; color: rgba(47,42,40,.9); font-weight: 500; }
        .fo-chip-active { background: #2F2A28; color: #fff; border-color: #2F2A28; }
        .fo-chip-status { font-size: .72rem; letter-spacing: .03em; }
        .fo-empty {
            border: 1px dashed rgba(47,42,40,.2);
            background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(255,255,255,0.7));
            border-radius: 1rem;
        }
        .fo-proof-item { border: 1px solid rgba(47,42,40,.08); border-radius: .9rem; background: #fff; padding: .8rem .9rem; }
        .fo-proof-value { font-size: 1.35rem; font-weight: 700; color: #2F2A28; line-height: 1.1; }
        .fo-proof-label { margin-top: .2rem; font-size: .78rem; text-transform: uppercase; letter-spacing: .08em; color: rgba(47,42,40,.62); }
        .fo-reassurance { border: 1px solid rgba(95,111,82,.22); background: rgba(95,111,82,.07); border-radius: .95rem; padding: .85rem 1rem; }
        .fo-callout { border: 1px solid rgba(201,106,74,.2); background: rgba(201,106,74,.08); border-radius: 1rem; padding: 1rem 1.1rem; }
        .fo-readable > * + * { margin-top: 1rem; }
        .fo-readable h2, .fo-readable h3 { line-height: 1.28; color: #2F2A28; font-weight: 620; margin-top: 1.6rem; }
        .fo-readable ul { padding-left: 1.1rem; list-style: disc; }
        .fo-readable blockquote { border-left: 3px solid rgba(201,106,74,.55); padding-left: .9rem; color: rgba(47,42,40,.76); font-style: italic; }

        .fo-table-wrap { overflow-x: auto; border: 1px solid rgba(47,42,40,.1); border-radius: 1rem; background: #fff; }

        @media (max-width: 768px) {
            .fo-section { margin-top: 2rem; }
            .fo-btn { width: auto; }
        }
    </style>
</head>
<body class="text-charcoal min-h-screen flex flex-col">
<header class="border-b border-sand/80 bg-white/90 backdrop-blur-xl sticky top-0 z-40" x-data="{open:false}">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between gap-3">
        <a href="{{ route('home') }}" class="text-2xl font-semibold tracking-wide text-deepred">MIDA</a>
        <button class="md:hidden fo-btn fo-btn-secondary !px-3 !py-2" @click="open = !open">Menu</button>
        <nav class="hidden md:flex items-center gap-5 text-sm font-medium">
            <a href="{{ route('contents.index') }}" class="hover:text-deepred transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-terracotta/30 rounded">{{ __('messages.nav_content') }}</a>
            <a href="{{ route('courses.index') }}" class="hover:text-deepred transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-terracotta/30 rounded">{{ __('messages.nav_courses') }}</a>
            <a href="{{ route('workshops.index') }}" class="hover:text-deepred transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-terracotta/30 rounded">{{ __('messages.nav_workshops') }}</a>
            <a href="{{ route('marketplace.index') }}" class="hover:text-deepred transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-terracotta/30 rounded">{{ __('messages.nav_marketplace') }}</a>
            <a href="{{ route('about') }}" class="hover:text-deepred transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-terracotta/30 rounded">{{ __('messages.nav_about') }}</a>
            <a href="{{ route('contact.create') }}" class="hover:text-deepred transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-terracotta/30 rounded">{{ __('messages.nav_contact') }}</a>
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
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="fo-btn fo-btn-ghost !py-1.5">{{ __('messages.logout') }}</button></form>
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

<main class="flex-1 pb-10">
    @if($errors->any())
        <div class="max-w-7xl mx-auto mt-4 px-4"><div class="fo-panel !rounded-xl bg-deepred text-white px-4 py-3">{{ $errors->first() }}</div></div>
    @endif
    @if(session('success'))<div class="max-w-7xl mx-auto mt-4 px-4"><div class="fo-panel !rounded-xl bg-olive text-white px-4 py-3">{{ session('success') }}</div></div>@endif
    @if(session('error'))<div class="max-w-7xl mx-auto mt-4 px-4"><div class="fo-panel !rounded-xl bg-deepred text-white px-4 py-3">{{ session('error') }}</div></div>@endif
    @yield('content')
</main>

<footer class="bg-charcoal text-sand mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-3 gap-7">
        <div>
            <h4 class="text-xl font-semibold">MIDA</h4>
            <p class="mt-2 text-sm text-sand/80 leading-relaxed">{{ __('messages.footer_tagline') }}</p>
        </div>
        <div>
            <h5 class="font-semibold">{{ __('messages.footer_discover') }}</h5>
            <ul class="mt-3 space-y-1.5 text-sm text-sand/85">
                <li><a class="hover:text-white" href="{{ route('contents.index') }}">{{ __('messages.nav_content') }}</a></li>
                <li><a class="hover:text-white" href="{{ route('courses.index') }}">{{ __('messages.nav_courses') }}</a></li>
                <li><a class="hover:text-white" href="{{ route('workshops.index') }}">{{ __('messages.nav_workshops') }}</a></li>
                <li><a class="hover:text-white" href="{{ route('marketplace.index') }}">{{ __('messages.nav_marketplace') }}</a></li>
            </ul>
        </div>
        <div>
            <h5 class="font-semibold">{{ __('messages.footer_contact') }}</h5>
            <p class="text-sm mt-3 text-sand/80">contact@mida.tn</p>
            <p class="text-xs mt-5 text-sand/60">© {{ now()->year }} MIDA</p>
        </div>
    </div>
</footer>
</body>
</html>
