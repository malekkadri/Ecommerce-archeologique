@extends('layouts.app')
@section('content')
<section class="max-w-5xl mx-auto px-4 py-16">
    <h1 class="text-4xl font-semibold">{{ __('messages.about_title') }}</h1>
    <p class="mt-5 text-lg">{{ __('messages.about_story') }}</p>
    <div class="grid md:grid-cols-3 gap-4 mt-10">
        <div class="bg-white rounded-2xl p-6"><h3 class="font-semibold">{{ __('messages.mission') }}</h3><p class="mt-2 text-sm">{{ __('messages.about_mission') }}</p></div>
        <div class="bg-white rounded-2xl p-6"><h3 class="font-semibold">{{ __('messages.vision') }}</h3><p class="mt-2 text-sm">{{ __('messages.about_vision') }}</p></div>
        <div class="bg-white rounded-2xl p-6"><h3 class="font-semibold">{{ __('messages.values') }}</h3><p class="mt-2 text-sm">{{ __('messages.about_values') }}</p></div>
    </div>
</section>
@endsection
