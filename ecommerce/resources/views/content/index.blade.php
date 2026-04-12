@extends('layouts.app')
@section('content')
@include('components.front.page-header', ['title' => __('messages.nav_content'), 'subtitle' => __('messages.quick_access_desc')])
<section class="max-w-7xl mx-auto px-4 py-8">
<form class="fo-panel p-4 grid md:grid-cols-4 gap-3 mb-6">
    <input name="q" value="{{ request('q') }}" class="fo-input" placeholder="{{ __('messages.search') }}">
    <select name="type" class="fo-select"><option value="">{{ __('messages.all_types') }}</option>@foreach(['recipe','article','tradition','ingredient','nutrition'] as $t)<option value="{{ $t }}" @selected(request('type')===$t)>{{ ucfirst($t) }}</option>@endforeach</select>
    <button class="fo-btn fo-btn-primary">{{ __('messages.filter') }}</button>
</form>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">@foreach($contents as $content)<a href="{{ route('contents.show',$content->slug) }}" class="fo-card fo-card-hover p-5"><h3 class="font-semibold">{{ $content->title }}</h3><p class="text-sm mt-2 text-charcoal/70">{{ $content->excerpt }}</p></a>@endforeach</div>
<div class="mt-6">{{ $contents->links() }}</div>
</section>
@endsection
