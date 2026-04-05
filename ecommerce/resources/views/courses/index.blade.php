@extends('layouts.app')
@section('content')
<section class="max-w-7xl mx-auto px-4 py-12"><h1 class="text-3xl font-semibold mb-6">{{ __('messages.nav_courses') }}</h1><div class="grid md:grid-cols-3 gap-4">@foreach($courses as $course)<a href="{{ route('courses.show',$course->slug) }}" class="bg-white p-5 rounded-2xl"><h3 class="font-semibold">{{ $course->title }}</h3><p class="text-sm mt-2">{{ $course->summary }}</p></a>@endforeach</div><div class="mt-5">{{ $courses->links() }}</div></section>
@endsection
