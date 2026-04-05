@extends('layouts.app')
@section('content')
<section class="max-w-6xl mx-auto px-4 py-12"><h1 class="text-3xl font-semibold">{{ __('messages.user_dashboard') }}</h1><div class="grid md:grid-cols-3 gap-4 mt-6"><div class="bg-white rounded-2xl p-5">{{ __('messages.orders') }}: {{ $ordersCount }}</div><div class="bg-white rounded-2xl p-5">{{ __('messages.bookings') }}: {{ $bookingsCount }}</div><div class="bg-white rounded-2xl p-5">{{ __('messages.courses') }}: {{ $coursesCount }}</div></div></section>
@endsection
