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
use App\Http\Controllers\Admin\WhyChooseItemController;
use App\Http\Controllers\Admin\BusinessSolutionController;
use App\Http\Controllers\Admin\SubSolutionController;
use App\Http\Controllers\Admin\WhatsAppAgentController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\VisionController;
use App\Http\Controllers\Admin\MissionController;
use App\Http\Controllers\Admin\PageController;
use App\Models\BlogPost;
use App\Models\Booking;
use App\Models\Faq;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Route;

$dashboardStats = function (): array {
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

    return [
        'stats' => $stats,
        'bookingStatusCounts' => $bookingStatusCounts,
        'recentBookings' => $recentBookings,
        'recentPosts' => $recentPosts,
    ];
};

// Hub
Route::get('/', function () use ($dashboardStats) {
    return view('admin.hub', $dashboardStats());
})->name('hub');

// Backward-compatible dashboard alias
Route::get('/dashboard', function () {
    return redirect()->route('admin.hub');
})->name('dashboard');

// Overview
Route::get('/overview', function () use ($dashboardStats) {
    return view('admin.overview', $dashboardStats());
})->name('overview');

// Notifications
Route::post('/notifications/read', [NotificationController::class, 'markAllRead'])->name('notifications.read');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Website section
Route::prefix('website')->group(function () {
    Route::redirect('/', '/admin/website/pages/home');

    Route::get('/appearance', [SettingController::class, 'appearance'])->name('website.appearance');
    Route::post('/appearance', [SettingController::class, 'updateAppearance'])->name('website.appearance.update');

    Route::resource('services', ServiceController::class)->names('services');
    Route::resource('team', TeamMemberController::class)->names('team');
    Route::resource('faqs', FaqController::class)->names('faqs');
    Route::resource('articles', BlogPostController::class)->names('articles');
    Route::resource('why-choose-items', WhyChooseItemController::class)->names('why-choose-items');
    Route::resource('business-solutions', BusinessSolutionController::class)->names('business-solutions');
    Route::resource('sub-solutions', SubSolutionController::class)->names('sub-solutions');
    Route::resource('about-sections', AboutSectionController::class)->names('about-sections');
    Route::resource('visions', VisionController::class)->names('visions');
    Route::resource('missions', MissionController::class)->names('missions');

    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/home', [PageController::class, 'home'])->name('home');
        Route::post('/home', [PageController::class, 'updateHome'])->name('home.update');

        Route::get('/services', [PageController::class, 'services'])->name('services');
        Route::post('/services', [PageController::class, 'updateServices'])->name('services.update');

        Route::get('/industry', [PageController::class, 'industry'])->name('industry');
        Route::post('/industry', [PageController::class, 'updateIndustry'])->name('industry.update');

        Route::get('/blog', [PageController::class, 'blog'])->name('blog');
        Route::post('/blog', [PageController::class, 'updateBlog'])->name('blog.update');

        Route::get('/contact', [PageController::class, 'contact'])->name('contact');
        Route::post('/contact', [PageController::class, 'updateContact'])->name('contact.update');
        
        Route::get('/about', [SettingController::class, 'about'])->name('about');
        Route::post('/about', [SettingController::class, 'updateAbout'])->name('about.update');
    });
});

// Client Inquiries section
Route::prefix('inquiries')->group(function () {
    Route::redirect('/', '/admin/inquiries/bookings');

    Route::resource('bookings', BookingController::class)
        ->only(['index', 'show', 'update', 'destroy'])
        ->names('bookings');

    Route::resource('whatsapp-agents', WhatsAppAgentController::class)->names('whatsapp-agents');

    Route::get('/notification-settings', [SettingController::class, 'booking'])->name('settings.booking');
    Route::post('/notification-settings', [SettingController::class, 'updateBooking'])->name('settings.booking.update');
});

// Settings section
Route::prefix('settings')->group(function () {
    Route::get('/contact', [SettingController::class, 'contact'])->name('settings.contact');
    Route::post('/contact', [SettingController::class, 'updateContact'])->name('settings.contact.update');

    Route::get('/social', [SettingController::class, 'social'])->name('settings.social');
    Route::post('/social', [SettingController::class, 'updateSocial'])->name('settings.social.update');

    Route::get('/branding', [SettingController::class, 'branding'])->name('settings.branding');
    Route::post('/branding', [SettingController::class, 'updateBranding'])->name('settings.branding.update');

    Route::get('/hero', [SettingController::class, 'hero'])->name('settings.hero');
    Route::post('/hero', [SettingController::class, 'updateHero'])->name('settings.hero.update');

    Route::resource('languages', LanguageController::class)->names('languages');

    Route::get('translations/export', [TranslationController::class, 'export'])->name('translations.export');
    Route::post('translations/import', [TranslationController::class, 'import'])->name('translations.import');
    Route::put('translations/{translation}/inline', [TranslationController::class, 'inlineUpdate'])->name('translations.inline');
    Route::resource('translations', TranslationController::class)->except(['show'])->names('translations');

    Route::get('/logs', [AdminLogController::class, 'index'])->name('logs.index');
});
