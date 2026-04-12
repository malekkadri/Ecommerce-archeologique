@extends('layouts.app')

@section('content')
@include('components.front.page-header', [
    'id' => 'home-hero',
    'kicker' => __('messages.brand_signature'),
    'title' => __('messages.home_hero_title'),
    'subtitle' => __('messages.home_hero_subtitle') . ' From first inspiration to confident action, each pathway is intentionally connected.',
    'variant' => 'default',
    'meta' => ['Editorial guidance', 'Expert-led learning paths', 'Live coached workshops', 'Curated marketplace'],
    'actions' => '<a href="'.route('courses.index').'" class="fo-btn fo-btn-primary" data-cta="home-primary-courses">'.__('messages.nav_courses').'</a><a href="'.route('workshops.index').'" class="fo-btn fo-btn-secondary" data-cta="home-secondary-workshops">'.__('messages.nav_workshops').'</a><a href="'.route('marketplace.index').'" class="fo-btn fo-btn-ghost" data-cta="home-tertiary-marketplace">'.__('messages.nav_marketplace').'</a>',
])

@include('components.front.proof-strip', [
    'variant' => 'editorial',
    'items' => [
        ['value' => $featuredContents->count().'+' , 'label' => 'Fresh editorial features'],
        ['value' => $featuredCourses->count().'+' , 'label' => 'Outcome-led courses'],
        ['value' => $upcomingWorkshops->count().'+' , 'label' => 'Live workshops open'],
        ['value' => $featuredProducts->count().'+' , 'label' => 'Ready-to-use essentials'],
    ],
])

<section id="home-pathways" class="max-w-7xl mx-auto px-4 fo-section">
    @include('components.front.section-intro', [
        'kicker' => 'Pathways',
        'title' => 'Move through the MIDA ecosystem with purpose.',
        'subtitle' => 'Each vertical has a distinct role: context, skill-building, guided practice, and trusted equipment.',
    ])

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([
            ['contents.index','nav_content','Read editorial analysis and field stories before making your next decision.','Read stories', 'editorial'],
            ['courses.index','nav_courses','Progress through focused lessons with clear milestones and outcomes.','Start a path', 'education'],
            ['workshops.index','nav_workshops','Book hands-on sessions for direct coaching and implementation feedback.','Reserve a seat', 'education'],
            ['marketplace.index','nav_marketplace','Choose vetted ingredients and tools aligned with what you are learning.','Shop essentials', 'commerce']
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
            <p class="fo-kicker">Launch confidence</p>
            <h2 class="text-2xl font-semibold mt-1">One authored journey, not disconnected pages.</h2>
            <p class="text-charcoal/75 mt-3 leading-relaxed">MIDA was structured as a narrative product: editorial context informs your choices, courses build capability, workshops create accountability, and commerce supports execution at home.</p>
            <div class="mt-4 flex flex-wrap gap-2 text-xs text-charcoal/70">
                <span class="fo-chip">Clear next-step CTAs</span>
                <span class="fo-chip">Cross-vertical continuity</span>
                <span class="fo-chip">Dashboard follow-through</span>
            </div>
        </div>
        @include('components.front.reassurance-list', [
            'title' => 'Designed for conversion and trust',
            'tone' => 'calm',
            'items' => [
                'Every major page includes a clear primary action and supporting step.',
                'Language is specific to page intent instead of repeated generic filler.',
                'High-intent modules are marked for future CRO instrumentation.',
            ],
        ])
    </div>
</section>

<section class="fo-section fo-section-soft py-10 mt-12" id="home-editorial-curated">
    @include('components.feature-grid', ['kicker' => 'Editorial', 'title' => __('messages.featured_content'), 'items' => $featuredContents, 'route' => 'contents.show', 'field' => 'title', 'variant' => 'editorial'])
</section>
@include('components.feature-grid', ['kicker' => 'Education', 'title' => __('messages.featured_courses'), 'items' => $featuredCourses, 'route' => 'courses.show', 'field' => 'title', 'variant' => 'education'])
<section class="fo-section fo-section-soft py-10 mt-12" id="home-workshop-curated">
    @include('components.feature-grid', ['kicker' => 'Live practice', 'title' => __('messages.upcoming_workshops'), 'items' => $upcomingWorkshops, 'route' => 'workshops.show', 'field' => 'title', 'variant' => 'education'])
</section>
@include('components.feature-grid', ['kicker' => 'Marketplace', 'title' => __('messages.highlighted_products'), 'items' => $featuredProducts, 'route' => 'marketplace.show', 'field' => 'name', 'variant' => 'commerce'])
@endsection
