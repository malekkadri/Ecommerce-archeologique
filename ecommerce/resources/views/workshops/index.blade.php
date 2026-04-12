@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['title' => __('messages.nav_workshops'), 'subtitle' => __('messages.quick_access_desc')])
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($workshops as $workshop)
            <a href="{{ route('workshops.show',$workshop->slug) }}" class="fo-card fo-card-hover p-5">
                <h3 class="font-semibold text-lg">{{ $workshop->title }}</h3>
                <p class="text-sm mt-2 text-charcoal/70">{{ $workshop->location }} • {{ $workshop->starts_at }}</p>
            </a>
        @endforeach
    </div>
    <div class="mt-6">{{ $workshops->links() }}</div>
</section>
@endsection
