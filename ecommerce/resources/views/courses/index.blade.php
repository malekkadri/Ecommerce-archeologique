@extends('layouts.app')
@section('content')
@include('components.front.page-header', [
    'variant' => 'education',
    'kicker' => __('messages.nav_courses'),
    'title' => __('messages.nav_courses'),
    'subtitle' => 'Step-by-step learning paths designed for practical confidence and measurable progress.',
    'meta' => [__('messages.featured_courses'), __('messages.lessons'), 'Structured progression'],
])

<section class="max-w-7xl mx-auto px-4 py-8">
    @include('components.front.section-intro', [
        'kicker' => 'Learning catalog',
        'title' => 'Choose a course by your next practical milestone.',
        'subtitle' => 'Each course combines focused lessons with action-oriented outcomes, so you always know what you will be able to do next.',
    ])

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($courses as $course)
            <a href="{{ route('courses.show',$course->slug) }}" class="fo-card fo-card-hover p-6 flex flex-col h-full">
                <p class="fo-kicker">Course</p>
                <h3 class="font-semibold text-xl mt-2 leading-snug">{{ $course->title }}</h3>
                <p class="text-sm mt-3 text-charcoal/72">{{ \Illuminate\Support\Str::limit($course->summary, 120) }}</p>
                <p class="text-xs text-charcoal/65 mt-2">Ideal for learners who want structure, progress tracking, and repeatable results.</p>
                <span class="mt-auto pt-4 text-sm font-semibold text-deepred">{{ __('messages.enroll') }} →</span>
            </a>
        @empty
            <div class="col-span-full">@include('components.front.empty-state', ['title' => __('messages.empty_state'), 'subtitle' => 'New learning paths are in preparation. Explore workshops for live practice in the meantime.'])</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $courses->links() }}</div>
</section>
@endsection
