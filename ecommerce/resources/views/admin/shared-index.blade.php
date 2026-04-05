@extends('layouts.app')
@section('content')<section class="max-w-6xl mx-auto px-4 py-10"><h1 class="text-2xl font-semibold">{{ $title }}</h1><div class="mt-4 space-y-2">@foreach($items as $item)<div class="bg-white p-4 rounded">#{{ $item->id }}</div>@endforeach</div></section>@endsection
