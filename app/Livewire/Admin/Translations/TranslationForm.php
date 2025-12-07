<?php

namespace App\Livewire\Admin\Translations;

use App\Models\Language;
use App\Models\TranslationKey;
use App\Models\TranslationValue;
use Livewire\Component;

class TranslationForm extends Component
{
    public ?TranslationKey $translationKey = null;
    public $key = '';
    public $group = '';
    public $translations = [];

    public function mount(?TranslationKey $translationKey = null)
    {
        if ($translationKey && $translationKey->exists) {
            $this->translationKey = $translationKey;
            $this->key = $translationKey->key;
            $this->group = $translationKey->group ?? '';

            // Load existing translations
            foreach (Language::active()->get() as $language) {
                $value = $translationKey->valueForLocale($language->code);
                $this->translations[$language->code] = $value ?? '';
            }
        } else {
            // Initialize empty translations for all active languages
            foreach (Language::active()->get() as $language) {
                $this->translations[$language->code] = '';
            }
        }
    }

    protected function rules()
    {
        return [
            'key' => 'required|string|max:255|unique:translation_keys,key,' . ($this->translationKey?->id ?? 'NULL'),
            'group' => 'nullable|string|max:100',
            'translations.*' => 'nullable|string|max:1000',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->translationKey && $this->translationKey->exists) {
            // Update existing translation key
            $this->translationKey->update([
                'key' => $this->key,
                'group' => $this->group,
            ]);
        } else {
            // Create new translation key
            $this->translationKey = TranslationKey::create([
                'key' => $this->key,
                'group' => $this->group,
            ]);
        }

        // Update or create translation values
        foreach ($this->translations as $languageCode => $value) {
            TranslationValue::updateOrCreate(
                [
                    'translation_key_id' => $this->translationKey->id,
                    'language_code' => $languageCode,
                ],
                [
                    'value' => $value,
                ]
            );
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Translation saved successfully'
        ]);

        return redirect()->route('admin.translations.index');
    }

    public function render()
    {
        $languages = Language::active()->orderBy('code')->get();

        return view('livewire.admin.translations.translation-form', [
            'languages' => $languages,
        ]);
    }
}
