# Livewire + AlpineJS Refactoring Guide

## Overview

This document describes the new Livewire + AlpineJS architecture implemented for the Victory Consulting admin panel. The refactoring transforms the admin UI into a fast, dynamic, no-reload experience while maintaining Blade layouts and Laravel routing.

## Architecture

### Component Structure

```
app/Livewire/Admin/
├── Dashboard/
│   └── DashboardStats.php          # Dashboard statistics component
├── TeamMembers/
│   ├── TeamMembersIndex.php        # Team listing with search/filter
│   └── TeamMemberForm.php          # Create/edit team member
└── Bookings/
    └── BookingsIndex.php            # Bookings management
```

### View Structure

```
resources/views/
├── components/
│   ├── toast.blade.php             # Reusable toast notification
│   ├── confirm-delete.blade.php    # Confirmation modal
│   ├── modal.blade.php             # Generic modal wrapper
│   ├── input.blade.php             # Enhanced input with validation
│   ├── select.blade.php            # Enhanced select dropdown
│   └── textarea.blade.php          # Enhanced textarea
├── livewire/admin/
│   ├── dashboard/
│   │   └── dashboard-stats.blade.php
│   ├── team-members/
│   │   ├── team-members-index.blade.php
│   │   └── team-member-form.blade.php
│   └── bookings/
│       └── bookings-index.blade.php
└── admin/
    ├── layouts/app.blade.php       # Main layout (includes Livewire)
    ├── dashboard-new.blade.php     # New dashboard view
    └── team/
        ├── index-livewire.blade.php
        └── form-livewire.blade.php
```

## Key Features Implemented

### 1. Dashboard Component (`DashboardStats`)

**Features:**
- Real-time statistics display
- Auto-refresh every 60 seconds (configurable)
- Manual refresh button
- Collapsible sections with Alpine transitions
- Loading states

**Usage:**
```blade
<livewire:admin.dashboard.dashboard-stats />
```

**Props:**
- `$refreshInterval` - Auto-refresh interval in milliseconds (default: 60000)

### 2. Team Members CRUD

#### Index Component (`TeamMembersIndex`)

**Features:**
- Live search with 300ms debounce
- Grid layout with responsive cards
- Sorting capabilities
- Pagination
- Inline delete with confirmation
- URL query string persistence
- Collapsible filters

**Usage:**
```blade
<livewire:admin.team-members.team-members-index />
```

**Public Methods:**
- `sortBy($field)` - Sort by column
- `clearFilters()` - Reset all filters
- `delete($id)` - Delete team member
- `toggleFilters()` - Show/hide filters

#### Form Component (`TeamMemberForm`)

**Features:**
- Photo upload with preview
- Real-time validation
- Dynamic expertise fields (add/remove)
- File upload progress indicator
- Image preview before upload

**Usage:**
```blade
<livewire:admin.team-members.team-member-form :member-id="$id" />
```

**Props:**
- `$memberId` - Optional ID for edit mode

### 3. Bookings Management (`BookingsIndex`)

**Features:**
- Live search across multiple fields
- Status filter dropdown
- Sortable columns
- Inline status update
- Modal for detailed view
- Delete with confirmation

**Usage:**
```blade
<livewire:admin.bookings.bookings-index />
```

**Public Methods:**
- `view($id)` - Open booking detail modal
- `updateStatus($id, $status)` - Update booking status
- `delete($id)` - Delete booking

## Reusable Components

### Toast Notification

**Usage:**
```blade
<x-toast />
```

**Triggering from Livewire:**
```php
$this->dispatch('notify', message: 'Operation successful');
```

**Triggering from Alpine:**
```javascript
$dispatch('notify', { message: 'Action completed' })
```

### Confirm Delete Modal

**Usage:**
```blade
<x-confirm-delete 
    title="Confirm Deletion" 
    message="Are you sure you want to delete this item?" 
/>
```

**Triggering:**
```javascript
$dispatch('confirm-delete', { action: () => { /* callback */ } })
```

### Modal Component

**Usage:**
```blade
<x-modal name="my-modal" max-width="2xl">
    <div class="p-6">
        <!-- Modal content -->
    </div>
</x-modal>
```

**Opening/Closing:**
```javascript
// Open
$dispatch('open-modal', 'my-modal')

// Close
$dispatch('close-modal', 'my-modal')
```

### Enhanced Form Inputs

**Input Component:**
```blade
<x-input 
    label="Name" 
    name="name" 
    type="text" 
    :required="true"
    placeholder="Enter name"
    help="This is a help text"
/>
```

**Select Component:**
```blade
<x-select 
    label="Status" 
    name="status"
    :options="['draft' => 'Draft', 'published' => 'Published']"
    :required="true"
/>
```

**Textarea Component:**
```blade
<x-textarea 
    label="Description" 
    name="description"
    rows="4"
    placeholder="Enter description"
/>
```

## Livewire Directives Used

### Wire Model
```blade
wire:model.live="search"           {{-- Live binding with updates on every keystroke --}}
wire:model.live.debounce.300ms="search"  {{-- Debounced live binding --}}
wire:model.defer="name"            {{-- Deferred binding (updates on submit) --}}
```

