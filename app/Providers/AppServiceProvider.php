<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force Cloudinary configuration
        \Cloudinary\Configuration\Configuration::instance(
            env('CLOUDINARY_URL')
        );

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
