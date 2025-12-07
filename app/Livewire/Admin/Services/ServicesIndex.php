<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Services Index Component
 * 
 * Manages service listings with search, filter, and sorting.
 */
class ServicesIndex extends Component
{
    use WithPagination;
    
    // Search and filters
    public $search = '';
    public $published = '';
    
    // Sorting
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // Pagination
    public $perPage = 12;
    
    // UI state
    public $showFilters = true;
    
    // Query string
    protected $queryString = [
        'search' => ['except' => ''],
        'published' => ['except' => ''],
    ];
    
    /**
     * Reset pagination on search/filter change
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingPublished()
    {
        $this->resetPage();
    }
    
    /**
     * Sort by field
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    /**
     * Clear filters
     */
    public function clearFilters()
    {
        $this->reset(['search', 'published']);
        $this->resetPage();
    }
    
    /**
     * Toggle publish status
     */
    public function togglePublished($id)
    {
        $service = Service::findOrFail($id);
        $service->published = !$service->published;
        $service->save();
        
        $status = $service->published ? 'published' : 'unpublished';
        $this->dispatch('notify', message: "Service {$status} successfully");
    }
    
    /**
     * Delete service
     */
    public function delete($id)
    {
        $service = Service::findOrFail($id);
        
        // Delete featured image if exists
        if ($service->featured_image && \Storage::disk('public')->exists($service->featured_image)) {
            \Storage::disk('public')->delete($service->featured_image);
        }
        
        // Delete highlights
        $service->highlights()->delete();
        
        $service->delete();
        
        $this->dispatch('notify', message: 'Service deleted successfully');
    }
    
    /**
     * Render component
     */
    public function render()
    {
        $services = Service::query()
            ->with('highlights')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                      ->orWhere('summary', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->published !== '', function ($query) {
                $query->where('published', $this->published);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        
        return view('livewire.admin.services.services-index', [
            'services' => $services,
        ]);
    }
}
