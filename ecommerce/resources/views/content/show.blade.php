@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-12">
    <div class="fo-panel p-7">
        <h1 class="fo-page-title">{{ $content->title }}</h1>
        <p class="mt-3 text-sm text-charcoal/60">{{ optional($content->category)->name }} • {{ optional($content->published_at)->format('Y-m-d') }}</p>

        @auth
            <form method="POST" action="{{ route('favorites.toggle') }}" class="mt-4">@csrf
                <input type="hidden" name="type" value="content">
                <input type="hidden" name="id" value="{{ $content->id }}">
                <button class="fo-btn fo-btn-secondary">{{ __('messages.toggle_favorite') }}</button>
            </form>
        @endauth

        <article class="prose max-w-none mt-8 text-charcoal/90">{!! nl2br(e($content->body)) !!}</article>
    </div>
</section>
@endsection
