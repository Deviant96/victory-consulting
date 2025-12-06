<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale');

        if (!$locale) {
            $locale = 'en';
            session(['locale' => $locale]);
        }

        if (Schema::hasTable('languages')) {
            // Ensure only active languages are applied
            $isActive = Language::where('code', $locale)->where('is_active', true)->exists();
            if (!$isActive) {
                $locale = 'en';
                session(['locale' => $locale]);
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
