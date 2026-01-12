@extends('admin.layouts.app')
    
@section('title', 'Industry Page Settings')
@section('page-title', 'Industry Page Settings')
@section('page-description', 'Manage content for the Industry Page')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Industry Page Settings</h1>
    <p class="text-gray-600 mt-2">Manage header and CTA content for the Industry Page</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.pages.industry.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Header Content -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Header Content</h2>
            
            <x-admin.settings-field-with-translation
                name="industry[page_title]"
                label="Page Title"
                value="Industries We Serve"
                :settings="$settings"
                :languages="$languages"
            />

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="industry[page_description]"
                    label="Page Description"
                    type="textarea"
                    rows="3"
                    value="Whatever your business, we can handle it. Comprehensive solutions tailored to your industry's unique challenges and opportunities."
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>
        </div>

        <!-- Industry Page Hero Image -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Industry Page Full-Width Image</h2>
            
            <div class="mb-6">
                <label for="industry_image" class="block text-sm font-medium text-gray-700 mb-2">Industry Hero Image</label>
                @if(settings('hero.industry_image'))
                <div class="mb-3">
                    <img id="current-image" src="{{ asset('storage/' . settings('hero.industry_image')) }}" alt="Current Industry Hero" class="w-full max-w-2xl h-48 object-cover rounded-lg shadow-md">
                    <p class="text-sm text-gray-500 mt-1">Current industry page hero image</p>
                </div>
                @endif
                
                <!-- Preview Container for New Image -->
                <div id="image-preview-container" class="hidden mb-3">
                    <div class="relative">
                        <img id="image-preview" src="" alt="New Image Preview" class="w-full max-w-2xl h-48 object-cover rounded-lg shadow-md border-4 border-blue-500">
                        <div class="absolute top-2 right-2 bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            New Image Selected
                        </div>
                        <button type="button" id="clear-image-btn" class="absolute bottom-2 right-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-lg flex items-center gap-2 transition transform hover:scale-105">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Clear
                        </button>
                    </div>
                    <p class="text-sm text-blue-600 font-semibold mt-1 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Preview of new image - click "Save Industry Settings" to upload
                    </p>
                </div>
                
                <input type="file" name="industry_image" id="industry_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition">
                @error('industry_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Recommended: 1920x400px or larger, max 4MB. Displays as full-width banner below the industry page hero section.</p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Call to Action Section</h2>
            
            <x-admin.settings-field-with-translation
                name="industry[cta_title]"
                label="CTA Title"
                value="Don't See Your Industry?"
                :settings="$settings"
                :languages="$languages"
            />

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="industry[cta_description]"
                    label="CTA Description"
                    type="textarea"
                    rows="2"
                    value="We work with businesses across all sectors. Contact us to discuss how we can help your specific industry."
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>

            <div class="grid md:grid-cols-2 gap-6 mt-6">
                <div>
                    <x-admin.settings-field-with-translation
                        name="industry[cta_primary_button]"
                        label="Primary Button Text"
                        value="Contact Us Today"
                        :settings="$settings"
                        :languages="$languages"
                    />
                </div>

                <div>
                    <x-admin.settings-field-with-translation
                        name="industry[cta_secondary_button]"
                        label="Secondary Button Text"
                        value="View Our Services"
                        :settings="$settings"
                        :languages="$languages"
                    />
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Save Industry Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('industry_image');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');
    const currentImage = document.getElementById('current-image');
    const clearBtn = document.getElementById('clear-image-btn');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Check file size (4MB = 4 * 1024 * 1024 bytes)
            if (file.size > 4 * 1024 * 1024) {
                alert('File size must be less than 4MB');
                imageInput.value = '';
                previewContainer.classList.add('hidden');
                return;
            }
            
            // Check file type
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file');
                imageInput.value = '';
                previewContainer.classList.add('hidden');
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
                
                // Add a smooth fade-in animation
                previewContainer.style.opacity = '0';
                setTimeout(() => {
                    previewContainer.style.transition = 'opacity 0.3s ease-in-out';
                    previewContainer.style.opacity = '1';
                }, 10);
                
                // Scroll to preview
                previewContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            };
            
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
        }
    });
    
    // Clear button functionality
    clearBtn.addEventListener('click', function() {
        imageInput.value = '';
        previewContainer.style.transition = 'opacity 0.2s ease-in-out';
        previewContainer.style.opacity = '0';
        setTimeout(() => {
            previewContainer.classList.add('hidden');
            previewImage.src = '';
        }, 200);
    });
});
</script>
@endsection
