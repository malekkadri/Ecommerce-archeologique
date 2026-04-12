@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12" data-page="order-confirmation">
    <div class="fo-panel p-8 md:p-10">
        <div class="h-14 w-14 rounded-full bg-olive/10 text-olive text-2xl flex items-center justify-center">✓</div>
        <h1 class="fo-page-title mt-4">{{ __('messages.order_confirmation') }}</h1>
        <p class="mt-2 text-charcoal/70">Your order is confirmed and queued for fulfillment.</p>
        <div class="mt-3 grid sm:grid-cols-2 gap-2 text-sm text-charcoal/75">
            <p>{{ __('messages.order_reference') }}: <span class="font-semibold">{{ $order->reference }}</span></p>
            <p>{{ __('messages.order_status') }}: <span class="font-semibold">{{ ucfirst($order->status) }}</span></p>
            <p>{{ __('messages.payment_method') }}: {{ __('messages.cash_on_delivery') }}</p>
            <p>{{ __('messages.total') }}: <span class="font-semibold">{{ number_format($order->total, 2) }} {{ $order->currency }}</span></p>
        </div>

        <div class="fo-callout mt-5 text-sm">
            <p class="font-semibold">What happens next</p>
            <ul class="mt-2 list-disc pl-4 space-y-1 text-charcoal/80">
                <li>Keep your order reference for quick support.</li>
                <li>Track status updates in your dashboard.</li>
                <li>Continue with courses and workshops while this order is being processed.</li>
            </ul>
        </div>

        <div class="mt-7">
            <h2 class="text-lg font-semibold mb-3">{{ __('messages.order_items') }}</h2>
            <div class="space-y-2">
                @foreach($order->items as $item)
                    <div class="flex justify-between border-b border-sand/80 py-2 text-sm gap-2">
                        <span>{{ optional($item->product)->name }} × {{ $item->quantity }}</span>
                        <span class="whitespace-nowrap">{{ number_format($item->total_price, 2) }} TND</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-6 flex gap-3 flex-wrap" data-cta-group="post-purchase-actions">
            <a href="{{ route('dashboard.orders') }}" class="fo-btn fo-btn-primary" data-cta="confirmation-my-orders">{{ __('messages.my_orders') }}</a>
            <a href="{{ route('marketplace.index') }}" class="fo-btn fo-btn-secondary" data-cta="confirmation-continue-shopping">{{ __('messages.nav_marketplace') }}</a>
            <a href="{{ route('courses.index') }}" class="fo-btn fo-btn-ghost" data-cta="confirmation-next-courses">{{ __('messages.nav_courses') }}</a>
        </div>
    </div>
</section>
@endsection
