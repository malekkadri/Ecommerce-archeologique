@extends('layouts.app')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-12">
    <div class="grid lg:grid-cols-[1.4fr_.9fr] gap-6 items-start">
        <div class="fo-panel p-8">
            <p class="fo-kicker">Course detail</p>
            <h1 class="fo-page-title mt-2">{{ $course->title }}</h1>
            <p class="mt-4 text-charcoal/80 leading-relaxed">{{ $course->description }}</p>

            <div class="fo-callout mt-6 text-sm">
                <p class="font-semibold">What you get</p>
                <ul class="mt-2 list-disc pl-4 space-y-1 text-charcoal/80">
                    <li>{{ $course->lessons->count() }} practical lessons with clear progression.</li>
                    <li>Self-paced access designed around implementation.</li>
                    <li>Dashboard tracking to monitor your momentum.</li>
                </ul>
            </div>

            <h3 class="mt-9 font-semibold text-xl">{{ __('messages.lessons') }}</h3>
            <ul class="mt-3 space-y-2">
                @foreach($course->lessons as $lesson)
                    <li class="fo-surface px-4 py-3 flex justify-between gap-3">
                        <span>{{ $lesson->title }}</span>
                        <span class="text-xs text-charcoal/60">{{ $lesson->duration_minutes }} min</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <aside class="fo-panel p-6 sticky top-24">
            <p class="text-sm text-charcoal/70">{{ __('messages.nav_courses') }}</p>
            <p class="text-xl font-semibold mt-1">{{ __('messages.continue_learning') }}</p>
            @include('components.front.reassurance-list', [
                'title' => 'Enrollment confidence',
                'items' => ['Immediate access from your dashboard.', 'Progress saved lesson by lesson.', 'Keep the course in your favorites for quick return.']
            ])
            @auth
                <div class="mt-5 flex flex-col gap-3">
                    <form method="POST" action="{{ route('favorites.toggle') }}">@csrf
                        <input type="hidden" name="type" value="course">
                        <input type="hidden" name="id" value="{{ $course->id }}">
                        <button class="w-full fo-btn fo-btn-secondary">{{ __('messages.toggle_favorite') }}</button>
                    </form>

                    @if(!$isEnrolled)
                        <form method="POST" action="{{ route('courses.enroll') }}">@csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button class="w-full fo-btn fo-btn-primary">{{ __('messages.enroll') }}</button>
                        </form>
                    @else
                        <span class="text-sm px-3 py-1.5 rounded-full bg-olive/10 text-olive text-center">{{ __('messages.enrolled') }}</span>
                        <a class="w-full fo-btn fo-btn-secondary" href="{{ route('dashboard.courses') }}">{{ __('messages.continue_learning') }}</a>
                    @endif
                </div>
            @else
                <p class="mt-4 text-sm text-charcoal/70">{{ __('messages.login_to_order') }}</p>
            @endauth
        </aside>
    </div>
</section>
@endsection
