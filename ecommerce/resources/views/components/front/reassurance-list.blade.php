@php
    $title = $title ?? null;
    $items = $items ?? [];
    $tone = $tone ?? 'default';

    $toneClass = match($tone) {
        'calm' => 'border-olive/25 bg-olive/8',
        'commerce' => 'border-terracotta/25 bg-terracotta/10',
        default => '',
    };
@endphp

<div class="fo-reassurance {{ $toneClass }}" data-module="reassurance-list">
    @if($title)
        <p class="font-semibold text-sm">{{ $title }}</p>
    @endif
    <ul class="mt-3 space-y-2 text-sm text-charcoal/80">
        @foreach($items as $item)
            <li class="flex items-start gap-2"><span class="text-olive mt-0.5">✓</span><span>{{ $item }}</span></li>
        @endforeach
    </ul>
</div>
