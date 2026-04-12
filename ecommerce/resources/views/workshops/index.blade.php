@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['kicker' => __('messages.nav_workshops'), 'title' => __('messages.nav_workshops'), 'subtitle' => __('messages.quick_access_desc'), 'meta' => [__('messages.seats'), __('messages.reserve')]])
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($workshops as $workshop)
            <a href="{{ route('workshops.show',$workshop->slug) }}" class="fo-card fo-card-hover p-5 flex flex-col">
                <span class="fo-chip w-fit">Live</span>
                <h3 class="font-semibold text-lg mt-3">{{ $workshop->title }}</h3>
                <p class="text-sm mt-2 text-charcoal/70">{{ $workshop->location }}</p>
                <p class="text-sm text-charcoal/70">{{ $workshop->starts_at }}</p>
                <span class="text-sm font-semibold text-deepred mt-auto pt-4">{{ __('messages.reserve') }} →</span>
            </a>
        @empty
            <div class="col-span-full">@include('components.front.empty-state')</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $workshops->links() }}</div>
</section>
@endsection
