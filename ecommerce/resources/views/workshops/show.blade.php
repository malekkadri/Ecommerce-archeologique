@extends('layouts.app')
@section('content')
<section class="max-w-4xl mx-auto px-4 py-12"><h1 class="text-4xl font-semibold">{{ $workshop->title }}</h1><p class="mt-3">{{ $workshop->description }}</p>@auth<form method="post" action="{{ route('workshops.book') }}" class="mt-6 flex gap-2 items-end">@csrf<input type="hidden" name="workshop_id" value="{{ $workshop->id }}"><div><label>{{ __('messages.seats') }}</label><input type="number" name="seats" min="1" max="10" value="1" class="rounded-xl border px-3 py-2"></div><button class="bg-terracotta text-white rounded-xl px-4 py-2">{{ __('messages.reserve') }}</button></form>@endauth</section>
@endsection
