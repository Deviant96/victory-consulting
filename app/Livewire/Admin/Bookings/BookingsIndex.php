<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Bookings Index Component
 * 
 * Manages booking inquiries with search, filter by status, and sorting.
 */
class BookingsIndex extends Component
{
    use WithPagination;
    
    // Search and filters
    public $search = '';
    public $status = '';
    
    // Sorting
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // Pagination
    public $perPage = 15;
    
    // UI state
    public $showFilters = true;
    
    // Selected booking for modal
    public $selectedBooking = null;
    public $showModal = false;
    
    // Query string
    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];
    
    /**
     * Reset pagination on search/filter change
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
     * Clear filters
     */
    public function clearFilters()
    {
        $this->reset(['search', 'status']);
        $this->resetPage();
    }
    
    /**
     * View booking details
     */
    public function view($id)
    {
        $this->selectedBooking = Booking::with('language')->findOrFail($id);
        $this->showModal = true;
    }
    
    /**
     * Close modal
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedBooking = null;
    }
    
    /**
     * Update booking status
     */
    public function updateStatus($id, $newStatus)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $newStatus]);
        
        $this->dispatch('notify', message: "Booking status updated to {$newStatus}");
        
        // Reload if viewing this booking
        if ($this->selectedBooking && $this->selectedBooking->id === $id) {
            $this->selectedBooking = $booking->fresh();
        }
    }
    
    /**
     * Delete booking
     */
    public function delete($id)
    {
        Booking::findOrFail($id)->delete();
        
        $this->dispatch('notify', message: 'Booking deleted successfully');
        
        if ($this->showModal && $this->selectedBooking->id === $id) {
            $this->closeModal();
        }
    }
    
    /**
     * Get status color
     */
    public function getStatusColor($status)
    {
        return match($status) {
            'pending' => 'amber',
            'confirmed' => 'blue',
            'rescheduled' => 'purple',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'slate',
        };
    }
    
    /**
     * Render component
     */
    public function render()
    {
        $bookings = Booking::query()
            ->with('language')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('company', 'like', "%{$this->search}%")
                      ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        
        return view('livewire.admin.bookings.bookings-index', [
            'bookings' => $bookings,
            'statuses' => Booking::STATUSES,
        ]);
    }
}
