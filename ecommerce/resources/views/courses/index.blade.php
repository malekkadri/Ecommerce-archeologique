@extends('layouts.app')
@section('content')
@include('components.front.page-header', [
    'kicker' => __('messages.nav_courses'),
    'title' => __('messages.nav_courses'),
    'subtitle' => __('messages.quick_access_desc'),
    'meta' => [__('messages.featured_courses'), __('messages.lessons')],
])

<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($courses as $course)
            <a href="{{ route('courses.show',$course->slug) }}" class="fo-card fo-card-hover p-6 flex flex-col h-full">
                <p class="fo-kicker">Course</p>
                <h3 class="font-semibold text-xl mt-2 leading-snug">{{ $course->title }}</h3>
                <p class="text-sm mt-3 text-charcoal/72">{{ \Illuminate\Support\Str::limit($course->summary, 120) }}</p>
                <span class="mt-auto pt-4 text-sm font-semibold text-deepred">{{ __('messages.enroll') }} →</span>
            </a>
        @empty
            @include('components.front.empty-state', ['title' => __('messages.empty_state')])
        @endforelse
    </div>
    <div class="mt-6">{{ $courses->links() }}</div>
</section>
@endsection
