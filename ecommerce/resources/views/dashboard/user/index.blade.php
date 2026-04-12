@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['title' => __('messages.user_dashboard'), 'subtitle' => __('messages.order_summary')])
<section class="max-w-6xl mx-auto px-4 py-8 space-y-6">
    @include('components.front.dashboard-nav')

    <div class="grid md:grid-cols-3 gap-4">
        <div class="fo-card p-5"><p class="text-sm text-charcoal/70">{{ __('messages.orders') }}</p><p class="text-3xl font-semibold mt-1">{{ $ordersCount }}</p></div>
        <div class="fo-card p-5"><p class="text-sm text-charcoal/70">{{ __('messages.bookings') }}</p><p class="text-3xl font-semibold mt-1">{{ $bookingsCount }}</p></div>
        <div class="fo-card p-5"><p class="text-sm text-charcoal/70">{{ __('messages.courses') }}</p><p class="text-3xl font-semibold mt-1">{{ $coursesCount }}</p></div>
    </div>

    <div class="fo-panel p-5">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-lg">{{ __('messages.recent_orders') }}</h2>
            <a href="{{ route('dashboard.orders') }}" class="text-deepred text-sm">{{ __('messages.view_all') }}</a>
        </div>
        <div class="mt-3 space-y-2 text-sm">
            @forelse($recentOrders as $order)
                <div class="flex items-center justify-between border-b border-sand/70 pb-2">
                    <span>{{ $order->reference }}</span>
                    <span>{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                </div>
            @empty
                <p class="text-charcoal/70">{{ __('messages.no_orders_yet') }}</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
