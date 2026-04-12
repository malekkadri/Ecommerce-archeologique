@extends('layouts.app')

@section('content')
@include('components.front.page-header', ['variant' => 'dashboard', 'title' => __('messages.my_bookings'), 'subtitle' => 'Your upcoming workshop commitments with at-a-glance seat and session context.'])
<section class="max-w-5xl mx-auto px-4 py-8 space-y-6" data-page="dashboard-bookings">
    @include('components.front.dashboard-nav')
    <div class="space-y-2">
        @forelse($bookings as $booking)
            <article class="fo-card p-4 md:p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-semibold">{{ $booking->workshop->title }}</p>
                        <p class="text-xs text-charcoal/60 mt-1">{{ optional($booking->workshop->starts_at)->format('Y-m-d H:i') }} · {{ $booking->workshop->location }}</p>
                    </div>
                    <span class="fo-chip">{{ $booking->seats }} {{ __('messages.seats') }}</span>
                </div>
            </article>
        @empty
            @include('components.front.empty-state', ['title' => __('messages.empty_state'), 'subtitle' => 'Reserve a workshop seat to see your session planning details here.'])
        @endforelse
    </div>
</section>
@endsection
