@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="fo-panel p-8">
        <h1 class="fo-page-title">{{ $course->title }}</h1>
        <p class="mt-4 text-charcoal/80">{{ $course->description }}</p>

        @auth
            <div class="mt-5 flex flex-wrap items-center gap-3">
                <form method="POST" action="{{ route('favorites.toggle') }}">@csrf
                    <input type="hidden" name="type" value="course">
                    <input type="hidden" name="id" value="{{ $course->id }}">
                    <button class="fo-btn fo-btn-secondary">{{ __('messages.toggle_favorite') }}</button>
                </form>

                @if(!$isEnrolled)
                    <form method="POST" action="{{ route('courses.enroll') }}">@csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <button class="fo-btn fo-btn-primary">{{ __('messages.enroll') }}</button>
                    </form>
                @else
                    <span class="text-sm px-3 py-1 rounded-full bg-olive/10 text-olive">{{ __('messages.enrolled') }}</span>
                    <a class="fo-btn fo-btn-secondary" href="{{ route('dashboard.courses') }}">{{ __('messages.continue_learning') }}</a>
                @endif
            </div>
        @else
            <p class="mt-4 text-sm text-charcoal/70">{{ __('messages.login_to_order') }}</p>
        @endauth
    </div>

    <h3 class="mt-10 font-semibold text-xl">{{ __('messages.lessons') }}</h3>
    <ul class="mt-3 space-y-2">
        @foreach($course->lessons as $lesson)
            <li class="fo-card px-4 py-3 flex justify-between gap-3">
                <span>{{ $lesson->title }}</span>
                <span class="text-xs text-charcoal/60">{{ $lesson->duration_minutes }} min</span>
            </li>
        @endforeach
    </ul>
</section>
@endsection
