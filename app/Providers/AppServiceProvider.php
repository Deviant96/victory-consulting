<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\BusinessSolution;

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
        View::composer('frontend.partials.navigation', function ($view) {
            $view->with('navServices', Service::where('published', true)->get());
            $view->with('navIndustries', BusinessSolution::active()->ordered()->get());
        });

        View::composer('frontend.partials.footer', function ($view) {
            $view->with('footerServices', Service::published()->orderBy('title')->take(4)->get());
        });

        View::composer('admin.partials.header', function ($view) {
            $user = Auth::user();

            $notifications = collect();
            $unreadCount = 0;

            if ($user) {
                $notifications = $user->notifications()->latest()->take(8)->get();
                $unreadCount = $user->unreadNotifications()->count();
            }

            $view->with([
                'adminNotifications' => $notifications,
                'adminUnreadNotificationsCount' => $unreadCount,
            ]);
        });
    }
}
