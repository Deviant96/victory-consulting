<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function set(string $locale): RedirectResponse
    {
        $activeLocales = Language::where('is_active', true)->pluck('code')->all();
        $fallback = config('app.fallback_locale', 'en');

        if (!in_array($locale, $activeLocales, true)) {
            $locale = $fallback;
        }

        Session::put('locale', $locale);

        return redirect()->back();
    }
}
