@extends('layouts.app')
@section('content')
@include('components.front.page-header', [
    'id' => 'marketplace-header',
    'variant' => 'commerce',
    'kicker' => __('messages.nav_marketplace'),
    'title' => __('messages.nav_marketplace'),
    'subtitle' => $websiteSettings['marketplace_intro'] ?? 'A commerce-focused catalog of practical essentials selected to support your learning outcomes and everyday execution.',
    'meta' => [__('messages.search_products'), __('messages.stock'), 'Purchase-ready details'],
])
@include('components.front.proof-strip', [
    'variant' => 'commerce',
    'items' => [
        ['value' => $products->total(), 'label' => 'Products available'],
        ['value' => request('q') ? 'Filtered' : 'All', 'label' => 'Catalog mode'],
        ['value' => 'COD', 'label' => 'Payment method'],
        ['value' => 'Live', 'label' => 'Stock visibility'],
    ],
])
<section class="max-w-7xl mx-auto px-4 py-8" data-page="marketplace-list">
    <form class="fo-surface p-4 mb-6 max-w-3xl grid md:grid-cols-[1fr_auto] gap-3 items-end" id="marketplace-search">
        <div>
            <label class="text-xs uppercase tracking-wide text-charcoal/60">{{ __('messages.search_products') }}</label>
            <input name="q" value="{{ request('q') }}" class="fo-input mt-1" placeholder="Search tools, ingredients, or starter kits">
        </div>
        <button class="fo-btn fo-btn-primary" data-cta="marketplace-search-submit">{{ __('messages.search') }}</button>
    </form>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse($products as $product)
            <a href="{{ route('marketplace.show',$product->slug) }}" class="fo-card fo-card-hover p-4 flex flex-col fo-card-commerce" data-cta="marketplace-product-card">
                <div class="mb-3 h-44 overflow-hidden rounded-xl bg-sand/40 border border-sand/80">
                    @if($product->image_url)<img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">@else<div class="h-full w-full flex items-center justify-center text-xs text-charcoal/50">No image</div>@endif
                </div>
                <h3 class="font-semibold leading-snug">{{ $product->name }}</h3>
                <p class="text-deepred mt-2 font-semibold">{{ number_format($product->price,2) }} TND</p>
                <div class="mt-2 flex items-center justify-between text-xs text-charcoal/70">
                    <span>{{ __('messages.stock') }}: {{ $product->stock }}</span>
                    <span class="fo-chip !py-1">Curated</span>
                </div>
                <p class="text-xs text-charcoal/65 mt-2">Selected for practical compatibility with MIDA courses and workshops.</p>
                <span class="text-sm font-semibold text-deepred mt-auto pt-3">{{ __('messages.view') }} →</span>
            </a>
        @empty
            <div class="col-span-full">@include('components.front.empty-state', ['subtitle' => 'No products match this search yet. Try a broader term or browse all items.'])</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
</section>
@endsection
