@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['variant' => 'dashboard', 'kicker' => __('messages.user_dashboard'), 'title' => __('messages.user_dashboard'), 'subtitle' => 'Utility-first control center for progress, purchases, and next best actions.', 'meta' => [__('messages.my_orders'), __('messages.my_courses'), __('messages.my_favorites')]])
<section class="max-w-6xl mx-auto px-4 py-8 space-y-6" data-page="dashboard-home">
    @include('components.front.dashboard-nav')

    <div class="grid md:grid-cols-3 gap-4">
        <div class="fo-card p-5"><p class="text-sm text-charcoal/70">{{ __('messages.orders') }}</p><p class="text-3xl font-semibold mt-1">{{ $ordersCount }}</p><p class="text-xs text-charcoal/60 mt-2">Commerce confirmations and fulfillment tracking.</p></div>
        <div class="fo-card p-5"><p class="text-sm text-charcoal/70">{{ __('messages.bookings') }}</p><p class="text-3xl font-semibold mt-1">{{ $bookingsCount }}</p><p class="text-xs text-charcoal/60 mt-2">Live sessions with timing and seat commitments.</p></div>
        <div class="fo-card p-5"><p class="text-sm text-charcoal/70">{{ __('messages.courses') }}</p><p class="text-3xl font-semibold mt-1">{{ $coursesCount }}</p><p class="text-xs text-charcoal/60 mt-2">Structured learning milestones and momentum.</p></div>
    </div>

    <div class="fo-panel p-5">
        <div class="flex items-center justify-between gap-2">
            <h2 class="font-semibold text-lg">{{ __('messages.recent_orders') }}</h2>
            <a href="{{ route('dashboard.orders') }}" class="text-deepred text-sm font-semibold">{{ __('messages.view_all') }}</a>
        </div>
        <div class="mt-3 space-y-2 text-sm">
            @forelse($recentOrders as $order)
                <div class="flex items-center justify-between border-b border-sand/70 pb-2 gap-2">
                    <span>{{ $order->reference }}</span>
                    <span class="whitespace-nowrap">{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                </div>
            @empty
                @include('components.front.empty-state', ['size' => 'compact', 'title' => __('messages.no_orders_yet'), 'subtitle' => 'Start with the marketplace to populate your order history and unlock a complete dashboard overview.'])
            @endforelse
        </div>
    </div>
</section>
@endsection
