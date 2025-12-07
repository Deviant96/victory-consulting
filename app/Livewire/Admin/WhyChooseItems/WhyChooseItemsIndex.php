<?php

namespace App\Livewire\Admin\WhyChooseItems;

use App\Models\WhyChooseItem;
use Livewire\Component;
use Livewire\WithPagination;

class WhyChooseItemsIndex extends Component
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

    public function toggleActive($itemId)
    {
        $item = WhyChooseItem::findOrFail($itemId);
        $item->update(['is_active' => !$item->is_active]);
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $item->is_active ? 'Item activated' : 'Item deactivated'
        ]);
    }

    public function updateOrder($itemId, $direction)
    {
        $item = WhyChooseItem::findOrFail($itemId);
        $currentOrder = $item->order;

        if ($direction === 'up') {
            $swapItem = WhyChooseItem::where('order', '<', $currentOrder)
                ->orderBy('order', 'desc')
                ->first();
        } else {
            $swapItem = WhyChooseItem::where('order', '>', $currentOrder)
                ->orderBy('order', 'asc')
                ->first();
        }

        if ($swapItem) {
            $tempOrder = $item->order;
            $item->update(['order' => $swapItem->order]);
            $swapItem->update(['order' => $tempOrder]);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Order updated'
            ]);
        }
    }

    public function deleteItem($itemId)
    {
        $item = WhyChooseItem::findOrFail($itemId);
        $item->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Item deleted successfully'
        ]);
    }

    public function render()
    {
        $query = WhyChooseItem::query();

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('icon', 'like', '%' . $this->search . '%');
            });
        }

        // Status filter
        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter === '1');
        }

        $items = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.why-choose-items.why-choose-items-index', [
            'items' => $items,
        ]);
    }
}
