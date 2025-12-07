<?php

namespace App\Livewire\Admin\Languages;

use App\Models\Language;
use Livewire\Component;

class LanguageForm extends Component
{
    public ?Language $language = null;
    public $code = '';
    public $label = '';
    public $is_active = true;

    public function mount(?Language $language = null)
    {
        if ($language && $language->exists) {
            $this->language = $language;
            $this->code = $language->code;
            $this->label = $language->label;
            $this->is_active = $language->is_active;
        }
    }

    protected function rules()
    {
        return [
            'code' => 'required|string|max:10|unique:languages,code,' . ($this->language?->id ?? 'NULL'),
            'label' => 'required|string|max:100',
            'is_active' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->language && $this->language->exists) {
            $this->language->update([
                'code' => $this->code,
                'label' => $this->label,
                'is_active' => $this->is_active,
            ]);
            $message = 'Language updated successfully';
        } else {
            Language::create([
                'code' => $this->code,
                'label' => $this->label,
                'is_active' => $this->is_active,
            ]);
            $message = 'Language created successfully';
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);

        return redirect()->route('admin.languages.index');
    }

    public function render()
    {
        return view('livewire.admin.languages.language-form');
    }
}
