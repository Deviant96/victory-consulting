<?php

use App\Models\Setting;
use App\Models\TranslationKey;

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
     * Translate a static key using the database translations with English fallback.
     */
    function t(string $key, $default = null): mixed
    {
        static $cachedKeys = [];

        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        if (!array_key_exists($key, $cachedKeys)) {
            $cachedKeys[$key] = TranslationKey::with('values')->where('key', $key)->first();
        }

        /** @var TranslationKey|null $translationKey */
        $translationKey = $cachedKeys[$key];

        if ($translationKey) {
            $value = $translationKey->valueForLocale($locale);

            if (!$value && $locale !== $fallback) {
                $value = $translationKey->valueForLocale($fallback);
            }

            if ($value !== null && $value !== '') {
                return $value;
            }
        }

        return $default ?? $key;
    }
}
