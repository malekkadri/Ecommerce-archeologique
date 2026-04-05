<?php

namespace App\Providers;

use App\Models\Content;
use App\Models\Course;
use App\Models\Product;
use App\Models\Workshop;
use App\Policies\ContentPolicy;
use App\Policies\CoursePolicy;
use App\Policies\ProductPolicy;
use App\Policies\WorkshopPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Content::class => ContentPolicy::class,
        Product::class => ProductPolicy::class,
        Course::class => CoursePolicy::class,
        Workshop::class => WorkshopPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-area', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('vendor-area', function ($user) {
            return $user->isVendor();
        });
    }
}
