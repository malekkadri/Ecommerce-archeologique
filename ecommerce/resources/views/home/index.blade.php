@extends('layouts.app')

@section('content')
@if($homeSlides->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 pt-6" x-data="homeSlider({{ $homeSlides->count() }})" x-init="start()" @mouseenter="pause()" @mouseleave="start()">
    <div class="relative overflow-hidden rounded-3xl border border-sand/70 shadow-[0_22px_45px_rgba(47,42,40,.18)] min-h-[360px] md:min-h-[460px]">
        @foreach($homeSlides as $slide)
            <article x-show="current === {{ $loop->index }}" x-transition.opacity.duration.700ms class="absolute inset-0">
                <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-charcoal/80 via-charcoal/45 to-transparent"></div>
                <div class="absolute inset-0 p-6 md:p-12 flex items-end">
                    <div class="max-w-2xl text-white space-y-3">
                        <p class="uppercase tracking-[0.18em] text-[11px] text-sand/90 font-semibold">{{ __('messages.brand_signature') }}</p>
                        <h2 class="text-2xl md:text-4xl font-semibold leading-tight">{{ $slide->title }}</h2>
                        @if(!empty($slide->subtitle))
                            <p class="text-sm md:text-lg text-white/90 leading-relaxed">{{ $slide->subtitle }}</p>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach

        <button type="button" class="absolute left-4 top-1/2 -translate-y-1/2 fo-btn fo-btn-secondary !h-10 !w-10 !rounded-full !p-0" @click="prev()" aria-label="Previous slide">‹</button>
        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 fo-btn fo-btn-secondary !h-10 !w-10 !rounded-full !p-0" @click="next()" aria-label="Next slide">›</button>
    </div>
    <div class="mt-4 flex items-center justify-center gap-2">
        @foreach($homeSlides as $slide)
            <button type="button" @click="go({{ $loop->index }})" class="h-2.5 rounded-full transition-all" :class="current === {{ $loop->index }} ? 'w-8 bg-deepred' : 'w-2.5 bg-charcoal/30'" aria-label="Go to slide {{ $loop->iteration }}"></button>
        @endforeach
    </div>
</section>

<script>
    function homeSlider(total) {
        return {
            current: 0,
            timer: null,
            start() {
                this.pause();
                this.timer = setInterval(() => this.next(), 5000);
            },
            pause() {
                if (this.timer) clearInterval(this.timer);
            },
            next() {
                this.current = (this.current + 1) % total;
            },
            prev() {
                this.current = (this.current - 1 + total) % total;
            },
            go(index) {
                this.current = index;
            },
        };
    }
</script>
@endif

@include('components.front.page-header', [
    'id' => 'home-hero',
    'kicker' => __('messages.brand_signature'),
    'title' => $websiteSettings['home_hero_title'] ?? __('messages.home_hero_title'),
    'subtitle' => ($websiteSettings['home_hero_subtitle'] ?? __('messages.home_hero_subtitle')) . ' ' . __('messages.home_hero_extension'),
    'variant' => 'default',
    'meta' => [__('messages.editorial_guidance'), __('messages.expert_learning_paths'), __('messages.live_coached_workshops'), __('messages.curated_marketplace')],
    'actions' => '<a href="'.route('courses.index').'" class="fo-btn fo-btn-primary" data-cta="home-primary-courses">'.__('messages.nav_courses').'</a><a href="'.route('workshops.index').'" class="fo-btn fo-btn-secondary" data-cta="home-secondary-workshops">'.__('messages.nav_workshops').'</a><a href="'.route('marketplace.index').'" class="fo-btn fo-btn-ghost" data-cta="home-tertiary-marketplace">'.__('messages.nav_marketplace').'</a>',
])

@include('components.front.proof-strip', [
    'variant' => 'editorial',
    'items' => [
        ['value' => $featuredContents->count().'+' , 'label' => __('messages.fresh_editorial_features')],
        ['value' => $featuredCourses->count().'+' , 'label' => __('messages.outcome_led_courses')],
        ['value' => $upcomingWorkshops->count().'+' , 'label' => __('messages.live_workshops_open')],
        ['value' => $featuredProducts->count().'+' , 'label' => __('messages.ready_to_use_essentials')],
    ],
])

<section id="home-pathways" class="max-w-7xl mx-auto px-4 fo-section">
    @include('components.front.section-intro', [
        'kicker' => __('messages.pathways'),
        'title' => __('messages.home_pathways_title'),
        'subtitle' => __('messages.home_pathways_subtitle'),
    ])

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([
            ['contents.index','nav_content',__('messages.pathway_content_description'),__('messages.read_stories'), 'editorial'],
            ['courses.index','nav_courses',__('messages.pathway_courses_description'),__('messages.start_path'), 'education'],
            ['workshops.index','nav_workshops',__('messages.pathway_workshops_description'),__('messages.reserve_seat'), 'education'],
            ['marketplace.index','nav_marketplace',__('messages.pathway_marketplace_description'),__('messages.shop_essentials'), 'commerce']
        ] as $item)
            <a href="{{ route($item[0]) }}" class="fo-card fo-card-hover p-6 flex flex-col gap-3 fo-card-{{ $item[4] }}" data-cta="home-pathway-card">
                <span class="fo-chip w-fit">{{ __('messages.' . $item[1]) }}</span>
                <h3 class="font-semibold text-lg">{{ __('messages.' . $item[1]) }}</h3>
                <p class="text-sm text-charcoal/70 leading-relaxed">{{ $item[2] }}</p>
                <span class="text-sm text-deepred font-semibold mt-auto">{{ $item[3] }} →</span>
            </a>
        @endforeach
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 fo-section" id="home-story-bridge">
    <div class="fo-panel p-6 md:p-7 grid lg:grid-cols-[1.15fr_.85fr] gap-5 items-start">
        <div>
            <p class="fo-kicker">{{ __('messages.launch_confidence') }}</p>
            <h2 class="text-2xl font-semibold mt-1">{{ __('messages.home_story_title') }}</h2>
            <p class="text-charcoal/75 mt-3 leading-relaxed">{{ __('messages.home_story_description') }}</p>
            <div class="mt-4 flex flex-wrap gap-2 text-xs text-charcoal/70">
                <span class="fo-chip">{{ __('messages.clear_next_step_cta') }}</span>
                <span class="fo-chip">{{ __('messages.cross_vertical_continuity') }}</span>
                <span class="fo-chip">{{ __('messages.dashboard_follow_through') }}</span>
            </div>
        </div>
        @include('components.front.reassurance-list', [
            'title' => __('messages.designed_for_conversion_trust'),
            'tone' => 'calm',
            'items' => [
                __('messages.home_reassurance_1'),
                __('messages.home_reassurance_2'),
                __('messages.home_reassurance_3'),
            ],
        ])
    </div>
</section>

<section class="fo-section fo-section-soft py-10 mt-12" id="home-editorial-curated">
    @include('components.feature-grid', ['kicker' => __('messages.editorial'), 'title' => __('messages.featured_content'), 'items' => $featuredContents, 'route' => 'contents.show', 'field' => 'title', 'variant' => 'editorial'])
</section>
@include('components.feature-grid', ['kicker' => __('messages.education'), 'title' => __('messages.featured_courses'), 'items' => $featuredCourses, 'route' => 'courses.show', 'field' => 'title', 'variant' => 'education'])
<section class="fo-section fo-section-soft py-10 mt-12" id="home-workshop-curated">
    @include('components.feature-grid', ['kicker' => __('messages.live_practice'), 'title' => __('messages.upcoming_workshops'), 'items' => $upcomingWorkshops, 'route' => 'workshops.show', 'field' => 'title', 'variant' => 'education'])
</section>
@include('components.feature-grid', ['kicker' => __('messages.nav_marketplace'), 'title' => __('messages.highlighted_products'), 'items' => $featuredProducts, 'route' => 'marketplace.show', 'field' => 'name', 'variant' => 'commerce'])
@endsection
