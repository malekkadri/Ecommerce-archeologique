@extends('layouts.app')

@section('content')
@include('components.front.page-header', ['title' => __('messages.my_favorites')])
<section class="max-w-6xl mx-auto px-4 py-8 space-y-6">
    @include('components.front.dashboard-nav')

    @if($favorites->isEmpty())
        <div class="fo-card p-8 text-center text-charcoal/70">{{ __('messages.no_favorites_yet') }}</div>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($favorites as $favorite)
                @php($item = $favorite->favoritable)
                @if($item)
                    <article class="fo-card p-4 border border-sand/70">
                        <p class="text-xs uppercase tracking-wide text-charcoal/60">{{ class_basename($favorite->favoritable_type) }}</p>
                        <h2 class="font-semibold mt-1">{{ $item->title ?? $item->name }}</h2>
                        <form class="mt-4" method="POST" action="{{ route('favorites.toggle') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="hidden" name="type" value="{{ strtolower(class_basename($favorite->favoritable_type)) }}">
                            <button class="fo-btn fo-btn-secondary">{{ __('messages.remove_favorite') }}</button>
                        </form>
                    </article>
                @endif
            @endforeach
        </div>
        <div class="mt-4">{{ $favorites->links() }}</div>
    @endif
</section>
@endsection
