<?php

namespace App\Traits;

use App\Models\ContentTranslation;

trait HasTranslations
{
    public static function bootHasTranslations(): void
    {
        static::retrieved(function ($model) {
            $model->loadMissing('translations');
        });
    }

    public function initializeHasTranslations(): void
    {
        $this->with = array_unique(array_merge($this->with, ['translations']));
    }

    public function translations()
    {
        return $this->morphMany(ContentTranslation::class, 'model');
    }

    public function translate(string $field, ?string $locale = null, $default = null): mixed
    {
        $locale = $locale ?? app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        $matchingTranslations = $this->translations
            ->where('field', $field);

        $value = optional($matchingTranslations->firstWhere('language_code', $locale))->value;

        if (!$value && $locale !== $fallback) {
            $value = optional($matchingTranslations->firstWhere('language_code', $fallback))->value;
        }

        if (!$value && $this->getAttribute($field)) {
            $value = $this->getAttribute($field);
        }

        return $value ?? $default;
    }

    public function setTranslation(string $field, string $locale, $value): void
    {
        $this->translations()
            ->updateOrCreate(
                [
                    'field' => $field,
                    'language_code' => $locale,
                ],
                ['value' => $value]
            );
    }
}
