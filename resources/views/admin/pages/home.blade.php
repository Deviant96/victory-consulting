@extends('admin.layouts.app')
    
@section('title', 'Home Page Settings')
@section('page-title', 'Home Page Settings')
@section('page-description', 'Manage content for the Home Page including Hero and Services')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Home Page Settings</h1>
    <p class="text-gray-600 mt-2">Manage content sections for the Home Page</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.pages.home.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Hero Section -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Hero Section</h2>
            <p class="text-gray-600 mb-4">
                The hero text (Title and Tagline) is managed in the 
                <a href="{{ route('admin.settings.branding') }}" class="text-blue-600 hover:underline">Branding Settings</a>.
            </p>
            
            <div class="mb-6">
                <label for="hero_image" class="block text-sm font-medium text-gray-700 mb-2">Background Image</label>
                @if(isset($settings['hero.background_image']) && $settings['hero.background_image'])
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings['hero.background_image']) }}" alt="Current Hero Background" class="w-full max-w-2xl h-56 object-cover rounded-lg shadow-md">
                    <p class="text-sm text-gray-500 mt-1">Current hero image</p>
                </div>
                @endif
                <input type="file" name="hero_image" id="hero_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                <p class="text-gray-500 text-sm mt-1">Recommended: 1920x600px or larger, max 4MB.</p>
            </div>

             <div class="mb-6">
                <label for="text_alignment" class="block text-sm font-medium text-gray-700 mb-2">Text Alignment</label>
                <select name="hero[text_alignment]" id="text_alignment" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                    <option value="left" {{ (old('hero.text_alignment', $settings['hero.text_alignment'] ?? 'center') === 'left') ? 'selected' : '' }}>Left</option>
                    <option value="center" {{ (old('hero.text_alignment', $settings['hero.text_alignment'] ?? 'center') === 'center') ? 'selected' : '' }}>Center</option>
                    <option value="right" {{ (old('hero.text_alignment', $settings['hero.text_alignment'] ?? 'center') === 'right') ? 'selected' : '' }}>Right</option>
                </select>
            </div>
        </div>

        <!-- Services Section -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Services Section</h2>
            <div class="mb-4">
                 <label for="services_title" class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                 <input type="text" name="home[services_title]" id="services_title" value="{{ old('home.services_title', $settings['home.services_title'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            </div>
             <div class="mb-4">
                 <label for="services_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                 <textarea name="home[services_description]" id="services_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">{{ old('home.services_description', $settings['home.services_description'] ?? '') }}</textarea>
            </div>
             <div class="mt-2">
                 <p class="text-sm text-gray-500">
                     The individual services are managed in the <a href="{{ route('admin.services.index') }}" class="text-blue-600 hover:underline">Services Management</a> page.
                 </p>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Save Home Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
