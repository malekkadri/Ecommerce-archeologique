@extends('layouts.admin')

@section('admin_title', 'Website Settings')
@section('content')
<section class="space-y-6">
    <div>
        <p class="admin-kicker">Configuration</p>
        <h1 class="admin-title">Website settings</h1>
        <p class="admin-subtitle">Manage branding, SEO defaults, contact channels, and homepage global copy from one central place.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="admin-card p-6 grid lg:grid-cols-2 gap-5">
        @csrf
        @method('PUT')

        <div class="lg:col-span-2">
            <h2 class="font-semibold text-lg">General</h2>
        </div>
        <div><label class="admin-label">Site name</label><input name="site_name" value="{{ old('site_name', $settings['site_name'] ?? config('app.name')) }}" class="admin-input"></div>
        <div><label class="admin-label">Tagline</label><input name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" class="admin-input"></div>

        <div class="lg:col-span-2 mt-2"><h2 class="font-semibold text-lg">Branding</h2></div>
        <div>
            <label class="admin-label">Logo</label>
            <input type="file" name="logo" accept="image/*" class="admin-input">
            @if(!empty($settings['logo_path']))
                <img src="{{ Storage::url($settings['logo_path']) }}" alt="Logo" class="mt-3 h-14 w-auto rounded border border-slate-200 bg-white p-1">
                <label class="mt-2 inline-flex items-center gap-2 text-sm"><input type="checkbox" name="remove_logo" value="1"> Remove logo</label>
            @endif
        </div>
        <div>
            <label class="admin-label">Favicon</label>
            <input type="file" name="favicon" accept="image/*,.ico" class="admin-input">
            @if(!empty($settings['favicon_path']))
                <img src="{{ Storage::url($settings['favicon_path']) }}" alt="Favicon" class="mt-3 h-10 w-10 rounded border border-slate-200 bg-white p-1">
                <label class="mt-2 inline-flex items-center gap-2 text-sm"><input type="checkbox" name="remove_favicon" value="1"> Remove favicon</label>
            @endif
        </div>

        <div class="lg:col-span-2 mt-2"><h2 class="font-semibold text-lg">SEO</h2></div>
        <div><label class="admin-label">Default SEO title</label><input name="seo_default_title" value="{{ old('seo_default_title', $settings['seo_default_title'] ?? '') }}" class="admin-input"></div>
        <div><label class="admin-label">Default SEO description</label><input name="seo_default_description" value="{{ old('seo_default_description', $settings['seo_default_description'] ?? '') }}" class="admin-input"></div>

        <div class="lg:col-span-2 mt-2"><h2 class="font-semibold text-lg">Contact</h2></div>
        <div><label class="admin-label">Contact email</label><input name="contact_email" type="email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" class="admin-input"></div>
        <div><label class="admin-label">Contact phone</label><input name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" class="admin-input"></div>
        <div class="lg:col-span-2"><label class="admin-label">Address</label><input name="contact_address" value="{{ old('contact_address', $settings['contact_address'] ?? '') }}" class="admin-input"></div>

        <div class="lg:col-span-2 mt-2"><h2 class="font-semibold text-lg">Social</h2></div>
        <div><label class="admin-label">Facebook URL</label><input name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}" class="admin-input"></div>
        <div><label class="admin-label">Instagram URL</label><input name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" class="admin-input"></div>
        <div><label class="admin-label">Youtube URL</label><input name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" class="admin-input"></div>

        <div class="lg:col-span-2 mt-2"><h2 class="font-semibold text-lg">Homepage</h2></div>
        <div><label class="admin-label">Hero title</label><input name="home_hero_title" value="{{ old('home_hero_title', $settings['home_hero_title'] ?? '') }}" class="admin-input"></div>
        <div><label class="admin-label">Hero subtitle</label><input name="home_hero_subtitle" value="{{ old('home_hero_subtitle', $settings['home_hero_subtitle'] ?? '') }}" class="admin-input"></div>
        <div><label class="admin-label">Primary CTA label</label><input name="home_primary_cta_label" value="{{ old('home_primary_cta_label', $settings['home_primary_cta_label'] ?? '') }}" class="admin-input"></div>
        <div><label class="admin-label">Primary CTA link</label><input name="home_primary_cta_link" value="{{ old('home_primary_cta_link', $settings['home_primary_cta_link'] ?? route('courses.index')) }}" class="admin-input"></div>
        <div><label class="admin-label">Secondary CTA label</label><input name="home_secondary_cta_label" value="{{ old('home_secondary_cta_label', $settings['home_secondary_cta_label'] ?? '') }}" class="admin-input"></div>
        <div><label class="admin-label">Secondary CTA link</label><input name="home_secondary_cta_link" value="{{ old('home_secondary_cta_link', $settings['home_secondary_cta_link'] ?? route('workshops.index')) }}" class="admin-input"></div>
        <div><label class="admin-label">Marketplace intro</label><input name="marketplace_intro" value="{{ old('marketplace_intro', $settings['marketplace_intro'] ?? '') }}" class="admin-input"></div>
        <div><label class="admin-label">Courses intro</label><input name="courses_intro" value="{{ old('courses_intro', $settings['courses_intro'] ?? '') }}" class="admin-input"></div>
        <div><label class="admin-label">Workshops intro</label><input name="workshops_intro" value="{{ old('workshops_intro', $settings['workshops_intro'] ?? '') }}" class="admin-input"></div>

        <div class="lg:col-span-2 mt-2"><h2 class="font-semibold text-lg">Footer</h2></div>
        <div class="lg:col-span-2"><label class="admin-label">Footer text</label><input name="footer_text" value="{{ old('footer_text', $settings['footer_text'] ?? '') }}" class="admin-input"></div>

        <div class="lg:col-span-2 flex gap-3 pt-2">
            <button class="admin-btn admin-btn-primary">Save settings</button>
        </div>
    </form>
</section>
@endsection
