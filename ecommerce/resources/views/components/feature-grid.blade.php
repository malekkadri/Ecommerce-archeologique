<section class="max-w-7xl mx-auto px-4 mt-14">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-2xl font-semibold">{{ $title }}</h2>
    </div>
    <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($items as $item)
            <a href="{{ route($route, $item->slug) }}" class="fo-card fo-card-hover p-5">
                <h3 class="font-semibold">{{ data_get($item, $field) }}</h3>
                @if(isset($item->summary) && $item->summary)
                    <p class="text-sm text-charcoal/70 mt-2">{{ \Illuminate\Support\Str::limit($item->summary, 90) }}</p>
                @endif
            </a>
        @empty
            <div class="col-span-full fo-card p-8 text-center text-sm text-charcoal/70">{{ __('messages.empty_state') }}</div>
        @endforelse
    </div>
</section>
