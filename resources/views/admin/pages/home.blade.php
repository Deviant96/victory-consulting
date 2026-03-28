@extends('admin.layouts.app')
    
@section('title', 'Home Page Settings')
@section('page-title', 'Home Page Settings')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Home Page Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Manage the first impression of your website: Hero, Services, and Key Sections.</p>
        </div>
        <div class="flex items-center gap-3">
             <a href="{{ route('admin.settings.branding') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                Branding Settings
            </a>
            <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Live Site
            </a>
        </div>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    <form action="{{ route('admin.pages.home.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf

        <!-- Main Settings Area -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Hero Section Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">Hero Section</h2>
                    <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Above the Fold</span>
                </div>
                <div class="p-6 space-y-6">
                    
                    <!-- Background Image -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700">Background Image</label>
                        
                        <!-- Current & Preview -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if(isset($settings['hero.background_image']) && optional($settings['hero.background_image'])->value)
                                <div class="relative group rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                                    <img src="{{ asset('storage/' . $settings['hero.background_image']->value) }}" alt="Current Hero" class="w-full h-40 object-cover">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-white font-medium text-sm">Current Image</span>
                                    </div>
                                </div>
                            @else
                                <div class="w-full h-40 bg-gray-100 rounded-xl border-dashed border-2 border-gray-300 flex items-center justify-center text-gray-400">
                                    No image set
                                </div>
                            @endif

                            <div id="hero-preview-container" class="hidden relative group rounded-xl overflow-hidden border-2 border-blue-500 shadow-md transition-all duration-300">
                                <img id="hero-preview" src="" alt="New Preview" class="w-full h-40 object-cover">
                                <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-white font-medium text-sm mb-2">New Selection</span>
                                    <button type="button" id="clear-hero-btn" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-semibold shadow transition">
                                        Clear Selection
                                    </button>
                                </div>
                                <div class="absolute top-2 right-2 bg-blue-500 text-white px-2 py-0.5 rounded text-xs font-semibold shadow">New</div>
                            </div>
                        </div>

                        <!-- File Input -->
                        <div class="relative">
                            <input type="file" name="hero_image" id="hero_image" accept="image/*" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-xl file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                                transition cursor-pointer
                            "/>
                        </div>
                        <p class="text-xs text-gray-500">Recommended: 1920x600px or larger, max 4MB. High quality is essential.</p>
                    </div>

                    <div class="border-t border-gray-100 my-6"></div>

                    <!-- Alignment & Buttons -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                             <label for="text_alignment" class="block text-sm font-medium text-gray-700 mb-2">Text Alignment</label>
                            <select name="hero[text_alignment]" id="text_alignment" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="left" {{ (old('hero.text_alignment', optional($settings->get('hero.text_alignment'))->value ?? 'center') === 'left') ? 'selected' : '' }}>Left</option>
                                <option value="center" {{ (old('hero.text_alignment', optional($settings->get('hero.text_alignment'))->value ?? 'center') === 'center') ? 'selected' : '' }}>Center</option>
                                <option value="right" {{ (old('hero.text_alignment', optional($settings->get('hero.text_alignment'))->value ?? 'center') === 'right') ? 'selected' : '' }}>Right</option>
                            </select>
                        </div>
                        <div>
                            <!-- Placeholder for balance -->
                        </div>
                    </div>

                    <!-- Buttons Sections -->
                    <div class="space-y-4 pt-4">
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Primary Call to Action</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-admin.settings-field-with-translation
                                name="hero[primary_button_text]"
                                label="Button Text"
                                value="Start Your Journey"
                                :settings="$settings"
                                :languages="$languages"
                            />
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Button URL</label>
                                <input
                                    type="text"
                                    name="hero[primary_button_url]"
                                    value="{{ old('hero.primary_button_url', optional($settings->get('hero.primary_button_url'))->value ?? route('contact')) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                                    placeholder="/contact"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Secondary Button Toggle -->
                    <div x-data="{ secondaryEnabled: {{ old('hero.secondary_button_enabled', optional($settings->get('hero.secondary_button_enabled'))->value ?? '1') == '1' ? 'true' : 'false' }} }" class="pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Secondary Button</h3>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="hero[secondary_button_enabled]" value="0">
                                <input type="checkbox" name="hero[secondary_button_enabled]" value="1" class="sr-only peer" x-model="secondaryEnabled">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-700" x-text="secondaryEnabled ? 'Enabled' : 'Disabled'"></span>
                            </label>
                        </div>

                        <div x-show="secondaryEnabled" x-transition.opacity class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                             <x-admin.settings-field-with-translation
                                name="hero[secondary_button_text]"
                                label="Button Text"
                                value="Explore Services"
                                :settings="$settings"
                                :languages="$languages"
                            />
                             <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Button URL</label>
                                <input
                                    type="text"
                                    name="hero[secondary_button_url]"
                                    value="{{ old('hero.secondary_button_url', optional($settings->get('hero.secondary_button_url'))->value ?? route('services.index')) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                                    placeholder="/services"
                                >
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Content Sections Container -->
            <div class="grid grid-cols-1 gap-6">
                
                <!-- Services Section -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Services Intro Loop</h2>
                    </div>
                    <div class="p-6 space-y-6">
                         <x-admin.settings-field-with-translation
                            name="home[services_title]"
                            label="Section Title"
                            value="Our Services"
                            :settings="$settings"
                            :languages="$languages"
                        />
                        <x-admin.settings-field-with-translation
                            name="home[services_description]"
                            label="Description"
                            type="textarea"
                            rows="2"
                            value="Comprehensive business solutions tailored to your unique challenges"
                            :settings="$settings"
                            :languages="$languages"
                        />
                        <div class="bg-blue-50 text-blue-800 text-xs px-4 py-3 rounded-lg flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            This section will display the featured services automatically.
                        </div>
                    </div>
                </div>

                <!-- Business Solutions Section -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Business Solutions Section</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <x-admin.settings-field-with-translation
                            name="home[business_solutions_title]"
                            label="Section Title"
                            value="Whatever Your Business, We Can Handle It"
                            :settings="$settings"
                            :languages="$languages"
                        />

                        <x-admin.settings-field-with-translation
                            name="home[business_solutions_description]"
                            label="Description"
                            type="textarea"
                            rows="2"
                            value="From startups to enterprises, we provide tailored solutions for every industry and challenge"
                            :settings="$settings"
                            :languages="$languages"
                        />

                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Section Image</label>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if(optional($settings->get('home.business_solutions_image'))->value)
                                    <div class="relative group rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                                        <img src="{{ asset('storage/' . $settings->get('home.business_solutions_image')->value) }}" alt="Current Business Solutions" class="w-full h-40 object-cover">
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span class="text-white font-medium text-sm">Current Image</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-full h-40 bg-gray-100 rounded-xl border-dashed border-2 border-gray-300 flex items-center justify-center text-gray-400">
                                        No image set
                                    </div>
                                @endif

                                <div id="business-solutions-preview-container" class="hidden relative group rounded-xl overflow-hidden border-2 border-blue-500 shadow-md transition-all duration-300">
                                    <img id="business-solutions-preview" src="" alt="New Preview" class="w-full h-40 object-cover">
                                    <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-white font-medium text-sm mb-2">New Selection</span>
                                        <button type="button" id="clear-business-solutions-btn" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-semibold shadow transition">
                                            Clear Selection
                                        </button>
                                    </div>
                                    <div class="absolute top-2 right-2 bg-blue-500 text-white px-2 py-0.5 rounded text-xs font-semibold shadow">New</div>
                                </div>
                            </div>

                            <div class="relative">
                                <input type="file" name="business_solutions_image" id="business_solutions_image" accept="image/*" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2.5 file:px-4
                                    file:rounded-xl file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100
                                    transition cursor-pointer
                                "/>
                            </div>
                            <p class="text-xs text-gray-500">Recommended: 1200x800px or larger, max 4MB.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-admin.settings-field-with-translation
                                name="home[business_solutions_button_text]"
                                label="Button Text"
                                value="Explore Industries"
                                :settings="$settings"
                                :languages="$languages"
                            />
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Button URL</label>
                                <input
                                    type="text"
                                    name="home[business_solutions_button_url]"
                                    value="{{ old('home.business_solutions_button_url', optional($settings->get('home.business_solutions_button_url'))->value ?? route('industries.index')) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                                    placeholder="/industries"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Why Choose Us -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Why Choose Us</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <x-admin.settings-field-with-translation
                            name="home[why_choose_title]"
                            label="Section Title"
                            value="Why Choose Victory Business Consulting"
                            :settings="$settings"
                            :languages="$languages"
                        />
                        <x-admin.settings-field-with-translation
                            name="home[why_choose_description]"
                            label="Description"
                            type="textarea"
                            rows="2"
                            value="Discover what sets us apart and makes us the ideal partner for your business growth"
                            :settings="$settings"
                            :languages="$languages"
                        />
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end pt-4">
                 <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Save Changes
                </button>
            </div>
        </div>

        <!-- Sidebar Settings -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Quick Links -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Content Shortcuts</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.services.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 border border-gray-100 transition group">
                        <div class="p-2 bg-purple-100 text-purple-600 rounded-lg group-hover:bg-purple-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Manage Services</p>
                            <p class="text-xs text-gray-500">Edit individual service content</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.settings.branding') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 border border-gray-100 transition group">
                        <div class="p-2 bg-pink-100 text-pink-600 rounded-lg group-hover:bg-pink-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Brand Identity</p>
                            <p class="text-xs text-gray-500">Logo, Title & Tagline</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-bold text-lg mb-2">Homepage Preview</h3>
                    <p class="text-blue-100 text-sm mb-4">Your homepage is the digital face of your business. Ensure it makes a splash.</p>
                    <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 border border-white/40 rounded-lg text-sm font-medium transition backdrop-blur-sm">
                        Visit Homepage <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
                <svg class="absolute -bottom-6 -right-6 w-32 h-32 text-white/10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/><path d="M9 12a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"/><path fill-rule="evenodd" d="M9 10a1 1 0 011-1h4a1 1 0 110 2h-4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
            </div>

            <!-- Pro Tips -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    Hero Image Guide
                </h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Use a high-resolution image (min 1920px width).</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Ensure texts remain readable with the overlay.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Avoid busy images that distract from the CTA.</span>
                    </li>
                </ul>
            </div>

        </div>
    </form>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupImagePreview(inputId, previewContainerId, previewImageId, clearButtonId) {
        const input = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewContainerId);
        const previewImage = document.getElementById(previewImageId);
        const clearButton = document.getElementById(clearButtonId);

        if (!input || !previewContainer || !previewImage || !clearButton) {
            return;
        }

        input.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                if (file.size > 4 * 1024 * 1024) {
                    alert('File size must be less than 4MB');
                    input.value = '';
                    previewContainer.classList.add('hidden');
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    input.value = '';
                    previewContainer.classList.add('hidden');
                    return;
                }

                const reader = new FileReader();

                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                    previewContainer.classList.add('flex'); // Ensure flex is working for centering if needed
                };

                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        });

        clearButton.addEventListener('click', function() {
            input.value = '';
            previewContainer.classList.add('hidden');
            previewImage.src = '';
        });
    }

    setupImagePreview('hero_image', 'hero-preview-container', 'hero-preview', 'clear-hero-btn');
    setupImagePreview('business_solutions_image', 'business-solutions-preview-container', 'business-solutions-preview', 'clear-business-solutions-btn');
});
</script>
@endsection