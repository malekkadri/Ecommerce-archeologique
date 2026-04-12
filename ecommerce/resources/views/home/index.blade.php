@extends('layouts.app')

@section('content')
@include('components.front.page-header', [
    'kicker' => __('messages.brand_signature'),
    'title' => __('messages.home_hero_title'),
    'subtitle' => __('messages.home_hero_subtitle') . ' Learn, practice, and shop with one trusted ecosystem.',
    'meta' => ['Editorial guidance', 'Expert-led learning paths', 'Hands-on workshops', 'Curated marketplace'],
    'actions' => '<a href="'.route('courses.index').'" class="fo-btn fo-btn-primary">'.__('messages.nav_courses').'</a><a href="'.route('workshops.index').'" class="fo-btn fo-btn-secondary">'.__('messages.nav_workshops').'</a><a href="'.route('marketplace.index').'" class="fo-btn fo-btn-ghost">'.__('messages.nav_marketplace').'</a>',
])

@include('components.front.proof-strip', [
    'items' => [
        ['value' => $featuredContents->count().'+' , 'label' => 'Featured stories'],
        ['value' => $featuredCourses->count().'+' , 'label' => 'Practical courses'],
        ['value' => $upcomingWorkshops->count().'+' , 'label' => 'Upcoming sessions'],
        ['value' => $featuredProducts->count().'+' , 'label' => 'Curated products'],
    ],
])

<section class="max-w-7xl mx-auto px-4 fo-section">
    @include('components.front.section-intro', [
        'kicker' => 'Ecosystem',
        'title' => 'Choose the experience that fits your next step.',
        'subtitle' => 'Discover, learn, practice, and equip yourself with connected pathways designed to move from inspiration to action.',
    ])

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([
            ['contents.index','nav_content','Discover stories, guides, and traditional knowledge to deepen context before action.','Read now'],
            ['courses.index','nav_courses','Follow structured modules with practical outcomes and clear progression.','Start learning'],
            ['workshops.index','nav_workshops','Join live sessions for coached practice, feedback, and confidence.','Reserve a seat'],
            ['marketplace.index','nav_marketplace','Shop trusted tools and ingredients aligned with the learning journey.','Shop essentials']
        ] as $item)
            <a href="{{ route($item[0]) }}" class="fo-card fo-card-hover p-6 flex flex-col gap-3">
                <span class="fo-chip w-fit">{{ __('messages.' . $item[1]) }}</span>
                <h3 class="font-semibold text-lg">{{ __('messages.' . $item[1]) }}</h3>
                <p class="text-sm text-charcoal/70 leading-relaxed">{{ $item[2] }}</p>
                <span class="text-sm text-deepred font-semibold mt-auto">{{ $item[3] }} →</span>
            </a>
        @endforeach
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 fo-section">
    <div class="fo-panel p-6 md:p-7 grid lg:grid-cols-[1.2fr_.8fr] gap-5 items-start">
        <div>
            <p class="fo-kicker">Why MIDA</p>
            <h2 class="text-2xl font-semibold mt-1">A premium path from insight to real-world results.</h2>
            <p class="text-charcoal/75 mt-3 leading-relaxed">Every touchpoint is designed to reduce uncertainty: expert-informed content, clear curriculum design, guided workshops, and practical products chosen for everyday use.</p>
        </div>
        @include('components.front.reassurance-list', [
            'title' => 'Confidence, built in',
            'items' => [
                'Clear expectations before every commitment.',
                'Consistent quality framing across content and commerce.',
                'Action-focused journeys with next steps on each page.',
            ],
        ])
    </div>
</section>

<section class="fo-section fo-section-soft py-10 mt-12">
    @include('components.feature-grid', ['title' => __('messages.featured_content'), 'items' => $featuredContents, 'route' => 'contents.show', 'field' => 'title'])
</section>
@include('components.feature-grid', ['title' => __('messages.featured_courses'), 'items' => $featuredCourses, 'route' => 'courses.show', 'field' => 'title'])
<section class="fo-section fo-section-soft py-10 mt-12">
    @include('components.feature-grid', ['title' => __('messages.upcoming_workshops'), 'items' => $upcomingWorkshops, 'route' => 'workshops.show', 'field' => 'title'])
</section>
@include('components.feature-grid', ['title' => __('messages.highlighted_products'), 'items' => $featuredProducts, 'route' => 'marketplace.show', 'field' => 'name'])
@endsection
