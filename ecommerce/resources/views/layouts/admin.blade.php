<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trim($__env->yieldContent('admin_title', 'Admin')).' • '.($websiteSettings['site_name'] ?? config('app.name', 'MIDA')) }}</title>
    @if(!empty($websiteSettings['favicon_path']))<link rel="icon" href="{{ Storage::url($websiteSettings['favicon_path']) }}">@endif
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            color-scheme: light;
        }
        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            background:
                radial-gradient(circle at 8% 0%, rgba(15, 23, 42, 0.08), transparent 35%),
                radial-gradient(circle at 92% 8%, rgba(124, 58, 237, 0.08), transparent 30%),
                #f1f5f9;
            min-height: 100vh;
            color: #0f172a;
        }

        .admin-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 1rem;
            padding: 1rem;
        }

        .admin-sidebar {
            background: linear-gradient(165deg, #0f172a 0%, #111827 45%, #1e293b 100%);
            color: #e2e8f0;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, .2);
            padding: 1rem;
            position: sticky;
            top: 1rem;
            height: calc(100vh - 2rem);
            overflow-y: auto;
            box-shadow: 0 18px 36px rgba(2, 6, 23, .34);
        }

        .admin-brand {
            display: block;
            border-bottom: 1px solid rgba(148, 163, 184, .2);
            padding-bottom: .85rem;
            margin-bottom: .85rem;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .65rem .75rem;
            border-radius: .7rem;
            font-size: .9rem;
            color: #cbd5e1;
            transition: all .18s ease;
        }

        .admin-nav-link:hover,
        .admin-nav-link.active {
            background: linear-gradient(120deg, rgba(201, 106, 74, .26), rgba(245, 158, 11, .2));
            color: #fff;
            transform: translateX(2px);
        }

        .admin-main {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .admin-topbar {
            background: linear-gradient(135deg, rgba(255, 255, 255, .96), rgba(248, 250, 252, .92));
            border: 1px solid rgba(148, 163, 184, .25);
            border-radius: 1rem;
            padding: .95rem 1.2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: .75rem;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .05);
        }

        .admin-card {
            background: #fff;
            border: 1px solid rgba(148, 163, 184, .25);
            border-radius: 1rem;
            box-shadow: 0 14px 26px rgba(15, 23, 42, .05);
        }

        .admin-label { font-size: .82rem; font-weight: 600; color: #1f2937; display: block; margin-bottom: .35rem; }
        .admin-input { width: 100%; border: 1px solid #d1d5db; border-radius: .6rem; padding: .6rem .75rem; background: #fff; }
        .admin-input:focus { outline: none; border-color: #C96A4A; box-shadow: 0 0 0 3px rgba(201,106,74,.2); }
        .admin-btn { border-radius: .6rem; padding: .55rem .9rem; font-weight: 600; font-size: .88rem; }
        .admin-btn-primary { background: #C96A4A; color: #fff; }
        .admin-btn-secondary { background: #e5e7eb; color: #111827; }
        .admin-btn-secondary:hover { background: #d1d5db; }
        .admin-btn-primary:hover { background: #b85b3d; }
        .admin-metric { background: linear-gradient(145deg, #fff, #f8fafc); border: 1px solid rgba(148, 163, 184, .22); border-radius: .95rem; padding: .95rem 1rem; }
        .admin-metric-label { color: #64748b; font-size: .74rem; text-transform: uppercase; letter-spacing: .08em; font-weight: 700; }
        .admin-metric-value { color: #0f172a; font-size: 1.7rem; font-weight: 700; margin-top: .2rem; line-height: 1.1; }
        .admin-list-row { display: flex; justify-content: space-between; align-items: flex-start; gap: .75rem; padding: .7rem 0; border-bottom: 1px solid #f1f5f9; font-size: .9rem; }
        .admin-list-row:last-child { border-bottom: 0; padding-bottom: 0; }
        .admin-chip { display: inline-flex; align-items: center; border: 1px solid #cbd5e1; border-radius: 999px; padding: .28rem .6rem; font-size: .74rem; font-weight: 600; color: #475569; background: #f8fafc; }

        @media (max-width: 1024px) {
            .admin-shell { grid-template-columns: 1fr; }
            .admin-sidebar { position: static; height: auto; }
        }
    </style>
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <p class="text-xs uppercase tracking-wider text-slate-400">Admin panel</p>
            <p class="text-lg font-semibold text-white mt-1">{{ $websiteSettings['site_name'] ?? 'MIDA' }}</p>
            <p class="text-xs text-slate-300">Back Office</p>
        </a>

        <nav class="space-y-1">
            <a class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">Products</a>
            <a class="admin-nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">Courses</a>
            <a class="admin-nav-link {{ request()->routeIs('admin.workshops.*') ? 'active' : '' }}" href="{{ route('admin.workshops.index') }}">Workshops</a>
            <a class="admin-nav-link {{ request()->routeIs('admin.contents.*') ? 'active' : '' }}" href="{{ route('admin.contents.index') }}">Contents</a>
            <a class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a>
            <a class="admin-nav-link {{ request()->routeIs('admin.contact-inquiries.*') ? 'active' : '' }}" href="{{ route('admin.contact-inquiries.index') }}">Inquiries</a>
            <a class="admin-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">Website Settings</a>
        </nav>

        <div class="mt-5 pt-4 border-t border-slate-700/70 space-y-2">
            <a href="{{ route('home') }}" class="admin-btn admin-btn-secondary inline-flex">View website</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="admin-btn admin-btn-primary w-full" type="submit">Logout</button>
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <div class="admin-topbar">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400">Back office</p>
                <p class="font-semibold text-slate-900">@yield('admin_title', 'Admin')</p>
            </div>
            <div class="text-sm text-slate-500">{{ now()->format('M d, Y') }}</div>
        </div>

        @if($errors->any())
            <div class="rounded-xl bg-red-600 text-white px-4 py-3">{{ $errors->first() }}</div>
        @endif
        @if(session('success'))<div class="rounded-xl bg-emerald-600 text-white px-4 py-3">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="rounded-xl bg-red-600 text-white px-4 py-3">{{ session('error') }}</div>@endif

        @yield('content')
    </main>
</div>
</body>
</html>
