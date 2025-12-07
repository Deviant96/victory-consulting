<?php

/**
 * LIVEWIRE ROUTE EXAMPLES
 * 
 * Replace the old controller-based routes with these Livewire-integrated routes.
 * This file shows examples - integrate these into your routes/admin.php
 */

use Illuminate\Support\Facades\Route;

// =============================================================================
// DASHBOARD - Livewire Component
// =============================================================================

Route::get('/', function () {
    return view('admin.dashboard-new');
})->name('dashboard');

// =============================================================================
// TEAM MEMBERS - Full Livewire CRUD
// =============================================================================

// List all team members (Livewire component with search, filter, pagination)
Route::get('/team', function () {
    return view('admin.team.index-livewire');
})->name('team.index');

// Create new team member (Livewire form with file upload)
Route::get('/team/create', function () {
    return view('admin.team.form-livewire', [
        'isEditMode' => false,
        'memberId' => null
    ]);
})->name('team.create');

// Edit team member (Livewire form pre-filled)
Route::get('/team/{id}/edit', function ($id) {
    return view('admin.team.form-livewire', [
        'isEditMode' => true,
        'memberId' => $id
    ]);
})->name('team.edit');

// =============================================================================
// BOOKINGS - Livewire with Modal Details
// =============================================================================

Route::get('/bookings', function () {
    return view('admin.bookings.index-livewire');
})->name('bookings.index');

// =============================================================================
// MIGRATION STRATEGY
// =============================================================================

/**
 * OPTION 1: Gradual Migration (Recommended)
 * Keep old routes working, add new Livewire routes with different names
 */

// Old route (keep for now)
// Route::resource('team', TeamMemberController::class);

// New Livewire route
// Route::get('/team-livewire', fn() => view('admin.team.index-livewire'))->name('team.livewire');

/**
 * OPTION 2: Complete Replacement
 * Comment out old controller routes, replace with Livewire views
 */

// BEFORE:
// Route::resource('team', TeamMemberController::class);

// AFTER:
// Route::get('/team', fn() => view('admin.team.index-livewire'))->name('team.index');
// Route::get('/team/create', fn() => view('admin.team.form-livewire', ['isEditMode' => false]))->name('team.create');
// Route::get('/team/{id}/edit', fn($id) => view('admin.team.form-livewire', ['isEditMode' => true, 'memberId' => $id]))->name('team.edit');

/**
 * OPTION 3: Hybrid Approach
 * Use Livewire for index/list pages, keep controllers for forms if needed
 */

// Livewire for listing
// Route::get('/team', fn() => view('admin.team.index-livewire'))->name('team.index');

// Keep controller for create/edit if you prefer
// Route::get('/team/create', [TeamMemberController::class, 'create'])->name('team.create');
// Route::post('/team', [TeamMemberController::class, 'store'])->name('team.store');
// Route::get('/team/{id}/edit', [TeamMemberController::class, 'edit'])->name('team.edit');
// Route::put('/team/{id}', [TeamMemberController::class, 'update'])->name('team.update');

// =============================================================================
// TESTING YOUR LIVEWIRE ROUTES
// =============================================================================

/**
 * After updating routes, test:
 * 
 * 1. Clear route cache:
 *    php artisan route:clear
 * 
 * 2. View routes:
 *    php artisan route:list --name=admin
 * 
 * 3. Test in browser:
 *    - Navigate to /admin/team
 *    - Try search, sorting, pagination
 *    - Create new team member
 *    - Edit existing member
 *    - Delete member
 * 
 * 4. Check browser console for any JavaScript errors
 * 
 * 5. Verify Livewire is loaded:
 *    - View page source
 *    - Look for @livewireScripts
 *    - Check for wire:id attributes on components
 */

// =============================================================================
// ADDITIONAL MODULES TO MIGRATE
// =============================================================================

/**
 * Apply the same pattern to other modules:
 * 
 * - Services (app/Livewire/Admin/Services/)
 * - FAQs (app/Livewire/Admin/Faqs/)
 * - Blog Posts/Articles (app/Livewire/Admin/Articles/)
 * - Business Solutions (app/Livewire/Admin/BusinessSolutions/)
 * - Settings (app/Livewire/Admin/Settings/)
 * 
 * Each should follow the pattern:
 * 1. Create Livewire component class
 * 2. Create Livewire component view
 * 3. Create wrapper Blade view (extends layout)
 * 4. Update route to use wrapper view
 */
