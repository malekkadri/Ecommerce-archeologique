@extends('layouts.app')

@section('content')
@include('components.front.page-header', [
    'title' => __('messages.cart'),
    'subtitle' => __('messages.order_summary'),
    'actions' => $cartItems->isNotEmpty() ? '<a href="'.route('checkout.index').'" class="fo-btn fo-btn-primary">'.__('messages.proceed_checkout').'</a>' : null,
])
<section class="max-w-6xl mx-auto px-4 py-8">
    @if($cartItems->isEmpty())
        <div class="fo-card p-10 text-center text-charcoal/70">{{ __('messages.empty_cart') }}</div>
    @else
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
        <div class="mt-6 fo-panel p-5 flex items-center justify-between">
            <p class="font-semibold">{{ __('messages.subtotal') }}</p>
            <p class="text-xl font-semibold text-deepred">{{ number_format($subtotal, 2) }} TND</p>
        </div>
    @endif
</section>
@endsection
