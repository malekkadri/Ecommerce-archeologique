<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WebsiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingController extends Controller
{
    public function edit(WebsiteSettings $settings)
    {
        return view('admin.settings.edit', [
            'settings' => $settings->all(),
        ]);
    }

    public function update(Request $request, WebsiteSettings $settings)
    {
        $data = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'seo_default_title' => ['nullable', 'string', 'max:255'],
            'seo_default_description' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'contact_address' => ['nullable', 'string', 'max:255'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
            'footer_text' => ['nullable', 'string', 'max:255'],
            'home_hero_title' => ['nullable', 'string', 'max:255'],
            'home_hero_subtitle' => ['nullable', 'string', 'max:255'],
            'home_primary_cta_label' => ['nullable', 'string', 'max:80'],
            'home_primary_cta_link' => ['nullable', 'string', 'max:255'],
            'home_secondary_cta_label' => ['nullable', 'string', 'max:80'],
            'home_secondary_cta_link' => ['nullable', 'string', 'max:255'],
            'marketplace_intro' => ['nullable', 'string', 'max:255'],
            'courses_intro' => ['nullable', 'string', 'max:255'],
            'workshops_intro' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'favicon' => ['nullable', 'image', 'mimes:ico,png,jpg,jpeg,svg,webp', 'max:2048'],
            'remove_logo' => ['nullable', 'boolean'],
            'remove_favicon' => ['nullable', 'boolean'],
        ]);

        $current = $settings->all();

        if ($request->boolean('remove_logo') && !empty($current['logo_path'])) {
            Storage::disk('public')->delete($current['logo_path']);
            $data['logo_path'] = null;
        }

        if ($request->boolean('remove_favicon') && !empty($current['favicon_path'])) {
            Storage::disk('public')->delete($current['favicon_path']);
            $data['favicon_path'] = null;
        }

        if ($request->hasFile('logo')) {
            if (!empty($current['logo_path'])) {
                Storage::disk('public')->delete($current['logo_path']);
            }
            $data['logo_path'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if (!empty($current['favicon_path'])) {
                Storage::disk('public')->delete($current['favicon_path']);
            }
            $data['favicon_path'] = $request->file('favicon')->store('settings', 'public');
        }

        unset($data['logo'], $data['favicon'], $data['remove_logo'], $data['remove_favicon']);

        $settings->setMany($data);

        return back()->with('success', __('messages.updated'));
    }
}
