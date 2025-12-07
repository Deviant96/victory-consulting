<?php

namespace App\Livewire\Admin\BusinessSolutions;

use App\Models\BusinessSolution;
use Livewire\Component;
use Livewire\WithPagination;

class BusinessSolutionsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $perPage = 15;
    public $showFilters = false;

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

    public function toggleActive($solutionId)
    {
        $solution = BusinessSolution::findOrFail($solutionId);
        $solution->update(['is_active' => !$solution->is_active]);
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $solution->is_active ? 'Solution activated' : 'Solution deactivated'
        ]);
    }

    public function updateOrder($solutionId, $direction)
    {
        $solution = BusinessSolution::findOrFail($solutionId);
        $currentOrder = $solution->order;

        if ($direction === 'up') {
            // Find solution with previous order
            $swapSolution = BusinessSolution::where('order', '<', $currentOrder)
                ->orderBy('order', 'desc')
                ->first();
        } else {
            // Find solution with next order
            $swapSolution = BusinessSolution::where('order', '>', $currentOrder)
                ->orderBy('order', 'asc')
                ->first();
        }

        if ($swapSolution) {
            // Swap orders
            $tempOrder = $solution->order;
            $solution->update(['order' => $swapSolution->order]);
            $swapSolution->update(['order' => $tempOrder]);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Order updated'
            ]);
        }
    }

    public function deleteSolution($solutionId)
    {
        $solution = BusinessSolution::findOrFail($solutionId);
        
        // Delete associated sub-solutions
        $solution->subSolutions()->delete();
        
        $solution->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Business solution and its sub-solutions deleted successfully'
        ]);
    }

    public function render()
    {
        $query = BusinessSolution::query()->withCount('subSolutions');

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Status filter
        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter === '1');
        }

        $solutions = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.business-solutions.business-solutions-index', [
            'solutions' => $solutions,
        ]);
    }
}
