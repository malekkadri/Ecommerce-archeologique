@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['variant' => 'editorial', 'kicker' => __('messages.nav_about'), 'title' => __('messages.about_title'), 'subtitle' => __('messages.about_story'), 'meta' => [__('messages.mission'), __('messages.vision'), __('messages.values')]])
<section class="max-w-5xl mx-auto px-4 py-10 space-y-6" data-page="about">
    <div class="fo-callout">
        <p class="font-semibold">{{ __('messages.what_we_believe') }}</p>
        <p class="mt-2 text-charcoal/80 leading-relaxed">{{ __('messages.about_belief_text') }}</p>
    </div>
    <div class="grid md:grid-cols-3 gap-5">
        <article class="fo-card p-6"><h3 class="font-semibold text-lg">{{ __('messages.mission') }}</h3><p class="mt-2 text-sm text-charcoal/70 leading-relaxed">{{ __('messages.about_mission') }}</p></article>
        <article class="fo-card p-6"><h3 class="font-semibold text-lg">{{ __('messages.vision') }}</h3><p class="mt-2 text-sm text-charcoal/70 leading-relaxed">{{ __('messages.about_vision') }}</p></article>
        <article class="fo-card p-6"><h3 class="font-semibold text-lg">{{ __('messages.values') }}</h3><p class="mt-2 text-sm text-charcoal/70 leading-relaxed">{{ __('messages.about_values') }}</p></article>
    </div>
</section>
@endsection
