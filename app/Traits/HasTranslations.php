<?php

namespace App\Traits;

use App\Models\ContentTranslation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTranslations
{
    /**
     * Automatically eager load translations whenever the model is retrieved.
     */
    public function initializeHasTranslations(): void
    {
        if (!in_array('translations', $this->with, true)) {
            $this->with[] = 'translations';
        }
    }

    public function translations(): MorphMany
    {
        return $this->morphMany(ContentTranslation::class, 'model');
    }

    /**
     * Resolve a translated field with English fallback and optional default.
     */
    public function translate(string $field, ?string $locale = null, $default = null): mixed
    {
        $locale = $locale ?? app()->getLocale() ?? 'en';

        $translation = $this->translations
            ->first(fn ($item) => $item->field === $field && $item->language_code === $locale);

        if ($translation && $translation->value !== null && $translation->value !== '') {
            return $translation->value;
        }

        if ($locale !== 'en') {
            $fallback = $this->translations
                ->first(fn ($item) => $item->field === $field && $item->language_code === 'en');

            if ($fallback && $fallback->value !== null && $fallback->value !== '') {
                return $fallback->value;
            }
        }

        return $this->getAttribute($field) ?? $default;
    }
}
