@extends('layouts.app')
@section('content')
@include('components.front.page-header', [
    'variant' => 'education',
    'kicker' => __('messages.nav_courses'),
    'title' => __('messages.nav_courses'),
    'subtitle' => $websiteSettings['courses_intro'] ?? __('messages.courses_subtitle'),
    'meta' => [__('messages.featured_courses'), __('messages.lessons'), __('messages.structured_progression')],
])

<section class="max-w-7xl mx-auto px-4 py-8">
    @include('components.front.section-intro', [
        'kicker' => __('messages.learning_catalog'),
        'title' => __('messages.courses_intro_title'),
        'subtitle' => __('messages.courses_intro_subtitle'),
        'variant' => 'education',
    ])

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($courses as $course)
            <a href="{{ route('courses.show',$course->slug) }}" class="fo-card fo-card-hover p-6 flex flex-col h-full">
                <div class="mb-3 h-40 overflow-hidden rounded-xl bg-sand/40 border border-sand/80">
                    @if($course->image_url)<img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="h-full w-full object-cover">@else<div class="h-full w-full flex items-center justify-center text-xs text-charcoal/45">{{ __('messages.no_image') }}</div>@endif
                </div>
                <p class="fo-kicker">{{ __('messages.course') }}</p>
                <h3 class="font-semibold text-xl mt-2 leading-snug">{{ $course->title }}</h3>
                <p class="text-sm mt-3 text-charcoal/72 leading-relaxed">{{ \Illuminate\Support\Str::limit($course->summary, 140) }}</p>
                <div class="mt-3 flex flex-wrap gap-2 text-xs text-charcoal/70">
                    <span class="fo-chip !py-1 !px-2.5">{{ __('messages.structured_path') }}</span>
                    <span class="fo-chip !py-1 !px-2.5">{{ __('messages.progress_tracking') }}</span>
                </div>
                <p class="text-xs text-charcoal/65 mt-3">{{ __('messages.course_card_hint') }}</p>
                <span class="mt-auto pt-4 text-sm font-semibold text-deepred">{{ __('messages.view_details') }} →</span>
            </a>
        @empty
            <div class="col-span-full">@include('components.front.empty-state', ['title' => __('messages.empty_state'), 'subtitle' => __('messages.courses_empty_subtitle')])</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $courses->links() }}</div>
</section>
@endsection
