@extends('layouts.app')
@section('content')
<section class="max-w-6xl mx-auto px-4 py-10" data-page="product-detail">
    <div class="grid lg:grid-cols-2 gap-6 items-start">
        <div class="fo-card p-3 h-fit">
            <div class="h-80 overflow-hidden rounded-xl bg-sand/40 border border-sand/70">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full flex items-center justify-center text-charcoal/50">No image available</div>
                @endif
            </div>
            @if($product->mediaGallery->isNotEmpty())
                <div class="mt-3 grid grid-cols-4 gap-2">
                    @foreach($product->mediaGallery as $media)
                        <img src="{{ $media->url }}" alt="{{ $product->name }}" class="h-16 w-full rounded-md object-cover border border-sand/60">
                    @endforeach
                </div>
            @endif
        </div>

        <aside class="fo-panel p-7 sticky top-24 fo-sticky-desktop">
            <p class="fo-kicker">Commerce detail</p>
            <h1 class="fo-page-title mt-2">{{ $product->name }}</h1>
            <p class="mt-3 text-charcoal/80 leading-relaxed">{{ $product->description }}</p>
            <p class="mt-5 text-3xl font-semibold text-deepred">{{ number_format($product->price,2) }} TND</p>
            <p class="mt-1 text-sm text-charcoal/70">{{ __('messages.stock') }}: {{ $product->stock }}</p>

            @include('components.front.reassurance-list', [
                'title' => 'Before you buy',
                'tone' => 'commerce',
                'items' => ['Transparent pricing and quantity selection.', 'Secure checkout with immediate order reference.', 'Chosen for compatibility with MIDA learning paths.']
            ])

            @auth
                <div class="mt-4 flex flex-wrap gap-2" data-cta-group="product-support">
                    <form method="POST" action="{{ route('favorites.toggle') }}">@csrf
                        <input type="hidden" name="type" value="product">
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <button class="fo-btn fo-btn-secondary">{{ __('messages.toggle_favorite') }}</button>
                    </form>
                    <a href="{{ route('cart.index') }}" class="fo-btn fo-btn-ghost inline-flex items-center gap-2">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="9" cy="20" r="1"></circle>
                            <circle cx="18" cy="20" r="1"></circle>
                            <path d="M2 3h2l2.4 11.2a2 2 0 0 0 2 1.6h8.9a2 2 0 0 0 2-1.7L21 7H7"></path>
                        </svg>
                        <span>{{ __('messages.cart') }}</span>
                        @if(($cartQuantity ?? 0) > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[11px] font-semibold rounded-full bg-deepred text-white">{{ $cartQuantity }}</span>
                        @endif
                    </a>
                </div>

                @if(($cartQuantity ?? 0) > 0)
                    <p class="mt-3 text-sm text-deepred font-medium">{{ $cartQuantity }} {{ strtolower(__('messages.products')) }} {{ strtolower(__('messages.cart')) }}</p>
                @endif

                <form action="{{ route('cart.store') }}" method="POST" class="mt-5 fo-surface p-4 flex flex-wrap items-end gap-3" id="product-add-to-cart">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div>
                        <label class="text-sm font-medium">{{ __('messages.quantity') }}</label>
                        <input type="number" name="quantity" min="1" max="99" value="1" class="fo-input w-24 mt-1">
                    </div>
                    <button class="fo-btn fo-btn-primary" data-cta="product-add-to-cart">{{ __('messages.add_to_cart') }}</button>
                </form>
            @else
                <p class="mt-4 text-sm text-charcoal/70">{{ __('messages.login_to_order') }}</p>
            @endauth
        </aside>
    </div>
</section>
@endsection
