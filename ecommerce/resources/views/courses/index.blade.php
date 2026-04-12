@extends('layouts.app')
@section('content')
@include('components.front.page-header', [
    'kicker' => __('messages.nav_courses'),
    'title' => __('messages.nav_courses'),
    'subtitle' => __('messages.quick_access_desc'),
])

<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($courses as $course)
            <a href="{{ route('courses.show',$course->slug) }}" class="fo-card fo-card-hover p-5">
                <h3 class="font-semibold text-lg">{{ $course->title }}</h3>
                <p class="text-sm mt-2 text-charcoal/70">{{ $course->summary }}</p>
            </a>
        @endforeach
    </div>
    <div class="mt-6">{{ $courses->links() }}</div>
</section>
@endsection
