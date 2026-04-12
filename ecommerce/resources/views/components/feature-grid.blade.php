<section class="max-w-7xl mx-auto px-4 fo-section">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-2xl md:text-[1.7rem] font-semibold tracking-tight">{{ $title }}</h2>
    </div>
    <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-5">
        @forelse($items as $item)
            <a href="{{ route($route, $item->slug) }}" class="fo-card fo-card-hover p-5 flex flex-col gap-3 h-full">
                <div class="h-24 rounded-xl bg-sand/35 border border-sand/70 flex items-center justify-center text-charcoal/45 text-xs uppercase tracking-wide">MIDA Selection</div>
                <h3 class="font-semibold leading-snug">{{ data_get($item, $field) }}</h3>
                @if(isset($item->summary) && $item->summary)
                    <p class="text-sm text-charcoal/70">{{ \Illuminate\Support\Str::limit($item->summary, 90) }}</p>
                @endif
                <span class="text-sm text-deepred font-semibold mt-auto">{{ __('messages.view') }} →</span>
            </a>
        @empty
            <div class="col-span-full">
                @include('components.front.empty-state', ['subtitle' => __('messages.quick_access_desc')])
            </div>
        @endforelse
    </div>
</section>
