@extends('layouts.app')
@section('content')
<section class="max-w-4xl mx-auto px-4 py-12">
    <div class="mb-6 h-72 overflow-hidden rounded-2xl bg-sand/40">
        @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
        @else
            <div class="h-full w-full flex items-center justify-center text-charcoal/50">No image available</div>
        @endif
    </div>

    <h1 class="text-4xl font-semibold">{{ $product->name }}</h1>
    <p class="mt-4 text-charcoal/80">{{ $product->description }}</p>
    <p class="mt-4 text-2xl text-deepred">{{ number_format($product->price,2) }} TND</p>
    <p class="mt-2 text-sm text-charcoal/70">
        {{ __('messages.stock') }}: {{ $product->stock }}
    </p>

    @auth
<form method="POST" action="{{ route('favorites.toggle') }}" class="mt-3">@csrf
    <input type="hidden" name="type" value="product"> 
    <input type="hidden" name="id" value="{{ $product->id }}"> 
    <button class="text-sm text-deepred">{{ __('messages.toggle_favorite') }}</button>
</form>
@endauth
@auth
        <form action="{{ route('cart.store') }}" method="POST" class="mt-6 bg-white rounded-2xl p-4 flex items-end gap-3 max-w-md">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div>
                <label class="text-sm font-medium">{{ __('messages.quantity') }}</label>
                <input type="number" name="quantity" min="1" max="99" value="1" class="w-24 rounded-lg border px-3 py-2">
            </div>
            <button class="bg-terracotta text-white rounded-lg px-4 py-2">{{ __('messages.add_to_cart') }}</button>
        </form>
    @else
        <p class="mt-4 text-sm text-charcoal/70">{{ __('messages.login_to_order') }}</p>
    @endauth
</section>
@endsection
