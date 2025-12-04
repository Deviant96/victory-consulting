@extends('admin.layouts.app')
    
@section('title', 'Branding Settings')
@section('page-title', 'Branding Settings')
@section('page-description', 'Manage your logo, favicon, and tagline')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Branding Settings</h1>
    <p class="text-gray-600 mt-2">Manage your logo, favicon, and tagline</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.settings.branding.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="branding_logo" class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
            @if(isset($settings['branding.logo']) && $settings['branding.logo'])
            <div class="mb-2">
                <img src="{{ asset('storage/' . $settings['branding.logo']) }}" alt="Current Logo" class="h-16 object-contain">
                <p class="text-sm text-gray-500 mt-1">Current logo</p>
            </div>
            @endif
            <input type="file" name="logo" id="branding_logo" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('logo')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Recommended: PNG with transparent background, max 2MB</p>
        </div>

        <div class="mb-6">
            <label for="branding_favicon" class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
            @if(isset($settings['branding.favicon']) && $settings['branding.favicon'])
            <div class="mb-2">
                <img src="{{ asset('storage/' . $settings['branding.favicon']) }}" alt="Current Favicon" class="h-8 w-8 object-contain">
                <p class="text-sm text-gray-500 mt-1">Current favicon</p>
            </div>
            @endif
            <input type="file" name="favicon" id="branding_favicon" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('favicon')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Recommended: 32x32px or 64x64px square image, max 1MB</p>
        </div>

        <div class="mb-6">
            <label for="site_tagline" class="block text-sm font-medium text-gray-700 mb-2">Site Tagline</label>
            <input type="text" name="tagline" id="site_tagline" value="{{ old('tagline', $settings['site.tagline'] ?? '') }}" placeholder="Your company tagline or slogan" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('tagline')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Save Branding Settings
            </button>
        </div>
    </form>
</div>
@endsection
