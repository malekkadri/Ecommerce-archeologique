@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-semibold">{{ __('messages.my_courses') }}</h1>

    @if($enrollments->isEmpty())
        <div class="mt-6 bg-white rounded-2xl p-8 text-center text-charcoal/70">{{ __('messages.empty_state') }}</div>
    @else
        <div class="mt-6 space-y-3">
            @foreach($enrollments as $enrollment)
                <div class="bg-white p-4 rounded-xl border border-sand/60">
                    <div class="flex justify-between items-center gap-3">
                        <div>
                            <p class="font-semibold">{{ $enrollment->course->title }}</p>
                            <p class="text-xs text-charcoal/60">{{ __('messages.lessons') }}: {{ $enrollment->course->lessons->count() }}</p>
                        </div>
                        <span class="text-sm font-semibold">{{ $enrollment->progress_percent }}%</span>
                    </div>
                    <div class="mt-2 h-2 bg-sand rounded-full overflow-hidden">
                        <div class="h-2 bg-olive" style="width: {{ max(0, min(100, $enrollment->progress_percent)) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $enrollments->links() }}</div>
    @endif
</section>
@endsection
