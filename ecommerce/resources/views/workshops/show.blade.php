@extends('layouts.app')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <div class="grid lg:grid-cols-[1.35fr_.85fr] gap-6 items-start">
        <div class="fo-panel p-7">
            @if($workshop->image_url)<div class="mb-5 h-64 overflow-hidden rounded-xl bg-sand/35 border border-sand/80"><img src="{{ $workshop->image_url }}" class="h-full w-full object-cover" alt="{{ $workshop->title }}"></div>@endif
            @if($workshop->mediaGallery->isNotEmpty())
                <div class="mb-5 grid grid-cols-4 gap-2">
                    @foreach($workshop->mediaGallery as $media)
                        <img src="{{ $media->url }}" alt="{{ $workshop->title }}" class="h-16 w-full rounded-md object-cover border border-sand/60">
                    @endforeach
                </div>
            @endif
            <p class="fo-kicker">Workshop</p>
            <h1 class="fo-page-title mt-2">{{ $workshop->title }}</h1>
            <div class="mt-4 flex flex-wrap gap-2">
                <span class="fo-chip fo-chip-status">Live coaching</span>
                <span class="fo-chip fo-chip-status">Practice-first</span>
                <span class="fo-chip fo-chip-status">{{ max(0, $workshop->capacity - $workshop->reserved_count) }} seats left</span>
            </div>
            <article class="mt-5 fo-readable text-charcoal/80"><p>{{ $workshop->description }}</p></article>
            <div class="mt-6 grid sm:grid-cols-2 gap-3 text-sm">
                <div class="fo-surface p-4"><p class="text-charcoal/60">Location</p><p class="font-medium mt-1">{{ $workshop->location }}</p></div>
                <div class="fo-surface p-4"><p class="text-charcoal/60">{{ __('messages.seats') }}</p><p class="font-medium mt-1">{{ max(0, $workshop->capacity - $workshop->reserved_count) }} / {{ $workshop->capacity }}</p></div>
            </div>
            <div class="fo-callout mt-6 text-sm">
                <p class="font-semibold">Outcome framing</p>
                <p class="mt-1.5 text-charcoal/80 leading-relaxed">Best for learners who want live coaching, real-time feedback, and practical accountability from start to finish.</p>
            </div>
        </div>

        <aside class="fo-panel p-6 sticky top-24 fo-sticky-desktop">
            <h2 class="text-xl font-semibold">{{ __('messages.reserve') }}</h2>
            @include('components.front.reassurance-list', [
                'tone' => 'calm',
                'items' => ['Seat selection is shown before submission.', 'Booking is reflected in your dashboard.', 'Clear workshop logistics with no hidden steps.']
            ])
            @auth
                <form method="POST" action="{{ route('favorites.toggle') }}" class="mt-4">@csrf
                    <input type="hidden" name="type" value="workshop">
                    <input type="hidden" name="id" value="{{ $workshop->id }}">
                    <button class="w-full fo-btn fo-btn-secondary">Save for later</button>
                </form>

                <form method="post" action="{{ route('workshops.book') }}" class="mt-4 space-y-3">
                    @csrf
                    <input type="hidden" name="workshop_id" value="{{ $workshop->id }}">
                    <div>
                        <label for="workshop-seats" class="text-sm font-medium">{{ __('messages.seats') }}</label>
                        <input id="workshop-seats" type="number" name="seats" min="1" max="10" value="1" class="fo-input mt-1" aria-describedby="workshop-seats-help">
                        <p id="workshop-seats-help" class="text-xs text-charcoal/60 mt-1">Choose how many seats to reserve in this booking.</p>
                    </div>
                    <button class="w-full fo-btn fo-btn-primary">Reserve your seat</button>
                </form>
            @else
                <p class="mt-4 text-sm text-charcoal/70">{{ __('messages.login_to_order') }}</p>
            @endauth

            <div class="mt-6 border-t border-sand/70 pt-5">
                <h3 class="text-lg font-semibold">{{ __('messages.workshop_subscription_title') }}</h3>
                <p class="text-sm text-charcoal/70 mt-1">{{ __('messages.workshop_subscription_hint') }}</p>
                <form method="post" action="{{ route('workshops.subscribe') }}" class="mt-4 space-y-3">
                    @csrf
                    <input type="hidden" name="workshop_id" value="{{ $workshop->id }}">
                    <input name="name" class="fo-input" placeholder="{{ __('messages.name') }}" value="{{ old('name', optional(auth()->user())->name) }}" required>
                    <input name="email" type="email" class="fo-input" placeholder="Email" value="{{ old('email', optional(auth()->user())->email) }}" required>
                    <input name="phone" class="fo-input" placeholder="{{ __('messages.phone') }}" value="{{ old('phone') }}">
                    <input type="number" name="seats" min="1" max="10" value="{{ old('seats', 1) }}" class="fo-input" required>
                    <button class="w-full fo-btn fo-btn-primary">{{ __('messages.workshop_subscription_cta') }}</button>
                </form>
            </div>
        </aside>
    </div>
</section>
@endsection
