@extends('layouts.app')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <div class="grid lg:grid-cols-[1.35fr_.85fr] gap-6 items-start">
        <div class="fo-panel p-7">
            <p class="fo-kicker">Workshop</p>
            <h1 class="fo-page-title mt-2">{{ $workshop->title }}</h1>
            <p class="mt-3 text-charcoal/80 leading-relaxed">{{ $workshop->description }}</p>
            <div class="mt-5 grid sm:grid-cols-2 gap-3 text-sm">
                <div class="fo-surface p-3"><p class="text-charcoal/60">Location</p><p class="font-medium">{{ $workshop->location }}</p></div>
                <div class="fo-surface p-3"><p class="text-charcoal/60">{{ __('messages.seats') }}</p><p class="font-medium">{{ max(0, $workshop->capacity - $workshop->reserved_count) }} / {{ $workshop->capacity }}</p></div>
            </div>
        </div>

        <aside class="fo-panel p-6 sticky top-24">
            <h2 class="text-xl font-semibold">{{ __('messages.reserve') }}</h2>
            @auth
                <form method="POST" action="{{ route('favorites.toggle') }}" class="mt-4">@csrf
                    <input type="hidden" name="type" value="workshop">
                    <input type="hidden" name="id" value="{{ $workshop->id }}">
                    <button class="w-full fo-btn fo-btn-secondary">{{ __('messages.toggle_favorite') }}</button>
                </form>

                <form method="post" action="{{ route('workshops.book') }}" class="mt-4 space-y-3">
                    @csrf
                    <input type="hidden" name="workshop_id" value="{{ $workshop->id }}">
                    <div>
                        <label class="text-sm font-medium">{{ __('messages.seats') }}</label>
                        <input type="number" name="seats" min="1" max="10" value="1" class="fo-input mt-1">
                    </div>
                    <button class="w-full fo-btn fo-btn-primary">{{ __('messages.reserve') }}</button>
                </form>
            @else
                <p class="mt-4 text-sm text-charcoal/70">{{ __('messages.login_to_order') }}</p>
            @endauth
        </aside>
    </div>
</section>
@endsection
