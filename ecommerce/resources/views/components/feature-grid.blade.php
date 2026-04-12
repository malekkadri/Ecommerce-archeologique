@props([
    'title',
    'items',
    'route',
    'field',
    'variant' => 'default',
    'kicker' => null,
])

@php
    $contextMap = [
        'contents.show' => ['label' => 'Editorial pick', 'benefit' => 'Read and apply practical insights.', 'variant' => 'editorial'],
        'courses.show' => ['label' => 'Structured course', 'benefit' => 'Build skills lesson by lesson.', 'variant' => 'education'],
        'workshops.show' => ['label' => 'Live workshop', 'benefit' => 'Practice with guided support.', 'variant' => 'education'],
        'marketplace.show' => ['label' => 'Curated product', 'benefit' => 'Use trusted essentials at home.', 'variant' => 'commerce'],
    ];
    $context = $contextMap[$route] ?? ['label' => 'Featured', 'benefit' => 'Explore the latest selection.', 'variant' => 'default'];
    $resolvedVariant = $variant === 'default' ? $context['variant'] : $variant;
@endphp

<section class="max-w-7xl mx-auto px-4 fo-section" data-module="feature-grid" data-vertical="{{ $resolvedVariant }}">
    @include('components.front.section-intro', [
        'kicker' => $kicker ?? __('messages.brand_signature'),
        'title' => $title,
        'subtitle' => $context['benefit'],
        'variant' => $resolvedVariant,
    ])

    <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-5">
        @forelse($items as $item)
            <a href="{{ route($route, $item->slug) }}" class="fo-card fo-card-hover p-5 flex flex-col gap-3 h-full fo-card-{{ $resolvedVariant }}" data-cta="feature-item">
                <div class="h-24 rounded-xl bg-sand/35 border border-sand/70 flex items-center justify-center text-charcoal/45 text-xs uppercase tracking-wide">{{ $context['label'] }}</div>
                <h3 class="font-semibold leading-snug">{{ data_get($item, $field) }}</h3>
                @if(isset($item->summary) && $item->summary)
                    <p class="text-sm text-charcoal/70">{{ \Illuminate\Support\Str::limit($item->summary, 90) }}</p>
                @elseif(isset($item->description) && $item->description)
                    <p class="text-sm text-charcoal/70">{{ \Illuminate\Support\Str::limit($item->description, 90) }}</p>
                @endif
                <p class="text-xs text-charcoal/65">{{ $context['benefit'] }}</p>
                <span class="text-sm text-deepred font-semibold mt-auto">{{ __('messages.view') }} →</span>
            </a>
        @empty
            <div class="col-span-full">
                @include('components.front.empty-state', [
                    'title' => __('messages.empty_state'),
                    'subtitle' => __('messages.quick_access_desc'),
                ])
            </div>
        @endforelse
    </div>
</section>
