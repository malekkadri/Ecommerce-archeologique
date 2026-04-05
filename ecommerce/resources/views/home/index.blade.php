@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto px-4 pt-12 pb-16">
    <div class="bg-gradient-to-r from-sand to-white rounded-3xl p-10 shadow-sm">
        <p class="uppercase text-xs tracking-[0.2em] text-terracotta">{{ __('messages.brand_signature') }}</p>
        <h1 class="text-4xl md:text-5xl font-semibold mt-3 leading-tight">{{ __('messages.home_hero_title') }}</h1>
        <p class="mt-4 text-lg text-gray-700 max-w-3xl">{{ __('messages.home_hero_subtitle') }}</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 grid md:grid-cols-4 gap-4">
    @foreach ([['contents.index','nav_content'],['courses.index','nav_courses'],['workshops.index','nav_workshops'],['marketplace.index','nav_marketplace']] as $item)
        <a href="{{ route($item[0]) }}" class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
            <h3 class="font-semibold text-lg">{{ __('messages.' . $item[1]) }}</h3>
            <p class="text-sm text-gray-600 mt-2">{{ __('messages.quick_access_desc') }}</p>
        </a>
    @endforeach
</section>

@include('components.feature-grid', ['title' => __('messages.featured_content'), 'items' => $featuredContents, 'route' => 'contents.show', 'field' => 'title'])
@include('components.feature-grid', ['title' => __('messages.featured_courses'), 'items' => $featuredCourses, 'route' => 'courses.show', 'field' => 'title'])
@include('components.feature-grid', ['title' => __('messages.upcoming_workshops'), 'items' => $upcomingWorkshops, 'route' => 'workshops.show', 'field' => 'title'])
@include('components.feature-grid', ['title' => __('messages.highlighted_products'), 'items' => $featuredProducts, 'route' => 'marketplace.show', 'field' => 'name'])
@endsection
