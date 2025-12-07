<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\TeamController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\BookingController as FrontendBookingController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\IndustryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PushSubscriptionController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

// Public Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', SearchController::class)->name('search');

// Locale switching
Route::get('/set-locale/{locale}', [LocaleController::class, 'set'])->name('set-locale');

// Service Worker
Route::get('/service-worker.js', function () {
    return response()->file(public_path('service-worker.js'), [
        'Content-Type' => 'application/javascript',
    ]);
});

// Push notification diagnostic tool
Route::get('/push-diagnostic', function () {
    return view('push-diagnostic');
})->middleware('auth');

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Industries
Route::get('/industries', [IndustryController::class, 'index'])->name('industries.index');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Team
Route::get('/team', [TeamController::class, 'index'])->name('team');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/bookings', [FrontendBookingController::class, 'store'])->name('bookings.store');

// Auth Routes
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/push-subscriptions', [PushSubscriptionController::class, 'store'])->name('push-subscriptions.store');
    Route::delete('/push-subscriptions', [PushSubscriptionController::class, 'destroy'])->name('push-subscriptions.destroy');
});

require __DIR__.'/auth.php';
