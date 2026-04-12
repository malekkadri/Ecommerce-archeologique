@extends('layouts.app')

@section('content')
<style>
    .admin-shell {
        max-width: 1320px;
        margin: 0 auto;
        padding: 1.5rem 1rem 2.5rem;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 1.25rem;
    }
    .admin-sidebar {
        background: linear-gradient(160deg, #0f172a 0%, #111827 48%, #1f2937 100%);
        color: #e5e7eb;
        border-radius: 1.15rem;
        padding: 1rem;
        position: sticky;
        top: 5.5rem;
        height: fit-content;
        border: 1px solid rgba(148, 163, 184, .2);
        box-shadow: 0 16px 30px rgba(2, 6, 23, .34);
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
    .admin-nav-link:hover, .admin-nav-link.active {
        background: linear-gradient(120deg, rgba(201, 106, 74, .26), rgba(245, 158, 11, .2));
        color: #fff;
        transform: translateX(2px);
    }
    .admin-main { min-width:0; }
    .admin-topbar {
        background: linear-gradient(135deg, rgba(255, 255, 255, .96), rgba(248, 250, 252, .92));
        border: 1px solid rgba(148, 163, 184, .25);
        border-radius: 1rem;
        padding: 1rem 1.2rem;
        margin-bottom: 1rem;
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
    .admin-title { font-size:1.8rem; font-weight:680; color:#111827; }
    .admin-kicker { text-transform:uppercase; letter-spacing:.08em; font-size:.7rem; color:#8C2F39; font-weight:700; }
    .admin-subtitle { color:#4b5563; font-size:.95rem; margin-top:.35rem; }
    .admin-label { font-size:.82rem; font-weight:600; color:#1f2937; display:block; margin-bottom:.35rem; }
    .admin-input { width:100%; border:1px solid #d1d5db; border-radius:.6rem; padding:.6rem .75rem; background:#fff; }
    .admin-input:focus { outline:none; border-color:#C96A4A; box-shadow:0 0 0 3px rgba(201,106,74,.2); }
    .admin-btn { border-radius:.6rem; padding:.55rem .9rem; font-weight:600; font-size:.88rem; }
    .admin-btn-primary { background:#C96A4A; color:#fff; }
    .admin-btn-secondary { background:#e5e7eb; color:#111827; }
    .admin-btn-secondary:hover { background:#d1d5db; }
    .admin-btn-primary:hover { background:#b85b3d; }
    .admin-metric { background: linear-gradient(145deg, #fff, #f8fafc); border: 1px solid rgba(148, 163, 184, .22); border-radius: .95rem; padding: .95rem 1rem; }
    .admin-metric-label { color:#64748b; font-size:.74rem; text-transform:uppercase; letter-spacing:.08em; font-weight:700; }
    .admin-metric-value { color:#0f172a; font-size:1.7rem; font-weight:700; margin-top:.2rem; line-height:1.1; }
    .admin-list-row { display:flex; justify-content:space-between; align-items:flex-start; gap: .75rem; padding:.7rem 0; border-bottom:1px solid #f1f5f9; font-size:.9rem; }
    .admin-list-row:last-child { border-bottom: 0; padding-bottom:0; }
    .admin-chip { display:inline-flex; align-items:center; border:1px solid #cbd5e1; border-radius:999px; padding:.28rem .6rem; font-size:.74rem; font-weight:600; color:#475569; background:#f8fafc; }
    .admin-content { display: grid; gap: 1rem; }
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

        <div class="admin-content">
            @yield('content')
        </div>
    </div>
</div>
@endsection
