<?php

namespace App\Services;

use App\Models\WebsiteSetting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class WebsiteSettings
{
    public const CACHE_KEY = 'website_settings.all';

    public function all(): array
    {
        if (!Schema::hasTable('website_settings')) {
            return [];
        }

        return Cache::rememberForever(self::CACHE_KEY, function () {
            return WebsiteSetting::query()->pluck('value', 'key')->all();
        });
    }

    public function get(string $key, $default = null)
    {
        return Arr::get($this->all(), $key, $default);
    }

    public function setMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            WebsiteSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget(self::CACHE_KEY);
    }
}
