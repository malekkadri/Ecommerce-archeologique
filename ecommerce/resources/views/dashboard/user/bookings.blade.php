@extends('layouts.app')
@section('content')<section class="max-w-5xl mx-auto px-4 py-12"><h1 class="text-2xl font-semibold">{{ __('messages.my_bookings') }}</h1><div class="mt-4 space-y-2">@foreach($bookings as $booking)<div class="bg-white p-4 rounded-xl">{{ $booking->workshop->title }} ({{ $booking->seats }})</div>@endforeach</div></section>@endsection
