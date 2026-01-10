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

// Why Choose Items
Route::resource('why-choose-items', WhyChooseItemController::class);

// Business Solutions
Route::resource('business-solutions', BusinessSolutionController::class);

// Sub Solutions
Route::resource('sub-solutions', SubSolutionController::class);

// WhatsApp Agents
Route::resource('whatsapp-agents', WhatsAppAgentController::class);

// About Sections
Route::resource('about-sections', AboutSectionController::class);

// Visions
Route::resource('visions', VisionController::class);

// Missions
Route::resource('missions', MissionController::class);

// Pages
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
});

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

    Route::get('/hero', [SettingController::class, 'hero'])->name('hero');
    Route::post('/hero', [SettingController::class, 'updateHero'])->name('hero.update');

    Route::get('/about', [SettingController::class, 'about'])->name('about');
    Route::post('/about', [SettingController::class, 'updateAbout'])->name('about.update');
});

// Localization
Route::resource('languages', LanguageController::class);
Route::get('translations/export', [TranslationController::class, 'export'])->name('translations.export');
Route::post('translations/import', [TranslationController::class, 'import'])->name('translations.import');
Route::put('translations/{translation}/inline', [TranslationController::class, 'inlineUpdate'])->name('translations.inline');
Route::resource('translations', TranslationController::class)->except(['show']);
