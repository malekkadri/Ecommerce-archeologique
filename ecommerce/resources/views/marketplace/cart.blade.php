@extends('layouts.app')

@section('content')
@include('components.front.page-header', [
    'kicker' => __('messages.cart'),
    'title' => __('messages.cart'),
    'subtitle' => 'Review your selections with full pricing transparency before checkout.',
    'actions' => $cartItems->isNotEmpty() ? '<a href="'.route('checkout.index').'" class="fo-btn fo-btn-primary">'.__('messages.proceed_checkout').'</a>' : null,
])
<section class="max-w-6xl mx-auto px-4 py-8">
    @if($cartItems->isEmpty())
        @include('components.front.empty-state', [
            'title' => __('messages.empty_cart'),
            'subtitle' => 'Your cart is ready when you are. Explore curated products to build your practical setup.',
            'action' => '<a href="'.route('marketplace.index').'" class="fo-btn fo-btn-primary">'.__('messages.nav_marketplace').'</a>'
        ])
    @else
        <div class="grid lg:grid-cols-[1.4fr_.8fr] gap-6 items-start">
            <div class="space-y-3">
                @foreach($cartItems as $item)
                    <div class="fo-card p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="font-semibold">{{ optional($item->product)->name ?? __('messages.product_unavailable') }}</p>
                            <p class="text-sm text-charcoal/70">{{ number_format($item->unit_price, 2) }} TND</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" min="1" max="99" value="{{ $item->quantity }}" class="fo-input w-20 !py-2">
                                <button class="fo-btn fo-btn-secondary">{{ __('messages.update_quantity') }}</button>
                            </form>
                            <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="fo-btn bg-deepred text-white">{{ __('messages.remove') }}</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <aside class="fo-panel p-5 sticky top-24 space-y-4">
                <p class="text-sm text-charcoal/70">{{ __('messages.subtotal') }}</p>
                <p class="text-3xl font-semibold text-deepred">{{ number_format($subtotal, 2) }} TND</p>
                @include('components.front.reassurance-list', ['items' => ['No hidden fees.', 'Review and edit quantity before payment.', 'Confirmation and order tracking after checkout.']])
                <a href="{{ route('checkout.index') }}" class="w-full fo-btn fo-btn-primary">{{ __('messages.proceed_checkout') }}</a>
            </aside>
        </div>
    @endif
</section>
@endsection
