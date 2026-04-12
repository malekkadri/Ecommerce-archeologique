@props([
    'kicker' => null,
    'title',
    'subtitle' => null,
    'actions' => null,
])

<section class="max-w-7xl mx-auto px-4 pt-10 md:pt-14">
    <div class="fo-panel p-6 md:p-8">
        <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div class="max-w-3xl">
                @if($kicker)
                    <p class="fo-kicker">{{ $kicker }}</p>
                @endif
                <h1 class="fo-page-title mt-2">{{ $title }}</h1>
                @if($subtitle)
                    <p class="fo-page-subtitle mt-3">{{ $subtitle }}</p>
                @endif
            </div>
            @if($actions)
                <div class="flex flex-wrap items-center gap-3">{!! $actions !!}</div>
            @endif
        </div>
    </div>
</section>
