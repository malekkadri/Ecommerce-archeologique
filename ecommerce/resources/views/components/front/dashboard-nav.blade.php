@php
    $links = [
        ['route' => 'dashboard.index', 'label' => __('messages.user_dashboard')],
        ['route' => 'dashboard.courses', 'label' => __('messages.my_courses')],
        ['route' => 'dashboard.bookings', 'label' => __('messages.my_bookings')],
        ['route' => 'dashboard.orders', 'label' => __('messages.my_orders')],
        ['route' => 'favorites.index', 'label' => __('messages.my_favorites')],
    ];
@endphp

<div class="overflow-x-auto pb-2">
    <nav class="inline-flex min-w-full gap-2 md:gap-3">
        @foreach($links as $link)
            <a
                href="{{ route($link['route']) }}"
                class="fo-chip {{ request()->routeIs($link['route']) ? 'fo-chip-active' : '' }}"
            >
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>
</div>
