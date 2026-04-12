@extends('layouts.app')

@section('content')
<style>
    .admin-shell { max-width: 1200px; margin: 0 auto; padding: 1.25rem 1rem 2rem; display:grid; grid-template-columns: 260px 1fr; gap:1rem; }
    .admin-sidebar { background:#111827; color:#e5e7eb; border-radius:1rem; padding:1rem; position:sticky; top:5.5rem; height:fit-content; }
    .admin-nav-link { display:flex; align-items:center; gap:.6rem; padding:.55rem .7rem; border-radius:.65rem; font-size:.9rem; color:#d1d5db; }
    .admin-nav-link:hover, .admin-nav-link.active { background:#1f2937; color:#fff; }
    .admin-main { min-width:0; }
    .admin-topbar { background:rgba(255,255,255,.92); border:1px solid rgba(15,23,42,.08); border-radius:1rem; padding:1rem 1.2rem; margin-bottom:1rem; display:flex; justify-content:space-between; align-items:center; gap:.75rem; }
    .admin-card { background:#fff; border:1px solid rgba(15,23,42,.09); border-radius:1rem; }
    .admin-title { font-size:1.8rem; font-weight:680; color:#111827; }
    .admin-kicker { text-transform:uppercase; letter-spacing:.08em; font-size:.7rem; color:#8C2F39; font-weight:700; }
    .admin-subtitle { color:#4b5563; font-size:.95rem; margin-top:.35rem; }
    .admin-label { font-size:.82rem; font-weight:600; color:#1f2937; display:block; margin-bottom:.35rem; }
    .admin-input { width:100%; border:1px solid #d1d5db; border-radius:.6rem; padding:.6rem .75rem; background:#fff; }
    .admin-input:focus { outline:none; border-color:#C96A4A; box-shadow:0 0 0 3px rgba(201,106,74,.2); }
    .admin-btn { border-radius:.6rem; padding:.55rem .9rem; font-weight:600; font-size:.88rem; }
    .admin-btn-primary { background:#C96A4A; color:#fff; }
    .admin-btn-secondary { background:#e5e7eb; color:#111827; }
    @media (max-width: 1024px){ .admin-shell{grid-template-columns:1fr;} .admin-sidebar{position:static;} }
</style>

<div class="admin-shell">
    <aside class="admin-sidebar">
        <p class="text-xs uppercase tracking-wider text-gray-400 mb-3">Admin panel</p>
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
    </aside>

    <div class="admin-main">
        <div class="admin-topbar">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400">Back office</p>
                <p class="font-semibold text-slate-900">@yield('admin_title', 'Admin')</p>
            </div>
            <a href="{{ route('home') }}" class="admin-btn admin-btn-secondary">View website</a>
        </div>

        @yield('content')
    </div>
</div>
@endsection
