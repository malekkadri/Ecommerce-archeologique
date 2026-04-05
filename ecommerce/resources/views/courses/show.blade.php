@extends('layouts.app')
@section('content')
<section class="max-w-5xl mx-auto px-4 py-12"><h1 class="text-4xl font-semibold">{{ $course->title }}</h1><p class="mt-4">{{ $course->description }}</p>@auth<form method="post" action="{{ route('courses.enroll') }}" class="mt-5">@csrf<input type="hidden" name="course_id" value="{{ $course->id }}"><button class="bg-olive text-white px-4 py-2 rounded-xl">{{ __('messages.enroll') }}</button></form>@endauth<h3 class="mt-10 font-semibold">{{ __('messages.lessons') }}</h3><ul class="mt-3 space-y-2">@foreach($course->lessons as $lesson)<li class="bg-white rounded-xl px-4 py-3">{{ $lesson->title }}</li>@endforeach</ul></section>
@endsection