### Wire Actions
```blade
wire:click="delete({{ $id }})"     {{-- Call component method --}}
wire:confirm="Are you sure?"       {{-- Browser confirmation before action --}}
wire:loading                       {{-- Show/hide during loading --}}
wire:loading.class="opacity-50"    {{-- Add class during loading --}}
wire:target="save"                 {{-- Target specific action --}}
```

### Wire Navigation
```blade
wire:key="item-{{ $id }}"          {{-- Unique key for tracking elements --}}
```

## Alpine.js Patterns

### Transitions
```blade
<div 
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
>
    {{-- Content with smooth fade/slide in --}}
</div>
```

### Toggle States
```blade
<div x-data="{ open: true }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open" x-transition>Content</div>
</div>
```

### Event Listening
```blade
<div 
    x-data="{ show: false }"
    @notify.window="show = true; setTimeout(() => show = false, 4000)"
>
    {{-- Listens for global 'notify' event --}}
</div>
```

## Routing Integration

### Update Routes (admin.php)

To use the new Livewire components, update your routes:

```php
// Dashboard
Route::get('/', function () {
    return view('admin.dashboard-new');
})->name('dashboard');

// Team Members
Route::get('/team', function () {
    return view('admin.team.index-livewire');
})->name('team.index');

Route::get('/team/create', function () {
    return view('admin.team.form-livewire', ['isEditMode' => false]);
})->name('team.create');

Route::get('/team/{id}/edit', function ($id) {
    return view('admin.team.form-livewire', [
        'isEditMode' => true,
        'memberId' => $id
    ]);
})->name('team.edit');

// Bookings
Route::get('/bookings', function () {
    return view('admin.bookings.index-livewire');
})->name('bookings.index');
```

## Performance Optimizations

### 1. Lazy Loading
```php
public function render()
{
    return view('livewire.component', [
        'items' => $this->items, // Only load when needed
    ]);
}
```

### 2. Debouncing
```blade
wire:model.live.debounce.300ms="search"
```

### 3. Pagination
```php
use Livewire\WithPagination;

public function render()
{
    return view('livewire.component', [
        'items' => Model::paginate(15),
    ]);
}
```

### 4. Polling (Optional)
```blade
<div wire:poll.60s="refresh">
    {{-- Auto-refresh every 60 seconds --}}
</div>
```

## Loading States

### Global Loading Indicator
```blade
<div wire:loading.delay class="fixed top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-full shadow-lg z-50">
    <span>Loading...</span>
</div>
```

### Action-Specific Loading
```blade
<button wire:click="save" wire:loading.attr="disabled">
    <span wire:loading.remove wire:target="save">Save</span>
    <span wire:loading wire:target="save">Saving...</span>
</button>
```

## Best Practices

### 1. Component Responsibility
- Keep components focused on a single purpose
- Use separate components for index and form views
- Avoid nesting Livewire components deeply

### 2. State Management
```php
// ✅ Good - Use public properties
public $search = '';

// ❌ Bad - Don't use session for component state
session(['search' => $value]);
```

### 3. Validation
```php
// Real-time validation
public function updated($propertyName)
{
    $this->validateOnly($propertyName);
}

// Batch validation on submit
public function save()
{
    $this->validate();
    // Save logic
}
```

### 4. Events
```php
// Dispatch events for inter-component communication
$this->dispatch('notify', message: 'Success');

// Listen in Alpine
@notify.window="handleNotification($event.detail)"
```

## Migration Checklist

- [x] Install Livewire (`composer require livewire/livewire`)
- [x] Add `@livewireStyles` to layout head
- [x] Add `@livewireScripts` before closing body tag
- [x] Create Livewire components
- [x] Create component views
- [x] Update routes to use new views
- [x] Add toast notification component
- [x] Test all CRUD operations
- [x] Verify loading states work
- [x] Check responsive design
- [ ] Update remaining modules (Services, FAQs, Articles, etc.)

## Extending the Architecture

### Creating New Components

1. **Generate Component:**
```bash
php artisan make:livewire Admin/YourModule/YourComponent
```

2. **Add CRUD Pattern:**
```php
use Livewire\Component;
use Livewire\WithPagination;

class YourComponent extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    public function render()
    {
        return view('livewire.admin.your-module.your-component');
    }
}
```

3. **Create View with Alpine:**
```blade
<div>
    {{-- Search/Filters --}}
    <input wire:model.live.debounce.300ms="search" />
    
    {{-- Content with loading states --}}
    <div wire:loading.class="opacity-50">
        {{-- Your content --}}
    </div>
</div>
```

## Troubleshooting

### Issue: Component not updating
**Solution:** Check if properties are public and wire:model is correctly spelled

### Issue: Alpine transitions not working
**Solution:** Ensure AlpineJS is loaded and x-data is defined

### Issue: File upload not working
**Solution:** Verify `WithFileUploads` trait is used and form has `enctype="multipart/form-data"`

### Issue: Events not firing
**Solution:** Check event names match exactly (case-sensitive)

## Resources

- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/start-here)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

## Support

For questions or issues related to this refactoring, refer to:
- Project documentation in `/docs`
- Laravel Livewire community forums
- Project repository issues
