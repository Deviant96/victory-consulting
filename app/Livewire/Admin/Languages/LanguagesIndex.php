<?php

namespace App\Livewire\Admin\Languages;

use App\Models\Language;
use Livewire\Component;
use Livewire\WithPagination;

class LanguagesIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $language = Language::findOrFail($id);
        $language->update([
            'is_active' => !$language->is_active
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Language status updated successfully'
        ]);
    }

    public function delete($id)
    {
        $language = Language::findOrFail($id);
        
        // Check if language is being used in translations
        $translationCount = $language->translationValues()->count();
        
        if ($translationCount > 0) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => "Cannot delete language with {$translationCount} active translations"
            ]);
            return;
        }

        $language->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Language deleted successfully'
        ]);
    }

    public function render()
    {
        $query = Language::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('code', 'like', '%' . $this->search . '%')
                  ->orWhere('label', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter);
        }

        $languages = $query->orderBy('code')->paginate(20);

        return view('livewire.admin.languages.languages-index', [
            'languages' => $languages,
        ]);
    }
}
