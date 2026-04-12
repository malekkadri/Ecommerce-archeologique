@php
    $items = $items ?? [];
    $variant = $variant ?? 'default';

    $variantClass = $variant === 'commerce' ? 'fo-proof-commerce' : ($variant === 'editorial' ? 'fo-proof-editorial' : '');
@endphp

@if(!empty($items))
    <section class="max-w-7xl mx-auto px-4 fo-section" data-module="proof-strip">
        <div class="fo-surface p-4 md:p-5 {{ $variantClass }}">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
                @foreach($items as $item)
                    <div class="fo-proof-item">
                        <p class="fo-proof-value">{{ $item['value'] ?? '' }}</p>
                        <p class="fo-proof-label">{{ $item['label'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
