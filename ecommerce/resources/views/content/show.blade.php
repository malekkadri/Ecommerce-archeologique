@extends('layouts.app')
@section('content')
<section class="max-w-4xl mx-auto px-4 py-12"><h1 class="text-4xl font-semibold">{{ $content->title }}</h1><p class="mt-3 text-sm text-gray-600">{{ optional($content->category)->name }} • {{ $content->published_at }}</p><article class="prose max-w-none mt-8">{!! nl2br(e($content->body)) !!}</article></section>
@endsection
