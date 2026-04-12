@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="fo-panel p-8 md:p-10">
        <div class="h-14 w-14 rounded-full bg-olive/10 text-olive text-2xl flex items-center justify-center">✓</div>
        <h1 class="fo-page-title mt-4">{{ __('messages.order_confirmation') }}</h1>
        <p class="mt-2 text-charcoal/70">{{ __('messages.order_reference') }}: <span class="font-semibold">{{ $order->reference }}</span></p>
        <p class="text-charcoal/70">{{ __('messages.order_status') }}: {{ ucfirst($order->status) }}</p>
        <p class="text-charcoal/70">{{ __('messages.payment_method') }}: {{ __('messages.cash_on_delivery') }}</p>

        <div class="mt-7">
            <h2 class="text-lg font-semibold mb-3">{{ __('messages.order_items') }}</h2>
            <div class="space-y-2">
                @foreach($order->items as $item)
                    <div class="flex justify-between border-b border-sand/80 py-2 text-sm">
                        <span>{{ optional($item->product)->name }} × {{ $item->quantity }}</span>
                        <span>{{ number_format($item->total_price, 2) }} TND</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex justify-between text-lg font-semibold">
                <span>{{ __('messages.total') }}</span>
                <span>{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
            </div>
        </div>
        <div class="mt-6 flex gap-3 flex-wrap">
            <a href="{{ route('marketplace.index') }}" class="fo-btn fo-btn-secondary">{{ __('messages.nav_marketplace') }}</a>
            <a href="{{ route('dashboard.orders') }}" class="fo-btn fo-btn-primary">{{ __('messages.my_orders') }}</a>
        </div>
    </div>
</section>
@endsection
