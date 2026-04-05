@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl p-8">
        <h1 class="text-3xl font-semibold">{{ __('messages.order_confirmation') }}</h1>
        <p class="mt-2 text-charcoal/70">{{ __('messages.order_reference') }}: <span class="font-semibold">{{ $order->reference }}</span></p>
        <p class="text-charcoal/70">{{ __('messages.order_status') }}: {{ ucfirst($order->status) }}</p>
        <p class="text-charcoal/70">{{ __('messages.payment_method') }}: {{ __('messages.cash_on_delivery') }}</p>

        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-3">{{ __('messages.order_items') }}</h2>
            <div class="space-y-2">
                @foreach($order->items as $item)
                    <div class="flex justify-between border-b border-sand py-2">
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
    </div>
</section>
@endsection
