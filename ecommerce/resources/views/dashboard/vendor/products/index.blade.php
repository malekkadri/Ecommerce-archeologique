@extends('layouts.app')
@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-3xl font-semibold">{{ __('messages.products') }}</h1>
        <a class="bg-olive text-white px-3 py-2 rounded" href="{{ route('vendor.products.create') }}">{{ __('messages.add_product') }}</a>
    </div>

    <form class="mt-5">
        <input name="q" value="{{ request('q') }}" class="rounded-xl border px-3 py-2 w-full md:w-80" placeholder="{{ __('messages.search_products') }}">
    </form>

    @if($products->isEmpty())
        <div class="mt-6 bg-white rounded-2xl p-10 text-center text-charcoal/70">{{ __('messages.no_products_yet') }}</div>
    @else
        <div class="mt-5 overflow-x-auto bg-white rounded-2xl">
            <table class="min-w-full text-sm">
                <thead class="bg-sand/60">
                    <tr>
                        <th class="px-4 py-3 text-left">Image</th>
                        <th class="px-4 py-3 text-left">{{ __('messages.name') }}</th>
                        <th class="px-4 py-3 text-left">SKU</th>
                        <th class="px-4 py-3 text-left">{{ __('messages.price') }}</th>
                        <th class="px-4 py-3 text-left">{{ __('messages.stock') }}</th>
                        <th class="px-4 py-3 text-left">{{ __('messages.status') }}</th>
                        <th class="px-4 py-3 text-left">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-t border-sand/70">
                            <td class="px-4 py-3">
                                <div class="h-12 w-12 rounded-md overflow-hidden bg-sand/40">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $product->name }}</td>
                            <td class="px-4 py-3">{{ $product->sku ?: '—' }}</td>
                            <td class="px-4 py-3">{{ number_format($product->price, 2) }} TND</td>
                            <td class="px-4 py-3 @if($product->stock < 5) text-deepred font-semibold @endif">{{ $product->stock }}</td>
                            <td class="px-4 py-3">{{ $product->is_active ? __('messages.active') : __('messages.inactive') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('vendor.products.edit',$product) }}" class="text-terracotta">{{ __('messages.edit') }}</a>
                                    <form method="POST" action="{{ route('vendor.products.destroy', $product) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-deepred">{{ __('messages.remove') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    @endif
</section>
@endsection
