@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-12">
    <div class="fo-panel p-7">
        <h1 class="fo-page-title">{{ $workshop->title }}</h1>
        <p class="mt-3 text-charcoal/80">{{ $workshop->description }}</p>
        <p class="mt-3 text-sm text-charcoal/70">{{ __('messages.seats') }}: {{ max(0, $workshop->capacity - $workshop->reserved_count) }} / {{ $workshop->capacity }}</p>

        @auth
            <div class="mt-4 flex flex-wrap gap-3">
                <form method="POST" action="{{ route('favorites.toggle') }}">@csrf
                    <input type="hidden" name="type" value="workshop">
                    <input type="hidden" name="id" value="{{ $workshop->id }}">
                    <button class="fo-btn fo-btn-secondary">{{ __('messages.toggle_favorite') }}</button>
                </form>
            </div>

            <form method="post" action="{{ route('workshops.book') }}" class="mt-6 flex gap-3 items-end max-w-md">
                @csrf
                <input type="hidden" name="workshop_id" value="{{ $workshop->id }}">
                <div class="flex-1">
                    <label class="text-sm font-medium">{{ __('messages.seats') }}</label>
                    <input type="number" name="seats" min="1" max="10" value="1" class="fo-input mt-1">
                </div>
                <button class="fo-btn fo-btn-primary">{{ __('messages.reserve') }}</button>
            </form>
        @endauth
    </div>
</section>
@endsection
