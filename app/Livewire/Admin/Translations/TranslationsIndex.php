<?php

namespace App\Livewire\Admin\Translations;

use App\Models\Language;
use App\Models\TranslationKey;
use Livewire\Component;
use Livewire\WithPagination;

class TranslationsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $groupFilter = '';
    public $languageFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'groupFilter' => ['except' => ''],
        'languageFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingGroupFilter()
    {
        $this->resetPage();
    }

    public function updatingLanguageFilter()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $translationKey = TranslationKey::findOrFail($id);
        $translationKey->values()->delete();
        $translationKey->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Translation key deleted successfully'
        ]);
    }

    public function render()
    {
        $query = TranslationKey::with('values');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('key', 'like', '%' . $this->search . '%')
                  ->orWhereHas('values', function ($q) {
                      $q->where('value', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->groupFilter) {
            $query->where('group', $this->groupFilter);
        }

        $translationKeys = $query->orderBy('group')->orderBy('key')->paginate(20);

        $groups = TranslationKey::select('group')
            ->distinct()
            ->whereNotNull('group')
            ->orderBy('group')
            ->pluck('group');

        $languages = Language::active()->orderBy('code')->get();

        return view('livewire.admin.translations.translations-index', [
            'translationKeys' => $translationKeys,
            'groups' => $groups,
            'languages' => $languages,
        ]);
    }
}
