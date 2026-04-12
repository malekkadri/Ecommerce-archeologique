@php
    $title = $title ?? __('messages.empty_state');
    $subtitle = $subtitle ?? null;
    $action = $action ?? null;
    $size = $size ?? 'default';

    $sizeClass = $size === 'compact' ? 'p-5 md:p-6' : 'p-8 md:p-10';
@endphp

<div class="fo-empty {{ $sizeClass }} text-center" data-module="empty-state">
    <div class="mx-auto h-12 w-12 rounded-full bg-sand/80 border border-sand flex items-center justify-center text-deepred text-xl">✦</div>
    <h3 class="mt-4 text-lg font-semibold">{{ $title }}</h3>
    <p class="mt-1 text-xs uppercase tracking-[0.18em] text-charcoal/55">Guided next step</p>
    @if($subtitle)
        <p class="mt-2 text-sm text-charcoal/70 max-w-md mx-auto">{{ $subtitle }}</p>
    @endif
    @if($action)
        <div class="mt-5" data-cta-group="empty-state-action">{!! $action !!}</div>
    @endif
</div>
