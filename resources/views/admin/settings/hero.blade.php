@extends('admin.layouts.app')
    
@section('title', 'Hero Section Settings')
@section('page-title', 'Hero Section Settings')
@section('page-description', 'Customize the homepage hero section appearance')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Hero Section Settings</h1>
    <p class="text-gray-600 mt-2">Customize the homepage hero section appearance</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.settings.hero.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="background_image" class="block text-sm font-medium text-gray-700 mb-2">Background Image</label>
            @if(isset($settings['hero.background_image']) && $settings['hero.background_image'])
            <div class="mb-3">
                <img src="{{ asset('storage/' . $settings['hero.background_image']) }}" alt="Current Hero Background" class="w-full max-w-md h-48 object-cover rounded-lg">
                <p class="text-sm text-gray-500 mt-1">Current background image</p>
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

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Save Hero Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-6">
    <h3 class="text-lg font-semibold text-blue-900 mb-2">💡 Tips</h3>
    <ul class="list-disc list-inside text-blue-800 space-y-1">
        <li>Use high-quality images that represent your business well</li>
        <li>Ensure the image has good contrast with white text</li>
        <li>The image will be displayed with 30% opacity over the blue gradient</li>
        <li>Test different alignments to see what works best with your image</li>
    </ul>
</div>
@endsection
