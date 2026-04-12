@extends('layouts.app')

@section('content')
@include('components.front.page-header', ['title' => __('messages.my_bookings')])
<section class="max-w-5xl mx-auto px-4 py-8 space-y-6">
    @include('components.front.dashboard-nav')
    <div class="space-y-2">
        @forelse($bookings as $booking)
            <div class="fo-card p-4 flex items-center justify-between">
                <span class="font-medium">{{ $booking->workshop->title }}</span>
                <span class="text-sm text-charcoal/70">{{ $booking->seats }} {{ __('messages.seats') }}</span>
            </div>
        @empty
            <div class="fo-card p-8 text-center text-charcoal/70">{{ __('messages.empty_state') }}</div>
        @endforelse
    </div>
</section>
@endsection
