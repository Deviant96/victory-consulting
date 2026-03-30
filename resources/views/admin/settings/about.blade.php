@extends('admin.layouts.app')

@section('title', 'About Us Page Settings')
@section('page-title', 'About Us Page')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">About Us Page Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Tell your company's story, vision, and mission.</p>
        </div>
        <div class="flex items-center gap-3">
             <a href="{{ route('admin.team.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Manage Team
            </a>
            <a href="{{ url('/about') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Live Page
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

    <form action="{{ route('admin.pages.about.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf

        <!-- Main Settings Area -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Header Content Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">Header Content</h2>
                    <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Hero Section</span>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <x-admin.settings-field-with-translation
                            name="about[header_title]"
                            label="Page Title"
                            value="About Us"
                            :settings="$settings"
                            :languages="$languages"
                            required="true"
                        />
                        <x-admin.settings-field-with-translation
                            name="about[hero_tagline]"
                            label="Hero Tagline"
                            value="Trusted Finance & Business Advisory"
                            :settings="$settings"
                            :languages="$languages"
                        />
                    </div>

                    <x-admin.settings-field-with-translation
                        name="about[header_description]"
                        label="Header Description"
                        type="textarea"
                        rows="2"
                        value=""
                        :settings="$settings"
                        :languages="$languages"
                    />

                    <!-- Hero Image -->
                    <div class="border-t border-gray-100 pt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-4">Hero Image</label>
                        <div class="space-y-4">
                            <!-- Current Image -->
                            @if(optional($settings->get('about.hero_image'))->value)
                                <div class="relative group rounded-xl overflow-hidden border border-gray-200 shadow-sm w-full max-w-sm">
                                    <img src="{{ asset('storage/' . $settings->get('about.hero_image')->value) }}" alt="Current Hero" class="w-full h-40 object-cover">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-white font-medium text-sm">Current Image</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Preview Container -->
                            <div id="hero-preview-container" class="hidden relative group rounded-xl overflow-hidden border-2 border-blue-500 shadow-md transition-all duration-300 w-full max-w-sm">
                                <img id="hero-preview" src="" alt="New Preview" class="w-full h-40 object-cover">
                                <button type="button" id="clear-hero-btn" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white p-1 rounded-full shadow transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <input type="file" name="hero_image" id="hero_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer"/>
                            <p class="text-xs text-gray-500">Recommended: Executive consultation in a boardroom.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Story Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Our Story</h2>
                </div>
                <div class="p-6 space-y-6">
                    <x-admin.settings-field-with-translation
                        name="about[story_heading]"
                        label="Heading"
                        value="Our Story"
                        :settings="$settings"
                        :languages="$languages"
                    />
                    
                    <x-admin.settings-field-with-translation
                        name="about[content]"
                        label="Main Content"
                        type="textarea"
                        rows="8"
                        value=""
                        required="true"
                        :settings="$settings"
                        :languages="$languages"
                    />

                    <!-- Story Image -->
                    <div class="border-t border-gray-100 pt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-4">Story Image</label>
                        <div class="flex flex-col gap-4">
                            <div class="flex gap-6 items-start">
                                @if(optional($settings->get('about.story_image'))->value)
                                    <div class="shrink-0 relative group">
                                        <img src="{{ asset('storage/' . $settings->get('about.story_image')->value) }}" alt="Story" class="w-32 h-20 object-cover rounded-lg border border-gray-200">
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center rounded-lg pointer-events-none">
                                            <span class="text-white text-xs font-medium">Current</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Preview Container -->
                                <div id="story-preview-container" class="hidden shrink-0 relative group rounded-lg overflow-hidden border-2 border-blue-500 shadow-md w-32 h-20">
                                    <img id="story-preview" src="" alt="Preview" class="w-full h-full object-cover">
                                    <button type="button" id="clear-story-btn" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white w-6 h-6 flex items-center justify-center rounded-full shadow transition text-xs leading-none pb-0.5 z-10">
                                        &times;
                                    </button>
                                </div>
                            </div>

                            <div class="w-full">
                                <input type="file" name="story_image" id="story_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer"/>
                                <p class="text-xs text-gray-500 mt-2">Appears alongside the story content.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vision & Mission Card -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Vision -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
                        <h2 class="text-lg font-medium text-blue-900 flex items-center">Vision</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <x-admin.settings-field-with-translation name="about[vision_title]" label="Title" value="Our Vision" :settings="$settings" :languages="$languages"/>
                        <x-admin.settings-field-with-translation name="about[vision_content]" label="Content" type="textarea" rows="4" value="" :settings="$settings" :languages="$languages"/>
                        
                         <div class="pt-2">
                            <label class="block text-xs font-medium text-gray-600 mb-2">Image</label>
                            @if(optional($settings->get('about.vision_image'))->value)
                                <img src="{{ asset('storage/' . $settings->get('about.vision_image')->value) }}" alt="Vision" class="w-full h-32 object-cover rounded-lg border border-gray-200 mb-2">
                            @endif

                            <!-- Preview Container -->
                            <div id="vision-preview-container" class="hidden relative group rounded-lg overflow-hidden border-2 border-blue-500 shadow-md w-full h-32 mb-2">
                                <img id="vision-preview" src="" alt="Preview" class="w-full h-full object-cover">
                                <button type="button" id="clear-vision-btn" class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white w-5 h-5 flex items-center justify-center rounded-full shadow transition text-xs leading-none pb-0.5">
                                    &times;
                                </button>
                            </div>

                            <input type="file" name="vision_image" id="vision_image" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition"/>
                        </div>
                    </div>
                </div>

                <!-- Mission -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-green-50 px-6 py-4 border-b border-green-100">
                        <h2 class="text-lg font-medium text-green-900 flex items-center">Mission</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <x-admin.settings-field-with-translation name="about[mission_title]" label="Title" value="Our Mission" :settings="$settings" :languages="$languages"/>
                        <x-admin.settings-field-with-translation name="about[mission_content]" label="Content" type="textarea" rows="4" value="" :settings="$settings" :languages="$languages"/>
                        
                        <div class="pt-2">
                            <label class="block text-xs font-medium text-gray-600 mb-2">Image</label>
                            @if(optional($settings->get('about.mission_image'))->value)
                                <img src="{{ asset('storage/' . $settings->get('about.mission_image')->value) }}" alt="Mission" class="w-full h-32 object-cover rounded-lg border border-gray-200 mb-2">
                            @endif

                             <!-- Preview Container -->
                            <div id="mission-preview-container" class="hidden relative group rounded-lg overflow-hidden border-2 border-green-500 shadow-md w-full h-32 mb-2">
                                <img id="mission-preview" src="" alt="Preview" class="w-full h-full object-cover">
                                <button type="button" id="clear-mission-btn" class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white w-5 h-5 flex items-center justify-center rounded-full shadow transition text-xs leading-none pb-0.5">
                                    &times;
                                </button>
                            </div>

                            <input type="file" name="mission_image" id="mission_image" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition"/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">Bottom Call to Action</h2>
                </div>
                <div class="p-6 space-y-6">
                    <x-admin.settings-field-with-translation name="about[cta_heading]" label="Heading" value="Ready to Transform?" :settings="$settings" :languages="$languages"/>
                    <x-admin.settings-field-with-translation name="about[cta_description]" label="Description" type="textarea" rows="2" value="" :settings="$settings" :languages="$languages"/>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <x-admin.settings-field-with-translation name="about[cta_primary_button]" label="Primary Button" value="Get in Touch" :settings="$settings" :languages="$languages"/>
                        <x-admin.settings-field-with-translation name="about[cta_secondary_button]" label="Secondary Button" value="Explore Services" :settings="$settings" :languages="$languages"/>
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
            <!-- Preview Card -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-bold text-lg mb-2">About Page Preview</h3>
                    <p class="text-indigo-100 text-sm mb-4">Check how your story and values are presented to the world.</p>
                    <a href="{{ url('/about') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 border border-white/40 rounded-lg text-sm font-medium transition backdrop-blur-sm">
                        View About Page <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
                <svg class="absolute -bottom-6 -right-6 w-32 h-32 text-white/10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            </div>

            <!-- Management Links -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Related Content</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.team.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 border border-gray-100 transition group">
                        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg group-hover:bg-blue-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Manage Team</p>
                            <p class="text-xs text-gray-500">Edit team members & profiles</p>
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

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    Pro Tip
                </h3>
                <p class="text-sm text-gray-600 mb-2">
                    Stories connect people. Your "Our Story" section shouldn't just be a timeline—make it a narrative about why you exist and who you help.
                </p>
                <p class="text-xs text-gray-500 italic">"People don't buy what you do; they buy why you do it."</p>
            </div>

        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupImagePreview(inputId, previewContainerId, previewImageId, clearButtonId) {
        const input = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewContainerId);
        const previewImage = document.getElementById(previewImageId);
        const clearButton = document.getElementById(clearButtonId);

        if (!input || !previewContainer || !previewImage) {
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
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        });

        if (clearButton) {
            clearButton.addEventListener('click', function() {
                input.value = '';
                previewContainer.classList.add('hidden');
                previewImage.src = '';
            });
        }
    }

    // Initialize logic for the main Hero Image
    setupImagePreview('hero_image', 'hero-preview-container', 'hero-preview', 'clear-hero-btn');
    
    // Wisdom Cards
    setupImagePreview('wisdom1_image', 'wisdom1-preview-container', 'wisdom1-preview', 'clear-wisdom1-btn');
    setupImagePreview('wisdom2_image', 'wisdom2-preview-container', 'wisdom2-preview', 'clear-wisdom2-btn');
    
    // Story, Vision, Mission
    setupImagePreview('story_image', 'story-preview-container', 'story-preview', 'clear-story-btn');
    setupImagePreview('vision_image', 'vision-preview-container', 'vision-preview', 'clear-vision-btn');
    setupImagePreview('mission_image', 'mission-preview-container', 'mission-preview', 'clear-mission-btn');
});
</script>
@endsection
