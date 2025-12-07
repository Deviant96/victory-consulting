<?php

namespace App\Livewire\Admin\TeamMembers;

use App\Models\TeamMember;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Team Members Index Component
 * 
 * Handles listing, searching, sorting, and pagination of team members.
 * Provides inline actions for editing and deleting team members.
 */
class TeamMembersIndex extends Component
{
    use WithPagination;
    
    // Search and filter properties
    public $search = '';
    public $status = '';
    
    // Sorting properties
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // Pagination
    public $perPage = 10;
    
    // UI state
    public $showFilters = true;
    
    // Query string for URL persistence
    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];
    
    /**
     * Reset pagination when search/filter changes
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingStatus()
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
     * Clear all filters
     */
    public function clearFilters()
    {
        $this->reset(['search', 'status']);
        $this->resetPage();
    }
    
    /**
     * Delete team member
     */
    public function delete($id)
    {
        $member = TeamMember::findOrFail($id);
        
        // Delete photo if exists
        if ($member->photo && \Storage::disk('public')->exists($member->photo)) {
            \Storage::disk('public')->delete($member->photo);
        }
        
        $member->delete();
        
        $this->dispatch('notify', message: 'Team member deleted successfully');
    }
    
    /**
     * Toggle filters visibility
     */
    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }
    
    /**
     * Render the component
     */
    public function render()
    {
        $members = TeamMember::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('position', 'like', "%{$this->search}%")
                      ->orWhere('bio', 'like', "%{$this->search}%");
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        
        return view('livewire.admin.team-members.team-members-index', [
            'members' => $members,
        ]);
    }
}
