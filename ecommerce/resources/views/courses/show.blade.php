@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl p-8 border border-sand/70">
        <h1 class="text-4xl font-semibold">{{ $course->title }}</h1>
        <p class="mt-4 text-charcoal/80">{{ $course->description }}</p>

        @auth
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <form method="POST" action="{{ route('favorites.toggle') }}">@csrf
                    <input type="hidden" name="type" value="course">
                    <input type="hidden" name="id" value="{{ $course->id }}">
                    <button class="text-sm text-deepred">{{ __('messages.toggle_favorite') }}</button>
                </form>

                @if(!$isEnrolled)
                    <form method="POST" action="{{ route('courses.enroll') }}">@csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <button class="bg-olive text-white px-4 py-2 rounded-xl">{{ __('messages.enroll') }}</button>
                    </form>
                @else
                    <span class="text-sm px-3 py-1 rounded-full bg-olive/10 text-olive">{{ __('messages.enrolled') }}</span>
                    <a class="text-sm text-terracotta" href="{{ route('dashboard.courses') }}">{{ __('messages.continue_learning') }}</a>
                @endif
            </div>
        @else
            <p class="mt-4 text-sm text-charcoal/70">{{ __('messages.login_to_order') }}</p>
        @endauth
    </div>

    <h3 class="mt-10 font-semibold text-xl">{{ __('messages.lessons') }}</h3>
    <ul class="mt-3 space-y-2">
        @foreach($course->lessons as $lesson)
            <li class="bg-white rounded-xl px-4 py-3 border border-sand/60 flex justify-between">
                <span>{{ $lesson->title }}</span>
                <span class="text-xs text-charcoal/60">{{ $lesson->duration_minutes }} min</span>
            </li>
        @endforeach
    </ul>
</section>
@endsection
