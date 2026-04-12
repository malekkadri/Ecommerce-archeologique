@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="fo-panel p-7 md:p-8">
        <p class="fo-kicker">Editorial</p>
        <h1 class="fo-page-title mt-2">{{ $content->title }}</h1>
        <div class="mt-3 flex flex-wrap gap-2 text-sm text-charcoal/65">
            <span class="fo-chip">{{ optional($content->category)->name }}</span>
            <span class="fo-chip">{{ optional($content->published_at)->format('Y-m-d') }}</span>
            <span class="fo-chip">Guided reading</span>
        </div>

        <div class="fo-callout mt-6 text-sm text-charcoal/80">
            <p class="font-semibold">Why this matters</p>
            <p class="mt-1">Use this article as practical context before selecting a course, workshop, or product.</p>
        </div>

        @auth
            <form method="POST" action="{{ route('favorites.toggle') }}" class="mt-5">@csrf
                <input type="hidden" name="type" value="content">
                <input type="hidden" name="id" value="{{ $content->id }}">
                <button class="fo-btn fo-btn-secondary">{{ __('messages.toggle_favorite') }}</button>
            </form>
        @endauth

        <article class="fo-readable max-w-none mt-8 text-charcoal/90 leading-relaxed">{!! nl2br(e($content->body)) !!}</article>
    </div>
</section>
@endsection
