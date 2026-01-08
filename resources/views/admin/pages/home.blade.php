@extends('admin.layouts.app')
    
@section('title', 'Home Page Settings')
@section('page-title', 'Home Page Settings')
@section('page-description', 'Manage content for the Home Page including Hero and all sections')

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
                @if(isset($settings['hero.background_image']) && optional($settings['hero.background_image'])->value)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings['hero.background_image']->value) }}" alt="Current Hero Background" class="w-full max-w-2xl h-56 object-cover rounded-lg shadow-md">
                    <p class="text-sm text-gray-500 mt-1">Current hero image</p>
                </div>
                @endif
                <input type="file" name="hero_image" id="hero_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                <p class="text-gray-500 text-sm mt-1">Recommended: 1920x600px or larger, max 4MB.</p>
            </div>

             <div class="mb-6">
                <label for="text_alignment" class="block text-sm font-medium text-gray-700 mb-2">Text Alignment</label>
                <select name="hero[text_alignment]" id="text_alignment" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                    <option value="left" {{ (old('hero.text_alignment', optional($settings['hero.text_alignment'])->value ?? 'center') === 'left') ? 'selected' : '' }}>Left</option>
                    <option value="center" {{ (old('hero.text_alignment', optional($settings['hero.text_alignment'])->value ?? 'center') === 'center') ? 'selected' : '' }}>Center</option>
                    <option value="right" {{ (old('hero.text_alignment', optional($settings['hero.text_alignment'])->value ?? 'center') === 'right') ? 'selected' : '' }}>Right</option>
                </select>
            </div>
        </div>

        <!-- Services Section -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Services Section</h2>
            
            <x-admin.settings-field-with-translation
                name="home[services_title]"
                label="Section Title"
                value="Our Services"
                :settings="$settings"
                :languages="$languages"
            />

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="home[services_description]"
                    label="Description"
                    type="textarea"
                    rows="3"
                    value="Comprehensive business solutions tailored to your unique challenges"
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>

             <div class="mt-4">
                 <p class="text-sm text-gray-500">
                     The individual services are managed in the <a href="{{ route('admin.services.index') }}" class="text-blue-600 hover:underline">Services Management</a> page.
                 </p>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Why Choose Us Section</h2>
            
            <x-admin.settings-field-with-translation
                name="home[why_choose_title]"
                label="Section Title"
                value="Why Choose Victory Business Consulting"
                :settings="$settings"
                :languages="$languages"
            />

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="home[why_choose_description]"
                    label="Description"
                    type="textarea"
                    rows="3"
                    value="Discover what sets us apart and makes us the ideal partner for your business growth"
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>

             <div class="mt-4">
                 <p class="text-sm text-gray-500">
                     The individual items are managed in the <a href="{{ route('admin.why-choose-items.index') }}" class="text-blue-600 hover:underline">Why Choose Us Management</a> page.
                 </p>
            </div>
        </div>

        <!-- Business Solutions Section -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Business Solutions Section</h2>
            
            <x-admin.settings-field-with-translation
                name="home[business_solutions_title]"
                label="Section Title"
                value="Whatever Your Business, We Can Handle It"
                :settings="$settings"
                :languages="$languages"
            />

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="home[business_solutions_description]"
                    label="Description"
                    type="textarea"
                    rows="3"
                    value="From startups to enterprises, we provide tailored solutions for every industry and challenge"
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>

             <div class="mt-4">
                 <p class="text-sm text-gray-500">
                     The individual solutions are managed in the <a href="{{ route('admin.business-solutions.index') }}" class="text-blue-600 hover:underline">Business Solutions Management</a> page.
                 </p>
            </div>
        </div>

        <!-- Blog Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Blog Section</h2>
            
            <x-admin.settings-field-with-translation
                name="home[blog_title]"
                label="Section Title"
                value="Latest Insights"
                :settings="$settings"
                :languages="$languages"
            />

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="home[blog_description]"
                    label="Description"
                    type="textarea"
                    rows="2"
                    value="Expert perspectives on business strategy and growth."
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="home[blog_button_text]"
                    label="Button Text"
                    value="Read More Articles"
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>

             <div class="mt-4">
                 <p class="text-sm text-gray-500">
                     The blog articles are managed in the <a href="{{ route('admin.articles.index') }}" class="text-blue-600 hover:underline">Articles Management</a> page.
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
