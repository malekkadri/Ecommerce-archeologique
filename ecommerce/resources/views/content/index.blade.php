@extends('layouts.app')
@section('content')
<section class="max-w-7xl mx-auto px-4 py-12">
<h1 class="text-3xl font-semibold mb-6">{{ __('messages.nav_content') }}</h1>
<form class="grid md:grid-cols-4 gap-3 mb-6">
<input name="q" value="{{ request('q') }}" class="rounded-xl border px-3 py-2" placeholder="{{ __('messages.search') }}">
<select name="type" class="rounded-xl border px-3 py-2"><option value="">{{ __('messages.all_types') }}</option>@foreach(['recipe','article','tradition','ingredient','nutrition'] as $t)<option value="{{ $t }}" @selected(request('type')===$t)>{{ ucfirst($t) }}</option>@endforeach</select>
<button class="bg-terracotta text-white rounded-xl px-4 py-2">{{ __('messages.filter') }}</button>
</form>
<div class="grid md:grid-cols-3 gap-4">@foreach($contents as $content)<a href="{{ route('contents.show',$content->slug) }}" class="bg-white p-5 rounded-2xl shadow-sm"><h3 class="font-semibold">{{ $content->title }}</h3><p class="text-sm mt-2 text-gray-600">{{ $content->excerpt }}</p></a>@endforeach</div>
<div class="mt-6">{{ $contents->links() }}</div>
</section>
@endsection
