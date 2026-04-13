@extends('layouts.app')
@section('content')
@include('components.front.page-header', [
    'variant' => 'editorial',
    'kicker' => __('messages.nav_content'),
    'title' => __('messages.nav_content'),
    'subtitle' => __('messages.content_subtitle'),
    'meta' => [__('messages.search'), __('messages.filter'), __('messages.expert_perspective')],
])

<section class="max-w-7xl mx-auto px-4 py-8">
<form class="fo-surface p-4 md:p-5 grid md:grid-cols-4 gap-3 mb-7 items-end">
    <div class="md:col-span-2">
        <label class="text-xs uppercase tracking-wide text-charcoal/60">{{ __('messages.search') }}</label>
        <input name="q" value="{{ request('q') }}" class="fo-input mt-1" placeholder="{{ __('messages.content_search_placeholder') }}">
    </div>
    <div>
        <label class="text-xs uppercase tracking-wide text-charcoal/60">{{ __('messages.all_types') }}</label>
        <select name="type" class="fo-select mt-1"><option value="">{{ __('messages.all_types') }}</option>@foreach(['recipe','article','tradition','ingredient','nutrition'] as $t)<option value="{{ $t }}" @selected(request('type')===$t)>{{ ucfirst($t) }}</option>@endforeach</select>
    </div>
    <button class="fo-btn fo-btn-primary">{{ __('messages.filter') }}</button>
</form>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">@forelse($contents as $content)<a href="{{ route('contents.show',$content->slug) }}" class="fo-card fo-card-hover p-5 flex flex-col"><div class="mb-3 h-40 overflow-hidden rounded-xl bg-sand/40 border border-sand/80">@if($content->featured_image_url)<img src="{{ $content->featured_image_url }}" alt="{{ $content->title }}" class="h-full w-full object-cover">@else<div class="h-full w-full flex items-center justify-center text-xs text-charcoal/45">{{ __('messages.no_image') }}</div>@endif</div><p class="fo-kicker">{{ __('messages.editorial') }}</p><h3 class="font-semibold mt-2 leading-snug">{{ $content->title }}</h3><p class="text-sm mt-3 text-charcoal/70">{{ \Illuminate\Support\Str::limit($content->excerpt, 125) }}</p><p class="text-xs text-charcoal/65 mt-2">{{ __('messages.content_card_hint') }}</p><span class="text-sm text-deepred font-semibold mt-auto pt-4">{{ __('messages.read_details') }} →</span></a>@empty <div class="col-span-full">@include('components.front.empty-state', ['subtitle' => __('messages.content_empty_subtitle')])</div>@endforelse</div>
<div class="mt-6">{{ $contents->links() }}</div>
</section>
@endsection
