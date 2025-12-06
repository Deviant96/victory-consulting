<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $fallback = config('app.fallback_locale', 'en');
        $sessionLocale = Session::get('locale');
        $activeLocales = Language::where('is_active', true)->pluck('code')->all();

        $locale = $sessionLocale ?: $fallback;

        if (!in_array($locale, $activeLocales, true)) {
            $locale = $fallback;
        }

        App::setLocale($locale);

        return $next($request);
    }
}
