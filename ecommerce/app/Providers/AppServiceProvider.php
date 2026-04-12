<?php

namespace App\Providers;

use App\Services\WebsiteSettings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WebsiteSettings::class, fn () => new WebsiteSettings());
    }

    public function boot(WebsiteSettings $settings)
    {
        View::share('websiteSettings', $settings->all());
    }
}
