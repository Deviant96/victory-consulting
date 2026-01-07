@extends('admin.layouts.app')
    
@section('title', 'Services Page Settings')
@section('page-title', 'Services Page Settings')
@section('page-description', 'Manage content for the Services Page')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Services Page Settings</h1>
    <p class="text-gray-600 mt-2">Manage header and description for the Services Page</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.pages.services.update') }}" method="POST">
        @csrf

        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Header Content</h2>
            <div class="mb-4">
                 <label for="page_title" class="block text-sm font-medium text-gray-700 mb-2">Page Title</label>
                 <input type="text" name="services[page_title]" id="page_title" value="{{ old('services.page_title', $settings['services.page_title'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            </div>
             <div class="mb-4">
                 <label for="page_description" class="block text-sm font-medium text-gray-700 mb-2">Page Description</label>
                 <textarea name="services[page_description]" id="page_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">{{ old('services.page_description', $settings['services.page_description'] ?? '') }}</textarea>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Save Services Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
