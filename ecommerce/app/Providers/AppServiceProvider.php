<?php

namespace App\Providers;

use App\Models\CartItem;
use App\Services\WebsiteSettings;
use Illuminate\Support\Facades\Auth;
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

        View::composer('*', function ($view) {
            $cartQuantity = 0;

            if (Auth::check()) {
                $cartQuantity = (int) CartItem::query()
                    ->where('user_id', Auth::id())
                    ->sum('quantity');
            }

            $view->with('cartQuantity', $cartQuantity);
        });
    }
}
