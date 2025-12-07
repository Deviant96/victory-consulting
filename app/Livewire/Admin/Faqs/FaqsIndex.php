<?php

namespace App\Livewire\Admin\Faqs;

use App\Models\Faq;
use Livewire\Component;
use Livewire\WithPagination;

class FaqsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $publishedFilter = '';
    public $perPage = 15;
    public $showFilters = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'publishedFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingPublishedFilter()
    {
        $this->resetPage();
    }

    public function togglePublished($faqId)
    {
        $faq = Faq::findOrFail($faqId);
        $faq->update(['published' => !$faq->published]);
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $faq->published ? 'FAQ published' : 'FAQ unpublished'
        ]);
    }

    public function updateOrder($faqId, $direction)
    {
        $faq = Faq::findOrFail($faqId);
        $currentOrder = $faq->order;

        if ($direction === 'up') {
            // Find FAQ with previous order
            $swapFaq = Faq::where('order', '<', $currentOrder)
                ->orderBy('order', 'desc')
                ->first();
        } else {
            // Find FAQ with next order
            $swapFaq = Faq::where('order', '>', $currentOrder)
                ->orderBy('order', 'asc')
                ->first();
        }

        if ($swapFaq) {
            // Swap orders
            $tempOrder = $faq->order;
            $faq->update(['order' => $swapFaq->order]);
            $swapFaq->update(['order' => $tempOrder]);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Order updated'
            ]);
        }
    }

    public function deleteFaq($faqId)
    {
        $faq = Faq::findOrFail($faqId);
        $faq->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'FAQ deleted successfully'
        ]);
    }

    public function render()
    {
        $query = Faq::query();

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('question', 'like', '%' . $this->search . '%')
                  ->orWhere('answer', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        // Category filter
        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        // Published filter
        if ($this->publishedFilter !== '') {
            $query->where('published', $this->publishedFilter === '1');
        }

        // Get categories for filter
        $categories = Faq::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        $faqs = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.faqs.faqs-index', [
            'faqs' => $faqs,
            'categories' => $categories,
        ]);
    }
}
