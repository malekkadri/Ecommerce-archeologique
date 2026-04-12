@php
    $kicker = $kicker ?? null;
    $title = $title ?? '';
    $subtitle = $subtitle ?? null;
    $actions = $actions ?? null;
    $meta = $meta ?? [];
    $soft = $soft ?? false;
    $variant = $variant ?? 'default';
    $id = $id ?? null;

    $variantClasses = [
        'default' => 'fo-header-default',
        'editorial' => 'fo-header-editorial',
        'education' => 'fo-header-education',
        'commerce' => 'fo-header-commerce',
        'dashboard' => 'fo-header-dashboard',
    ];
@endphp

<section @if($id) id="{{ $id }}" @endif class="max-w-7xl mx-auto px-4 pt-8 md:pt-12">
    <div class="fo-panel p-6 md:p-8 relative overflow-hidden {{ $soft ? 'bg-white/85' : '' }} {{ $variantClasses[$variant] ?? $variantClasses['default'] }}">
        <div class="absolute -top-14 -right-16 h-44 w-44 rounded-full bg-terracotta/10 blur-2xl"></div>
        <div class="absolute -bottom-20 -left-14 h-44 w-44 rounded-full bg-olive/10 blur-2xl"></div>
        <div class="relative flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div class="max-w-3xl">
                @if($kicker)
                    <p class="fo-kicker">{{ $kicker }}</p>
                @endif
                <h1 class="fo-page-title mt-2">{{ $title }}</h1>
                @if($subtitle)
                    <p class="fo-page-subtitle mt-3">{{ $subtitle }}</p>
                @endif
                @if(!empty($meta))
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($meta as $item)
                            <span class="fo-chip fo-chip-status">{{ $item }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
            @if($actions)
                <div class="flex flex-wrap items-center gap-3" data-cta-group="header-primary">{!! $actions !!}</div>
            @endif
        </div>
    </div>
</section>
