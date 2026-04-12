@extends('layouts.app')

@section('content')
@include('components.front.page-header', ['title' => __('messages.my_courses')])
<section class="max-w-5xl mx-auto px-4 py-8 space-y-6">
    @include('components.front.dashboard-nav')

    @if($enrollments->isEmpty())
        <div class="fo-card p-8 text-center text-charcoal/70">{{ __('messages.empty_state') }}</div>
    @else
        <div class="space-y-3">
            @foreach($enrollments as $enrollment)
                <div class="fo-card p-4 border border-sand/70">
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
