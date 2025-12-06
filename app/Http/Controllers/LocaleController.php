<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class LocaleController extends Controller
{
    public function setLocale(string $locale): RedirectResponse
    {
        $language = null;

        if (Schema::hasTable('languages')) {
            $language = Language::where('code', $locale)->where('is_active', true)->first();
        }

        $selectedLocale = $language?->code ?? 'en';

        session(['locale' => $selectedLocale]);
        App::setLocale($selectedLocale);

        return redirect()->back();
    }
}
