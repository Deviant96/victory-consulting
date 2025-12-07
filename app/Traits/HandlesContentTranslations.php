<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HandlesContentTranslations
{
    /**
     * Sync translation inputs from the request into the model's translations table.
     */
    protected function syncTranslations($model, Request $request, array $translatableFields): void
    {
        $translations = $request->input('translations', []);
        $fallback = config('app.fallback_locale', 'en');

        foreach ($translations as $locale => $fields) {
            if ($locale === $fallback) {
                continue; // English/base language lives on the model columns
            }

            foreach ($translatableFields as $field) {
                $value = $fields[$field] ?? null;

                if ($value === null || $value === '') {
                    $model->translations()
                        ->where('language_code', $locale)
                        ->where('field', $field)
                        ->delete();
                    continue;
                }

                $model->setTranslation($field, $locale, $value);
            }
        }
    }
}
