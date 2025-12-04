<?php

use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\AdminLogController;
use App\Models\BlogPost;
use App\Models\Booking;
use App\Models\Faq;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stats = [
        'services' => Service::count(),
        'team' => TeamMember::count(),
        'faqs' => Faq::count(),
        'articles' => BlogPost::count(),
        'bookings' => Booking::count(),
    ];

    $bookingStatusCounts = collect(Booking::STATUSES)
        ->mapWithKeys(fn ($status) => [
            $status => Booking::where('status', $status)->count(),
        ]);

    $recentBookings = Booking::latest()->take(5)->get();
    $recentPosts = BlogPost::latest()->take(4)->get();

    return view('admin.dashboard', [
        'stats' => $stats,
        'bookingStatusCounts' => $bookingStatusCounts,
        'recentBookings' => $recentBookings,
        'recentPosts' => $recentPosts,
    ]);
})->name('dashboard');

// Notifications
Route::post('/notifications/read', [NotificationController::class, 'markAllRead'])->name('notifications.read');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Activity Logs
Route::get('/logs', [AdminLogController::class, 'index'])->name('logs.index');

// Bookings
Route::resource('bookings', BookingController::class)->only(['index', 'show', 'update', 'destroy']);

// Services
Route::resource('services', ServiceController::class);

// Team Members
Route::resource('team', TeamMemberController::class);

// FAQs
Route::resource('faqs', FaqController::class);

// Blog Posts / Articles
Route::resource('articles', BlogPostController::class);

// Settings
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/contact', [SettingController::class, 'contact'])->name('contact');
    Route::post('/contact', [SettingController::class, 'updateContact'])->name('contact.update');
    
    Route::get('/social', [SettingController::class, 'social'])->name('social');
    Route::post('/social', [SettingController::class, 'updateSocial'])->name('social.update');
    
    Route::get('/branding', [SettingController::class, 'branding'])->name('branding');
    Route::post('/branding', [SettingController::class, 'updateBranding'])->name('branding.update');

    Route::get('/booking', [SettingController::class, 'booking'])->name('booking');
    Route::post('/booking', [SettingController::class, 'updateBooking'])->name('booking.update');
});
