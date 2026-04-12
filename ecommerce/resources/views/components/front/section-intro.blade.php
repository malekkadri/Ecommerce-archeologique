@php
    $kicker = $kicker ?? null;
    $title = $title ?? null;
    $subtitle = $subtitle ?? null;
    $action = $action ?? null;
    $variant = $variant ?? 'default';

    $variantClass = match ($variant) {
        'editorial' => 'fo-intro-editorial',
        'education' => 'fo-intro-education',
        'commerce' => 'fo-intro-commerce',
        'dashboard' => 'fo-intro-dashboard',
        default => '',
    };
@endphp

<div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between mb-5 {{ $variantClass }}">
    <div class="max-w-2xl">
        @if($kicker)
            <p class="fo-kicker">{{ $kicker }}</p>
        @endif
        @if($title)
            <h2 class="text-2xl md:text-[1.7rem] font-semibold tracking-tight mt-1">{{ $title }}</h2>
        @endif
        @if($subtitle)
            <p class="text-sm md:text-base text-charcoal/75 mt-2 leading-relaxed">{{ $subtitle }}</p>
        @endif
    </div>
    @if($action)
        <div data-cta-group="section-intro-action">{!! $action !!}</div>
    @endif
</div>
