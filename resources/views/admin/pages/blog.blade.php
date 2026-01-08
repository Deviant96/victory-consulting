@extends('admin.layouts.app')
    
@section('title', 'Blog Page Settings')
@section('page-title', 'Blog Page Settings')
@section('page-description', 'Manage content for the Blog Page')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Blog Page Settings</h1>
    <p class="text-gray-600 mt-2">Manage header, filters, and CTA content for the Blog Page</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.pages.blog.update') }}" method="POST">
        @csrf

        <!-- Header Content -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Header Content</h2>
            
            <x-admin.settings-field-with-translation
                name="blog[page_title]"
                label="Page Title"
                value="Our Blog"
                :settings="$settings"
                :languages="$languages"
            />

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="blog[page_description]"
                    label="Page Description"
                    type="textarea"
                    rows="2"
                    value="Insights, strategies, and expert perspectives on business growth and success"
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>
        </div>

        <!-- Filter Settings -->
        <div class="mb-8 pb-8 border-b border-gray-200 bg-blue-50 p-6 rounded-lg">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filter Settings
            </h2>
            
            <div class="space-y-4">
                <div class="flex items-center gap-3 bg-white p-4 rounded-lg">
                    <input type="hidden" name="blog[enable_filters]" value="0">
                    <input type="checkbox" name="blog[enable_filters]" id="enable_filters" value="1" 
                        {{ old('blog.enable_filters', optional($settings->get('blog.enable_filters'))->value ?? '1') == '1' ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                    <label for="enable_filters" class="text-sm font-medium text-gray-700 cursor-pointer">
                        Enable filter sidebar on blog page
                    </label>
                </div>
                <p class="text-sm text-gray-500 ml-4">
                    When enabled, visitors can filter blog posts by search, category, date range, and sort order. When disabled, only the blog posts grid will be displayed.
                </p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Call to Action Section</h2>
            
            <x-admin.settings-field-with-translation
                name="blog[cta_title]"
                label="CTA Title"
                value="Stay Updated"
                :settings="$settings"
                :languages="$languages"
            />

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="blog[cta_description]"
                    label="CTA Description"
                    type="textarea"
                    rows="2"
                    value="Subscribe to our newsletter for the latest insights and business strategies"
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="blog[cta_button]"
                    label="CTA Button Text"
                    value="Subscribe"
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Save Blog Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
