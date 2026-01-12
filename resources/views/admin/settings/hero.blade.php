@extends('admin.layouts.app')
    
@section('title', 'Hero Section Settings')
@section('page-title', 'Hero Section Settings')
@section('page-description', 'Customize hero section images and appearance')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Hero Section Settings</h1>
    <p class="text-gray-600 mt-2">Customize hero section images and appearance for different pages</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.settings.hero.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Homepage Hero Section -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Homepage Hero</h2>
            
            <div class="mb-6">
                <label for="background_image" class="block text-sm font-medium text-gray-700 mb-2">Background Image</label>
                @if(isset($settings['hero.background_image']) && $settings['hero.background_image'])
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings['hero.background_image']) }}" alt="Current Hero Background" class="w-full max-w-2xl h-56 object-cover rounded-lg shadow-md">
                    <p class="text-sm text-gray-500 mt-1">Current homepage background image</p>
                </div>
                @endif
                <input type="file" name="background_image" id="background_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                @error('background_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Recommended: 1920x600px or larger, max 4MB. Leave empty to use gradient background only.</p>
            </div>

            <div class="mb-6">
                <label for="text_alignment" class="block text-sm font-medium text-gray-700 mb-2">Text Alignment</label>
                <select name="text_alignment" id="text_alignment" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                    <option value="left" {{ old('text_alignment', $settings['hero.text_alignment'] ?? 'center') === 'left' ? 'selected' : '' }}>Left</option>
                    <option value="center" {{ old('text_alignment', $settings['hero.text_alignment'] ?? 'center') === 'center' ? 'selected' : '' }}>Center</option>
                    <option value="right" {{ old('text_alignment', $settings['hero.text_alignment'] ?? 'center') === 'right' ? 'selected' : '' }}>Right</option>
                </select>
                @error('text_alignment')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Choose how to align the hero section text content</p>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Hero Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-6">
    <h3 class="text-lg font-semibold text-blue-900 mb-3">
        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        Image Guidelines
    </h3>
    <ul class="list-disc list-inside text-blue-800 space-y-1 text-sm">
        <li>Use high-quality images that represent your business</li>
        <li>Ensure good contrast with white text overlay</li>
        <li>Image displays with 30% opacity over gradient</li>
        <li>Test different text alignments with your image</li>
    </ul>
</div>
@endsection
