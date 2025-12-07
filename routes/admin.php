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
use App\Http\Controllers\Admin\VisionController;
use App\Http\Controllers\Admin\MissionController;
use App\Models\BlogPost;
use App\Models\Booking;
use App\Models\BusinessSolution;
use App\Models\Faq;
use App\Models\Language;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\TranslationKey;
use App\Models\WhyChooseItem;
use Illuminate\Support\Facades\Route;

// Dashboard - Livewire Component
Route::get('/', function () {
    return view('admin.dashboard-new');
})->name('dashboard');

// Notifications
Route::post('/notifications/read', [NotificationController::class, 'markAllRead'])->name('notifications.read');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Activity Logs - Livewire Component
Route::get('/logs', fn() => view('admin.admin-logs.index-livewire'))->name('logs.index');

// Bookings - Livewire Component
Route::get('/bookings', function () {
    return view('admin.bookings.index-livewire');
})->name('bookings.index');

// Keep old booking routes for show/update/destroy (non-index operations)
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

// Services - Livewire Component
Route::get('/services', fn() => view('admin.services.index-livewire'))->name('services.index');
Route::get('/services/create', fn() => view('admin.services.form-livewire'))->name('services.create');
Route::get('/services/{service}/edit', fn(Service $service) => view('admin.services.form-livewire', ['service' => $service]))->name('services.edit');

// Team Members
Route::get('/team', fn() => view('admin.team.index-livewire'))->name('team.index');
Route::get('/team/create', fn() => view('admin.team.form-livewire', ['isEditMode' => false]))->name('team.create');
Route::get('/team/{id}/edit', fn($id) => view('admin.team.form-livewire', ['isEditMode' => true, 'memberId' => $id]))->name('team.edit');


// FAQs - Livewire Component
Route::get('/faqs', fn() => view('admin.faqs.index-livewire'))->name('faqs.index');
Route::get('/faqs/create', fn() => view('admin.faqs.form-livewire'))->name('faqs.create');
Route::get('/faqs/{faq}/edit', fn(Faq $faq) => view('admin.faqs.form-livewire', ['faq' => $faq]))->name('faqs.edit');

// Blog Posts / Articles - Livewire Component
Route::get('/articles', fn() => view('admin.articles.index-livewire'))->name('articles.index');
Route::get('/articles/create', fn() => view('admin.articles.form-livewire'))->name('articles.create');
Route::get('/articles/{article}/edit', fn(BlogPost $article) => view('admin.articles.form-livewire', ['article' => $article]))->name('articles.edit');

// Why Choose Items - Livewire Component
Route::get('/why-choose-items', fn() => view('admin.why-choose-items.index-livewire'))->name('why-choose-items.index');
Route::get('/why-choose-items/create', fn() => view('admin.why-choose-items.form-livewire'))->name('why-choose-items.create');
Route::get('/why-choose-items/{item}/edit', fn(WhyChooseItem $item) => view('admin.why-choose-items.form-livewire', ['item' => $item]))->name('why-choose-items.edit');

// Business Solutions - Livewire Component
Route::get('/business-solutions', fn() => view('admin.business-solutions.index-livewire'))->name('business-solutions.index');
Route::get('/business-solutions/create', fn() => view('admin.business-solutions.form-livewire'))->name('business-solutions.create');
Route::get('/business-solutions/{solution}/edit', fn(BusinessSolution $solution) => view('admin.business-solutions.form-livewire', ['solution' => $solution]))->name('business-solutions.edit');

// Sub Solutions - Managed within Business Solutions form
// Route::resource('sub-solutions', SubSolutionController::class);

// WhatsApp Agents
Route::resource('whatsapp-agents', WhatsAppAgentController::class);

// About Us Settings Page
Route::get('/settings/about', [SettingController::class, 'about'])->name('settings.about');
Route::post('/settings/about', [SettingController::class, 'updateAbout'])->name('settings.about.update');

// Visions
Route::resource('visions', VisionController::class);

// Missions
Route::resource('missions', MissionController::class);

// Settings - Livewire Component (unified interface)
Route::get('/settings', fn() => view('admin.settings.index-livewire'))->name('settings.index');

// Translations - Livewire Component
Route::get('/translations', fn() => view('admin.translations.index-livewire'))->name('translations.index');
Route::get('/translations/create', fn() => view('admin.translations.form-livewire'))->name('translations.create');
Route::get('/translations/{translationKey}/edit', fn(TranslationKey $translationKey) => view('admin.translations.form-livewire', ['translationKey' => $translationKey]))->name('translations.edit');

// Languages - Livewire Component
Route::get('/languages', fn() => view('admin.languages.index-livewire'))->name('languages.index');
Route::get('/languages/create', fn() => view('admin.languages.form-livewire'))->name('languages.create');
Route::get('/languages/{language}/edit', fn(Language $language) => view('admin.languages.form-livewire', ['language' => $language]))->name('languages.edit');

// Profile - Livewire Component
Route::get('/profile', fn() => view('admin.profile.index-livewire'))->name('profile.index');
