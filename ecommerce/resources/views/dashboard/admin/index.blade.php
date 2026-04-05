@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-12 space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-3xl font-semibold">{{ __('messages.admin_dashboard') }}</h1>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-lg bg-white border">{{ __('messages.products') }}</a>
            <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-lg bg-white border">{{ __('messages.users') }}</a>
            <a href="{{ route('admin.contents.index') }}" class="px-3 py-2 rounded-lg bg-white border">{{ __('messages.contents') }}</a>
            <a href="{{ route('admin.workshops.index') }}" class="px-3 py-2 rounded-lg bg-white border">{{ __('messages.workshops') }}</a>
            <a href="{{ route('admin.contact-inquiries.index') }}" class="px-3 py-2 rounded-lg bg-white border">{{ __('messages.inquiries') }}</a>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4"><p class="text-xs text-charcoal/70">{{ __('messages.users') }}</p><p class="text-2xl font-semibold mt-1">{{ $usersCount }}</p></div>
        <div class="bg-white rounded-2xl p-4"><p class="text-xs text-charcoal/70">{{ __('messages.vendors') }}</p><p class="text-2xl font-semibold mt-1">{{ $vendorsCount }}</p></div>
        <div class="bg-white rounded-2xl p-4"><p class="text-xs text-charcoal/70">{{ __('messages.products') }}</p><p class="text-2xl font-semibold mt-1">{{ $productsCount }}</p></div>
        <div class="bg-white rounded-2xl p-4"><p class="text-xs text-charcoal/70">{{ __('messages.orders') }}</p><p class="text-2xl font-semibold mt-1">{{ $ordersCount }}</p></div>
        <div class="bg-white rounded-2xl p-4"><p class="text-xs text-charcoal/70">{{ __('messages.courses') }}</p><p class="text-2xl font-semibold mt-1">{{ $coursesCount }}</p></div>
        <div class="bg-white rounded-2xl p-4"><p class="text-xs text-charcoal/70">{{ __('messages.workshops') }}</p><p class="text-2xl font-semibold mt-1">{{ $workshopsCount }}</p></div>
        <div class="bg-white rounded-2xl p-4"><p class="text-xs text-charcoal/70">{{ __('messages.contents') }}</p><p class="text-2xl font-semibold mt-1">{{ $contentCount }}</p></div>
        <div class="bg-white rounded-2xl p-4"><p class="text-xs text-charcoal/70">{{ __('messages.inquiries') }}</p><p class="text-2xl font-semibold mt-1">{{ $inquiriesCount }}</p></div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-5">
            <h2 class="font-semibold mb-3">{{ __('messages.recent_orders') }}</h2>
            <div class="space-y-2 text-sm">
                @forelse($recentOrders as $order)
                    <div class="flex justify-between border-b border-sand/70 pb-2">
                        <span>{{ $order->reference }} · {{ optional($order->user)->name }}</span>
                        <span>{{ number_format($order->total, 2) }} {{ $order->currency }}</span>
                    </div>
                @empty
                    <p class="text-charcoal/70">{{ __('messages.empty_state') }}</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5">
            <h2 class="font-semibold mb-3">{{ __('messages.recent_inquiries') }}</h2>
            <div class="space-y-2 text-sm">
                @forelse($recentInquiries as $inquiry)
                    <div class="border-b border-sand/70 pb-2">
                        <p class="font-medium">{{ $inquiry->subject }}</p>
                        <p class="text-charcoal/70">{{ $inquiry->name }} · {{ $inquiry->status }}</p>
                    </div>
                @empty
                    <p class="text-charcoal/70">{{ __('messages.empty_state') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-5">
            <h2 class="font-semibold mb-3">{{ __('messages.low_stock_products') }}</h2>
            <div class="space-y-2 text-sm">
                @forelse($lowStockProducts as $product)
                    <div class="flex justify-between border-b border-sand/70 pb-2">
                        <span>{{ $product->name }}</span>
                        <span class="text-deepred font-semibold">{{ $product->stock }}</span>
                    </div>
                @empty
                    <p class="text-charcoal/70">{{ __('messages.empty_state') }}</p>
                @endforelse
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5">
            <h2 class="font-semibold mb-3">{{ __('messages.upcoming_workshops') }}</h2>
            <div class="space-y-2 text-sm">
                @forelse($upcomingWorkshops as $workshop)
                    <div class="flex justify-between border-b border-sand/70 pb-2">
                        <span>{{ $workshop->title }}</span>
                        <span>{{ $workshop->starts_at->format('Y-m-d') }}</span>
                    </div>
                @empty
                    <p class="text-charcoal/70">{{ __('messages.empty_state') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
