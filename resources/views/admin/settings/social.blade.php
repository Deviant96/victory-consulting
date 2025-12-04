@extends('admin.layouts.app')
    
@section('title', 'Social Media Settings')
@section('page-title', 'Social Media Settings')
@section('page-description', 'Manage your social media links.')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Social Media Settings</h1>
    <p class="text-gray-600 mt-2">Manage your social media links</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.settings.social.update') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label for="social_facebook" class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
            <input type="url" name="social[facebook]" id="social_facebook" value="{{ old('social.facebook', $settings['social.facebook'] ?? '') }}" placeholder="https://facebook.com/yourpage" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('social.facebook')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="social_twitter" class="block text-sm font-medium text-gray-700 mb-2">Twitter/X URL</label>
            <input type="url" name="social[twitter]" id="social_twitter" value="{{ old('social.twitter', $settings['social.twitter'] ?? '') }}" placeholder="https://twitter.com/yourhandle" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('social.twitter')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="social_linkedin" class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
            <input type="url" name="social[linkedin]" id="social_linkedin" value="{{ old('social.linkedin', $settings['social.linkedin'] ?? '') }}" placeholder="https://linkedin.com/company/yourcompany" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('social.linkedin')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="social_instagram" class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
            <input type="url" name="social[instagram]" id="social_instagram" value="{{ old('social.instagram', $settings['social.instagram'] ?? '') }}" placeholder="https://instagram.com/yourprofile" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('social.instagram')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Save Social Settings
            </button>
        </div>
    </form>
</div>
@endsection
