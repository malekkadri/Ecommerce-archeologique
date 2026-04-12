@props([
    'items' => [],
])

@if(!empty($items))
    <section class="max-w-7xl mx-auto px-4 fo-section">
        <div class="fo-surface p-4 md:p-5">
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
