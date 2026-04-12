@extends('layouts.app')

@section('content')
@include('components.front.page-header', ['variant' => 'dashboard', 'title' => __('messages.my_favorites'), 'subtitle' => 'Saved items from across content, education, and commerce in one reusable shortlist.'])
<section class="max-w-6xl mx-auto px-4 py-8 space-y-6" data-page="dashboard-favorites">
    @include('components.front.dashboard-nav')

    @if($favorites->isEmpty())
        @include('components.front.empty-state', ['title' => __('messages.no_favorites_yet'), 'subtitle' => 'Save courses, workshops, products, and editorial pieces to build your own journey shortlist.'])
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($favorites as $favorite)
                @php($item = $favorite->favoritable)
                @if($item)
                    <article class="fo-card p-4 border border-sand/70 flex flex-col">
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
