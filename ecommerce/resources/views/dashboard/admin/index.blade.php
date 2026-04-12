@extends('layouts.admin')
@section('admin_title', __('messages.admin_dashboard'))

@section('content')
<section class="space-y-5">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <p class="admin-kicker">Overview</p>
            <h1 class="admin-title">{{ __('messages.admin_dashboard') }}</h1>
            <p class="admin-subtitle">A clean back-office hub to track key activity and jump into management pages quickly.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.products.index') }}" class="admin-chip">{{ __('messages.products') }}</a>
            <a href="{{ route('admin.users.index') }}" class="admin-chip">{{ __('messages.users') }}</a>
            <a href="{{ route('admin.contents.index') }}" class="admin-chip">{{ __('messages.contents') }}</a>
            <a href="{{ route('admin.workshops.index') }}" class="admin-chip">{{ __('messages.workshops') }}</a>
            <a href="{{ route('admin.contact-inquiries.index') }}" class="admin-chip">{{ __('messages.inquiries') }}</a>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="admin-metric"><p class="admin-metric-label">{{ __('messages.users') }}</p><p class="admin-metric-value">{{ $usersCount }}</p></div>
        <div class="admin-metric"><p class="admin-metric-label">{{ __('messages.vendors') }}</p><p class="admin-metric-value">{{ $vendorsCount }}</p></div>
        <div class="admin-metric"><p class="admin-metric-label">{{ __('messages.products') }}</p><p class="admin-metric-value">{{ $productsCount }}</p></div>
        <div class="admin-metric"><p class="admin-metric-label">{{ __('messages.orders') }}</p><p class="admin-metric-value">{{ $ordersCount }}</p></div>
        <div class="admin-metric"><p class="admin-metric-label">{{ __('messages.courses') }}</p><p class="admin-metric-value">{{ $coursesCount }}</p></div>
        <div class="admin-metric"><p class="admin-metric-label">{{ __('messages.workshops') }}</p><p class="admin-metric-value">{{ $workshopsCount }}</p></div>
        <div class="admin-metric"><p class="admin-metric-label">{{ __('messages.contents') }}</p><p class="admin-metric-value">{{ $contentCount }}</p></div>
        <div class="admin-metric"><p class="admin-metric-label">{{ __('messages.inquiries') }}</p><p class="admin-metric-value">{{ $inquiriesCount }}</p></div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="admin-card p-5">
            <h2 class="font-semibold mb-3">{{ __('messages.recent_orders') }}</h2>
            <div class="space-y-2 text-sm">
                @forelse($recentOrders as $order)
                    <div class="admin-list-row">
                        <span>{{ $order->reference }} · {{ optional($order->user)->name }}</span>
                        <span>{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                    </div>
                @empty
                    <p class="text-slate-500">{{ __('messages.empty_state') }}</p>
                @endforelse
            </div>
        </div>

        <div class="admin-card p-5">
            <h2 class="font-semibold mb-3">{{ __('messages.recent_inquiries') }}</h2>
            <div class="space-y-2 text-sm">
                @forelse($recentInquiries as $inquiry)
                    <div class="admin-list-row">
                        <p class="font-medium">{{ $inquiry->subject }}</p>
                        <p class="text-slate-500">{{ $inquiry->name }} · {{ $inquiry->status }}</p>
                    </div>
                @empty
                    <p class="text-slate-500">{{ __('messages.empty_state') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="admin-card p-5">
            <h2 class="font-semibold mb-3">{{ __('messages.low_stock_products') }}</h2>
            <div class="space-y-2 text-sm">
                @forelse($lowStockProducts as $product)
                    <div class="admin-list-row">
                        <span>{{ $product->name }}</span>
                        <span class="text-deepred font-semibold">{{ $product->stock }}</span>
                    </div>
                @empty
                    <p class="text-slate-500">{{ __('messages.empty_state') }}</p>
                @endforelse
            </div>
        </div>
        <div class="admin-card p-5">
            <h2 class="font-semibold mb-3">{{ __('messages.upcoming_workshops') }}</h2>
            <div class="space-y-2 text-sm">
                @forelse($upcomingWorkshops as $workshop)
                    <div class="admin-list-row">
                        <span>{{ $workshop->title }}</span>
                        <span>{{ $workshop->starts_at->format('Y-m-d') }}</span>
                    </div>
                @empty
                    <p class="text-slate-500">{{ __('messages.empty_state') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
