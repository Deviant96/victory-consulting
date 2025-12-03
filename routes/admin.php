<?php

use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

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
