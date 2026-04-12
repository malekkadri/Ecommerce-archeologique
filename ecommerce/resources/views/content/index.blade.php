@extends('layouts.app')
@section('content')
@include('components.front.page-header', [
    'variant' => 'editorial',
    'kicker' => __('messages.nav_content'),
    'title' => __('messages.nav_content'),
    'subtitle' => 'Editorial guidance, practical context, and cultural stories that help you make smarter learning and shopping choices.',
    'meta' => [__('messages.search'), __('messages.filter'), 'Expert perspective'],
])

@include('components.front.proof-strip', ['variant' => 'editorial', 'items' => [
    ['value' => $contents->total(), 'label' => 'Published pieces'],
    ['value' => strtoupper((string) request('type', 'all')), 'label' => 'Current focus'],
    ['value' => 'Read', 'label' => 'Context before commitment'],
    ['value' => 'Save', 'label' => 'Revisit in favorites'],
]])

<section class="max-w-7xl mx-auto px-4 py-8">
<form class="fo-surface p-4 md:p-5 grid md:grid-cols-4 gap-3 mb-7 items-end">
    <div class="md:col-span-2">
        <label class="text-xs uppercase tracking-wide text-charcoal/60">{{ __('messages.search') }}</label>
        <input name="q" value="{{ request('q') }}" class="fo-input mt-1" placeholder="Find topics, methods, or ingredients">
    </div>
    <div>
        <label class="text-xs uppercase tracking-wide text-charcoal/60">{{ __('messages.all_types') }}</label>
        <select name="type" class="fo-select mt-1"><option value="">{{ __('messages.all_types') }}</option>@foreach(['recipe','article','tradition','ingredient','nutrition'] as $t)<option value="{{ $t }}" @selected(request('type')===$t)>{{ ucfirst($t) }}</option>@endforeach</select>
    </div>
    <button class="fo-btn fo-btn-primary">{{ __('messages.filter') }}</button>
</form>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">@forelse($contents as $content)<a href="{{ route('contents.show',$content->slug) }}" class="fo-card fo-card-hover p-5 flex flex-col"><p class="fo-kicker">Editorial</p><h3 class="font-semibold mt-2 leading-snug">{{ $content->title }}</h3><p class="text-sm mt-3 text-charcoal/70">{{ \Illuminate\Support\Str::limit($content->excerpt, 125) }}</p><p class="text-xs text-charcoal/65 mt-2">Best for readers who want context before enrolling, booking, or purchasing.</p><span class="text-sm text-deepred font-semibold mt-auto pt-4">Read details →</span></a>@empty <div class="col-span-full">@include('components.front.empty-state', ['subtitle' => 'No editorial pieces match this filter yet. Try a broader topic or explore all content.'])</div>@endforelse</div>
<div class="mt-6">{{ $contents->links() }}</div>
</section>
@endsection
