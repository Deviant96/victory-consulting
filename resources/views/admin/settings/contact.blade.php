@extends('admin.layouts.app')
    
@section('title', 'Contact Settings')
@section('page-title', 'Contact Settings')
@section('page-description', 'Manage your business contact information')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Contact Settings</h1>
    <p class="text-gray-600 mt-2">Manage your business contact information</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.settings.contact.update') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label for="site_email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
            <input type="email" name="site[email]" id="site_email" value="{{ old('site.email', $settings['site.email'] ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('site.email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="site_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
            <input type="tel" name="site[phone]" id="site_phone" value="{{ old('site.phone', $settings['site.phone'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('site.phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="site_address" class="block text-sm font-medium text-gray-700 mb-2">Physical Address</label>
            <textarea name="site[address]" id="site_address" rows="5" wrap="soft" style="white-space: pre-wrap;" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 resize-y">{{ old('site.address', $settings['site.address'] ?? '') }}</textarea>
            @error('site.address')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Save Contact Settings
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('site_address');
    if (textarea) {
        // Ensure textarea accepts newlines
        textarea.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey && !e.ctrlKey && !e.altKey) {
                e.stopPropagation();
                // Let the default behavior happen (insert newline)
            }
        });
    }
});
</script>
@endpush
@endsection
