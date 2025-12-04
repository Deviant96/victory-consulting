<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('admin.partials.header', function ($view) {
            $user = Auth::user();

            $notifications = collect();
            $unreadCount = 0;

            if ($user) {
                $notifications = $user->notifications()
                    ->latest()
                    ->limit(8)
                    ->get();

                $unreadCount = $user->unreadNotifications()->count();
            }

            $view->with([
                'adminNotifications' => $notifications,
                'adminUnreadNotificationsCount' => $unreadCount,
            ]);
        });
    }
}
