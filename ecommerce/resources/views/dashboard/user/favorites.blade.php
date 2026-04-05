@extends('layouts.app')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-semibold">{{ __('messages.my_favorites') }}</h1>
    @if($favorites->isEmpty())
        <div class="mt-6 bg-white rounded-2xl p-8 text-center text-charcoal/70">{{ __('messages.no_favorites_yet') }}</div>
    @else
        <div class="mt-6 grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($favorites as $favorite)
                @php($item = $favorite->favoritable)
                @if($item)
                    <article class="bg-white rounded-2xl p-4 border border-sand/70">
                        <p class="text-xs uppercase tracking-wide text-charcoal/60">{{ class_basename($favorite->favoritable_type) }}</p>
                        <h2 class="font-semibold mt-1">{{ $item->title ?? $item->name }}</h2>
                        <form class="mt-4" method="POST" action="{{ route('favorites.toggle') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="hidden" name="type" value="{{ strtolower(class_basename($favorite->favoritable_type)) }}">
                            <button class="text-sm text-deepred">{{ __('messages.remove_favorite') }}</button>
                        </form>
                    </article>
                @endif
            @endforeach
        </div>
        <div class="mt-4">{{ $favorites->links() }}</div>
    @endif
</section>
@endsection
