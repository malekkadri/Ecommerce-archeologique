@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['kicker' => __('messages.nav_workshops'), 'title' => __('messages.nav_workshops'), 'subtitle' => $websiteSettings['workshops_intro'] ?? 'Live, practice-first sessions for direct feedback and real-time confidence.', 'meta' => [__('messages.seats'), __('messages.reserve'), 'Guided practice']])
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($workshops as $workshop)
            <a href="{{ route('workshops.show',$workshop->slug) }}" class="fo-card fo-card-hover p-6 flex flex-col h-full">
                <div class="mb-3 h-40 overflow-hidden rounded-xl bg-sand/40 border border-sand/80">
                    @if($workshop->image_url)<img src="{{ $workshop->image_url }}" alt="{{ $workshop->title }}" class="h-full w-full object-cover">@else<div class="h-full w-full flex items-center justify-center text-xs text-charcoal/45">No image</div>@endif
                </div>
                <span class="fo-chip w-fit">Live workshop</span>
                <h3 class="font-semibold text-xl mt-3 leading-snug">{{ $workshop->title }}</h3>
                <div class="mt-3 space-y-1.5 text-sm text-charcoal/72">
                    <p><span class="font-medium text-charcoal/85">Location:</span> {{ $workshop->location }}</p>
                    <p><span class="font-medium text-charcoal/85">Date:</span> {{ optional($workshop->starts_at)->format('M d, Y H:i') }}</p>
                </div>
                <p class="text-xs text-charcoal/65 mt-3">Best for learners who want accountability and coached implementation.</p>
                <span class="text-sm font-semibold text-deepred mt-auto pt-4">View details →</span>
            </a>
        @empty
            <div class="col-span-full">@include('components.front.empty-state', ['subtitle' => 'No workshop dates are currently open. Check back soon or start with a course today.'])</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $workshops->links() }}</div>
</section>
@endsection
