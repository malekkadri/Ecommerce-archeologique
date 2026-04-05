@extends('layouts.app')
@section('content')<section class="max-w-5xl mx-auto px-4 py-12"><h1 class="text-2xl font-semibold">{{ __('messages.my_courses') }}</h1><div class="mt-4 space-y-2">@foreach($enrollments as $enrollment)<div class="bg-white p-4 rounded-xl">{{ $enrollment->course->title }} - {{ $enrollment->progress_percent }}%</div>@endforeach</div></section>@endsection
