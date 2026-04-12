@extends('layouts.app')

@section('content')
@include('components.front.page-header', [
    'kicker' => __('messages.brand_signature'),
    'title' => __('messages.home_hero_title'),
    'subtitle' => __('messages.home_hero_subtitle'),
    'meta' => ['Curated learning', 'Hands-on workshops', 'Marketplace essentials'],
    'actions' => '<a href="'.route('courses.index').'" class="fo-btn fo-btn-primary">'.__('messages.nav_courses').'</a><a href="'.route('marketplace.index').'" class="fo-btn fo-btn-secondary">'.__('messages.nav_marketplace').'</a>',
])

<section class="max-w-7xl mx-auto px-4 fo-section">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['contents.index','nav_content'],['courses.index','nav_courses'],['workshops.index','nav_workshops'],['marketplace.index','nav_marketplace']] as $item)
            <a href="{{ route($item[0]) }}" class="fo-card fo-card-hover p-6 flex flex-col gap-3">
                <span class="fo-chip w-fit">Explore</span>
                <h3 class="font-semibold text-lg">{{ __('messages.' . $item[1]) }}</h3>
                <p class="text-sm text-charcoal/70">{{ __('messages.quick_access_desc') }}</p>
                <span class="text-sm text-deepred font-semibold mt-auto">{{ __('messages.view_all') }} →</span>
            </a>
        @endforeach
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
