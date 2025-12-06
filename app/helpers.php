<?php

use App\Models\Setting;
use App\Models\TranslationKey;
use Illuminate\Support\Facades\App;

if (!function_exists('settings')) {
    /**
     * Get or set settings
     * 
     * @param string|null $key
     * @param mixed $default
     * @return mixed|\App\Models\Setting
     */
    function settings($key = null, $default = null)
    {
        if ($key === null) {
            return new Setting();
        }

        return Setting::get($key, $default);
    }
}

if (!function_exists('t')) {
    /**
     * Database-backed translation helper with English fallback.
     */
    function t(string $key, $default = null, ?string $locale = null)
    {
        $locale = $locale ?? session('locale', App::getLocale() ?? 'en');

        /** @var TranslationKey|null $translationKey */
        $translationKey = TranslationKey::where('key', $key)->first();

        if (!$translationKey) {
            return $default ?? $key;
        }

        $localized = $translationKey->values->firstWhere('language_code', $locale)?->value;

        if (!$localized && $locale !== 'en') {
            $localized = $translationKey->values->firstWhere('language_code', 'en')?->value;
        }

        return $localized ?? $default ?? $key;
    }
}
