@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['title' => __('messages.about_title'), 'subtitle' => __('messages.about_story')])
<section class="max-w-5xl mx-auto px-4 py-10">
    <div class="grid md:grid-cols-3 gap-4">
        <div class="fo-card p-6"><h3 class="font-semibold text-lg">{{ __('messages.mission') }}</h3><p class="mt-2 text-sm text-charcoal/70">{{ __('messages.about_mission') }}</p></div>
        <div class="fo-card p-6"><h3 class="font-semibold text-lg">{{ __('messages.vision') }}</h3><p class="mt-2 text-sm text-charcoal/70">{{ __('messages.about_vision') }}</p></div>
        <div class="fo-card p-6"><h3 class="font-semibold text-lg">{{ __('messages.values') }}</h3><p class="mt-2 text-sm text-charcoal/70">{{ __('messages.about_values') }}</p></div>
    </div>
</section>
@endsection
