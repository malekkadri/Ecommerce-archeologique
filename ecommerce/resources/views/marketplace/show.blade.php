@extends('layouts.app')
@section('content')
<section class="max-w-4xl mx-auto px-4 py-12"><h1 class="text-4xl font-semibold">{{ $product->name }}</h1><p class="mt-4">{{ $product->description }}</p><p class="mt-4 text-2xl text-deepred">{{ number_format($product->price,2) }} TND</p></section>
@endsection
