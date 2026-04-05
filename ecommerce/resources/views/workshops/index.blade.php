@extends('layouts.app')
@section('content')
<section class="max-w-7xl mx-auto px-4 py-12"><h1 class="text-3xl font-semibold mb-6">{{ __('messages.nav_workshops') }}</h1><div class="grid md:grid-cols-3 gap-4">@foreach($workshops as $workshop)<a href="{{ route('workshops.show',$workshop->slug) }}" class="bg-white p-5 rounded-2xl"><h3 class="font-semibold">{{ $workshop->title }}</h3><p class="text-sm mt-2">{{ $workshop->location }} - {{ $workshop->starts_at }}</p></a>@endforeach</div><div class="mt-6">{{ $workshops->links() }}</div></section>
@endsection
