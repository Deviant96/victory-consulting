<?php

use App\Models\Setting;
use App\Models\TranslationKey;

if (!function_exists('settings')) {
    /**
     * Get or set settings with translation support
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

        static $cache = [];
        $cacheKey = $key . '_' . app()->getLocale();
        
        if (isset($cache[$cacheKey])) {
            return $cache[$cacheKey];
        }

        $setting = Setting::where('key', $key)->first();
        
        if (!$setting) {
            $cache[$cacheKey] = $default;
            return $default;
        }

        // If setting has translations, try to get translated value
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');
        
        if ($locale !== $fallback) {
            // Extract field name from key (e.g., 'about.header_title' -> 'header_title')
            $fieldName = substr($key, strrpos($key, '.') + 1);
            
            $translation = \App\Models\ContentTranslation::where('model_type', Setting::class)
                ->where('model_id', $setting->id)
                ->where('language_code', $locale)
                ->where('field', $fieldName)
                ->first();
            
            if ($translation && $translation->value) {
                $cache[$cacheKey] = $translation->value;
                return $translation->value;
            }
        }

        $cache[$cacheKey] = $setting->value ?? $default;
        return $setting->value ?? $default;
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
