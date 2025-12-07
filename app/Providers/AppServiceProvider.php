<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

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
            
            // Set Livewire asset URL to work with subdirectory
            Livewire::setUpdateRoute(function ($handle) {
                return Route::post('/victory-consulting/livewire/update', $handle);
            });
            
            Livewire::setScriptRoute(function ($handle) {
                return Route::get('/victory-consulting/livewire/livewire.js', $handle);
            });
        }
    }
}
