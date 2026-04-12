@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['title' => __('messages.nav_marketplace'), 'subtitle' => __('messages.quick_access_desc')])
<section class="max-w-7xl mx-auto px-4 py-8">
    <form class="fo-panel p-4 mb-6 max-w-xl">
        <input name="q" value="{{ request('q') }}" class="fo-input" placeholder="{{ __('messages.search_products') }}">
    </form>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">@foreach($products as $product)<a href="{{ route('marketplace.show',$product->slug) }}" class="fo-card fo-card-hover p-4"><div class="mb-3 h-44 overflow-hidden rounded-xl bg-sand/40">@if($product->image_url)<img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">@else<div class="h-full w-full flex items-center justify-center text-xs text-charcoal/50">No image</div>@endif</div><h3 class="font-semibold">{{ $product->name }}</h3><p class="text-deepred mt-2 font-semibold">{{ number_format($product->price,2) }} TND</p><p class="text-xs text-charcoal/70 mt-1">{{ __('messages.stock') }}: {{ $product->stock }}</p></a>@endforeach</div><div class="mt-6">{{ $products->links() }}</div>
</section>
@endsection
