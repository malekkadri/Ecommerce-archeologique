@extends('layouts.app')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-semibold">{{ __('messages.cart') }}</h1>
        @if($cartItems->isNotEmpty())
            <a href="{{ route('checkout.index') }}" class="bg-terracotta text-white px-4 py-2 rounded-lg">{{ __('messages.proceed_checkout') }}</a>
        @endif
    </div>

    @if($cartItems->isEmpty())
        <div class="mt-6 bg-white rounded-2xl p-8 text-center text-charcoal/70">{{ __('messages.empty_cart') }}</div>
    @else
        <div class="mt-6 space-y-3">
            @foreach($cartItems as $item)
                <div class="bg-white rounded-2xl p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="font-semibold">{{ optional($item->product)->name ?? __('messages.product_unavailable') }}</p>
                        <p class="text-sm text-charcoal/70">{{ number_format($item->unit_price, 2) }} TND</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" min="1" max="99" value="{{ $item->quantity }}" class="w-20 rounded-lg border px-2 py-1.5">
                            <button class="px-3 py-1.5 rounded bg-sand">{{ __('messages.update_quantity') }}</button>
                        </form>
                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1.5 rounded bg-deepred text-white">{{ __('messages.remove') }}</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 bg-white rounded-2xl p-5 flex items-center justify-between">
            <p class="font-semibold">{{ __('messages.subtotal') }}</p>
            <p class="text-xl font-semibold text-deepred">{{ number_format($subtotal, 2) }} TND</p>
        </div>
    @endif
</section>
@endsection
