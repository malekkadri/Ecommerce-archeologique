@extends('layouts.app')
@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="fo-card p-3 h-fit">
            <div class="h-80 overflow-hidden rounded-xl bg-sand/40">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full flex items-center justify-center text-charcoal/50">No image available</div>
                @endif
            </div>
        </div>

        <div class="fo-panel p-7">
            <h1 class="fo-page-title">{{ $product->name }}</h1>
            <p class="mt-3 text-charcoal/80">{{ $product->description }}</p>
            <p class="mt-5 text-3xl font-semibold text-deepred">{{ number_format($product->price,2) }} TND</p>
            <p class="mt-1 text-sm text-charcoal/70">{{ __('messages.stock') }}: {{ $product->stock }}</p>

            @auth
                <form method="POST" action="{{ route('favorites.toggle') }}" class="mt-3">@csrf
                    <input type="hidden" name="type" value="product">
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <button class="fo-btn fo-btn-secondary">{{ __('messages.toggle_favorite') }}</button>
                </form>

                <form action="{{ route('cart.store') }}" method="POST" class="mt-6 fo-card p-4 flex items-end gap-3 max-w-md">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div>
                        <label class="text-sm font-medium">{{ __('messages.quantity') }}</label>
                        <input type="number" name="quantity" min="1" max="99" value="1" class="fo-input w-24 mt-1">
                    </div>
                    <button class="fo-btn fo-btn-primary">{{ __('messages.add_to_cart') }}</button>
                </form>
            @else
                <p class="mt-4 text-sm text-charcoal/70">{{ __('messages.login_to_order') }}</p>
            @endauth
        </div>
    </div>
</section>
@endsection
