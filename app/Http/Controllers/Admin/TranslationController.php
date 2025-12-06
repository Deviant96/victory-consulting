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
        $translationKeys = TranslationKey::orderBy('group')->orderBy('key')->paginate(15);
        $languages = Language::active()->get();

        return view('admin.translations.index', compact('translationKeys', 'languages'));
    }

    public function create(): View
    {
        $languages = Language::active()->get();

        return view('admin.translations.create', compact('languages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:translation_keys,key'],
            'group' => ['nullable', 'string', 'max:100'],
            'translations' => ['array'],
            'translations.*' => ['nullable', 'string'],
        ]);

        $translationKey = TranslationKey::create([
            'key' => $data['key'],
            'group' => $data['group'] ?: 'default',
        ]);

        $languages = Language::active()->pluck('code');
        foreach ($languages as $code) {
            $value = $data['translations'][$code] ?? null;
            if ($value !== null && $value !== '') {
                TranslationValue::create([
                    'translation_key_id' => $translationKey->id,
                    'language_code' => $code,
                    'value' => $value,
                ]);
            }
        }

        return redirect()->route('admin.translations.index')->with('success', 'Translation key created successfully.');
    }

    public function edit(TranslationKey $translation): View
    {
        $languages = Language::active()->get();

        return view('admin.translations.edit', [
            'translationKey' => $translation,
            'languages' => $languages,
        ]);
    }

    public function update(Request $request, TranslationKey $translation): RedirectResponse
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:translation_keys,key,' . $translation->id],
            'group' => ['nullable', 'string', 'max:100'],
            'translations' => ['array'],
            'translations.*' => ['nullable', 'string'],
        ]);

        $translation->update([
            'key' => $data['key'],
            'group' => $data['group'] ?: 'default',
        ]);

        $languages = Language::active()->pluck('code');
        foreach ($languages as $code) {
            $value = $data['translations'][$code] ?? null;
            TranslationValue::updateOrCreate(
                [
                    'translation_key_id' => $translation->id,
                    'language_code' => $code,
                ],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.translations.index')->with('success', 'Translations updated successfully.');
    }

    public function destroy(TranslationKey $translation): RedirectResponse
    {
        $translation->delete();

        return redirect()->route('admin.translations.index')->with('success', 'Translation key removed successfully.');
    }
}
