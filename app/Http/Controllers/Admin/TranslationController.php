<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\TranslationKey;
use App\Models\TranslationValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TranslationController extends Controller
{
    public function index(): View
    {
        $translationKeys = TranslationKey::with(['values'])
            ->orderBy('group')
            ->orderBy('key')
            ->paginate(15);

        $languages = Language::orderBy('label')->get();

        return view('admin.translations.index', compact('translationKeys', 'languages'));
    }

    public function create(): View
    {
        $languages = Language::orderBy('label')->get();
        $translationKey = new TranslationKey();
        $translationKey->setRelation('values', collect());

        return view('admin.translations.create', compact('languages', 'translationKey'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:translation_keys,key'],
            'group' => ['nullable', 'string', 'max:255'],
            'translations' => ['array'],
        ]);

        $translationKey = TranslationKey::create([
            'key' => $data['key'],
            'group' => $data['group'] ?? null,
        ]);

        $this->syncTranslations($translationKey, $data['translations'] ?? []);

        return redirect()->route('admin.translations.index')->with('success', 'Translation key created successfully.');
    }

    public function edit(TranslationKey $translation): View
    {
        $languages = Language::orderBy('label')->get();
        $translation->load('values');

        return view('admin.translations.edit', [
            'translationKey' => $translation,
            'languages' => $languages,
        ]);
    }

    public function update(Request $request, TranslationKey $translation): RedirectResponse
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:translation_keys,key,' . $translation->id],
            'group' => ['nullable', 'string', 'max:255'],
            'translations' => ['array'],
        ]);

        $translation->update([
            'key' => $data['key'],
            'group' => $data['group'] ?? null,
        ]);

        $this->syncTranslations($translation, $data['translations'] ?? []);

        return redirect()->route('admin.translations.edit', $translation)->with('success', 'Translations updated successfully.');
    }

    protected function syncTranslations(TranslationKey $translationKey, array $translations): void
    {
        $languages = Language::pluck('code')->all();

        foreach ($languages as $languageCode) {
            $value = $translations[$languageCode] ?? null;

            if ($value === null || $value === '') {
                TranslationValue::where('translation_key_id', $translationKey->id)
                    ->where('language_code', $languageCode)
                    ->delete();

                continue;
            }

            TranslationValue::updateOrCreate(
                [
                    'translation_key_id' => $translationKey->id,
                    'language_code' => $languageCode,
                ],
                [
                    'value' => $value,
                ]
            );
        }
    }
}
