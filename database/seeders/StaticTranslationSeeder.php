<?php

namespace Database\Seeders;

use App\Models\TranslationKey;
use App\Models\TranslationValue;
use Illuminate\Database\Seeder;

class StaticTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $fallbackLocale = config('app.fallback_locale', 'en');

        $translations = [
            ['group' => 'frontend.navigation', 'key' => 'home', 'value' => 'Home'],
            ['group' => 'frontend.navigation', 'key' => 'services', 'value' => 'Services'],
            ['group' => 'frontend.navigation', 'key' => 'industries', 'value' => 'Industries'],
            ['group' => 'frontend.navigation', 'key' => 'team', 'value' => 'Team'],
            ['group' => 'frontend.navigation', 'key' => 'blog', 'value' => 'Blog'],
            ['group' => 'frontend.navigation', 'key' => 'contact', 'value' => 'Contact'],
            ['group' => 'frontend.search', 'key' => 'placeholder', 'value' => 'Search services, people, articles'],
            ['group' => 'frontend.search', 'key' => 'title', 'value' => 'Search our site'],
            ['group' => 'frontend.search', 'key' => 'subtitle', 'value' => 'Services, team, articles, and contact info'],
            ['group' => 'frontend.search', 'key' => 'no_results', 'value' => 'No matches found. Try another term.'],
            ['group' => 'frontend.search', 'key' => 'loading', 'value' => 'Loading search index...'],
            ['group' => 'admin.actions', 'key' => 'add_translation_key', 'value' => 'Add Translation Key'],
            ['group' => 'admin.actions', 'key' => 'edit', 'value' => 'Edit'],
            ['group' => 'admin.common', 'key' => 'translations_header', 'value' => 'Manage static labels for admin and frontend.'],
            ['group' => 'admin.common', 'key' => 'no_translations', 'value' => 'No translation keys have been added yet.'],
        ];

        foreach ($translations as $item) {
            $translationKey = TranslationKey::firstOrCreate([
                'group' => $item['group'],
                'key' => $item['group'] . '.' . $item['key'],
            ]);

            TranslationValue::updateOrCreate(
                [
                    'translation_key_id' => $translationKey->id,
                    'language_code' => $fallbackLocale,
                ],
                [
                    'value' => $item['value'],
                ]
            );
        }
    }
}
