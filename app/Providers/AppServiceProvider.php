<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure for subdirectory deployment
        if (config('app.env') === 'production') {
            URL::forceRootUrl(config('app.url'));
        }
        
        // Always force scheme to https in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
