@extends('layouts.app')
@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-semibold">{{ __('messages.user_dashboard') }}</h1>
    <div class="grid md:grid-cols-3 gap-4 mt-6">
        <div class="bg-white rounded-2xl p-5">{{ __('messages.orders') }}: {{ $ordersCount }}</div>
        <div class="bg-white rounded-2xl p-5">{{ __('messages.bookings') }}: {{ $bookingsCount }}</div>
        <div class="bg-white rounded-2xl p-5">{{ __('messages.courses') }}: {{ $coursesCount }}</div>
    </div>
    <div class="mt-6 bg-white rounded-2xl p-5">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold">{{ __('messages.recent_orders') }}</h2>
            <a href="{{ route('dashboard.orders') }}" class="text-terracotta text-sm">{{ __('messages.view_all') }}</a>
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
