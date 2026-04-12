@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['kicker' => __('messages.nav_workshops'), 'title' => __('messages.nav_workshops'), 'subtitle' => 'Live, practice-first sessions for direct feedback and real-time confidence.', 'meta' => [__('messages.seats'), __('messages.reserve'), 'Guided practice']])
<section class="max-w-7xl mx-auto px-4 py-8">
    @include('components.front.section-intro', [
        'kicker' => 'Live learning',
        'title' => 'Join hands-on workshops with guided accountability.',
        'subtitle' => 'Each session is designed for applied outcomes, live support, and concrete next steps you can execute immediately.',
        'variant' => 'education',
    ])

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($workshops as $workshop)
            <a href="{{ route('workshops.show',$workshop->slug) }}" class="fo-card fo-card-hover p-6 flex flex-col h-full">
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
