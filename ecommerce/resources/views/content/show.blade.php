@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-semibold">{{ $content->title }}</h1>
    <p class="mt-3 text-sm text-gray-600">{{ optional($content->category)->name }} • {{ optional($content->published_at)->format('Y-m-d') }}</p>

    @auth
        <form method="POST" action="{{ route('favorites.toggle') }}" class="mt-3">@csrf
            <input type="hidden" name="type" value="content">
            <input type="hidden" name="id" value="{{ $content->id }}">
            <button class="text-sm text-deepred">{{ __('messages.toggle_favorite') }}</button>
        </form>
    @endauth

    <article class="prose max-w-none mt-8">{!! nl2br(e($content->body)) !!}</article>
</section>
@endsection
