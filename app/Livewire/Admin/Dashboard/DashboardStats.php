<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\BlogPost;
use App\Models\Booking;
use App\Models\Faq;
use App\Models\Service;
use App\Models\TeamMember;
use Livewire\Component;

/**
 * Dashboard Statistics Component
 * 
 * Displays key metrics and statistics for the admin dashboard
 * including services, team members, FAQs, articles, and bookings.
 */
class DashboardStats extends Component
{
    // Reactive properties
    public $stats = [];
    public $bookingStatusCounts = [];
    public $recentBookings;
    public $recentPosts;
    
    // Refresh interval (in milliseconds) - set to 0 to disable auto-refresh
    public $refreshInterval = 60000; // 1 minute
    
    /**
     * Mount the component and load initial data
     */
    public function mount()
    {
        $this->loadStats();
    }
    
    /**
     * Load all dashboard statistics
     */
    public function loadStats()
    {
        // Main stats
        $this->stats = [
            'services' => Service::count(),
            'team' => TeamMember::count(),
            'faqs' => Faq::count(),
            'articles' => BlogPost::count(),
            'bookings' => Booking::count(),
        ];
        
        // Booking status breakdown
        $this->bookingStatusCounts = collect(Booking::STATUSES)
            ->mapWithKeys(fn ($status) => [
                $status => Booking::where('status', $status)->count(),
            ])
            ->toArray();
        
        // Recent data
        $this->recentBookings = Booking::with('language')
            ->latest()
            ->take(5)
            ->get();
            
        $this->recentPosts = BlogPost::latest()
            ->take(4)
            ->get();
    }
    
    /**
     * Refresh statistics (can be called manually or via polling)
     */
    public function refresh()
    {
        $this->loadStats();
        $this->dispatch('notify', message: 'Dashboard refreshed');
    }
    
    /**
     * Get booking completion percentage
     */
    public function getBookingCompletionPercentage()
    {
        $total = $this->stats['bookings'] ?? 1;
        $pending = $this->bookingStatusCounts['pending'] ?? 0;
        
        if ($total === 0) {
            return 0;
        }
        
        return min(100, round(($pending / $total) * 100, 1));
    }
    
    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.admin.dashboard.dashboard-stats');
    }
}
