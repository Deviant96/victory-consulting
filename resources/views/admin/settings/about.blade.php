@extends('admin.layouts.app')
    
@section('title', 'About Us Page')
@section('page-title', 'About Us Page')
@section('page-description', 'Manage your About Us page content')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">About Us Page</h1>
    <p class="text-gray-600 mt-2">Edit all content for the About Us page in one place</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow">
    <form action="{{ route('admin.settings.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Page Header</h2>
            
            <div class="mb-6">
                <label for="header_title" class="block text-sm font-medium text-gray-700 mb-2">Header Title *</label>
                <input type="text" name="about[header_title]" id="header_title" 
                       value="{{ old('about.header_title', $settings['about.header_title'] ?? 'About Us') }}" 
                       required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                @error('about.header_title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="header_description" class="block text-sm font-medium text-gray-700 mb-2">Header Description</label>
                <textarea name="about[header_description]" id="header_description" rows="2" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">{{ old('about.header_description', $settings['about.header_description'] ?? '') }}</textarea>
                @error('about.header_description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Brief introduction shown in the header</p>
            </div>
        </div>

        <!-- Main About Content -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Main About Content</h2>
            
            <div class="mb-6">
                <label for="about_content" class="block text-sm font-medium text-gray-700 mb-2">About Us Content *</label>
                <textarea name="about[content]" id="about_content" rows="15" 
                          required
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 font-mono text-sm">{{ old('about.content', $settings['about.content'] ?? '') }}</textarea>
                @error('about.content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">
                    Write your complete About Us content here. Use line breaks to separate paragraphs.
                    This will be displayed as the main content on your About Us page.
                </p>
            </div>
        </div>

        <!-- Vision Section -->
        <div class="p-6 border-b border-gray-200 bg-blue-50">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Vision
            </h2>
            
            <div class="mb-6">
                <label for="vision_title" class="block text-sm font-medium text-gray-700 mb-2">Vision Title</label>
                <input type="text" name="about[vision_title]" id="vision_title" 
                       value="{{ old('about.vision_title', $settings['about.vision_title'] ?? 'Our Vision') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                @error('about.vision_title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="vision_content" class="block text-sm font-medium text-gray-700 mb-2">Vision Content</label>
                <textarea name="about[vision_content]" id="vision_content" rows="5" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">{{ old('about.vision_content', $settings['about.vision_content'] ?? '') }}</textarea>
                @error('about.vision_content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="vision_image" class="block text-sm font-medium text-gray-700 mb-2">Vision Image</label>
                @if(isset($settings['about.vision_image']) && $settings['about.vision_image'])
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings['about.vision_image']) }}" 
                         alt="Vision Image" 
                         class="w-48 h-24 object-cover rounded-lg">
                </div>
                @endif
                <input type="file" name="about.vision_image" id="vision_image" accept="image/*" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                @error('about.vision_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Recommended: Image of a woman offering handshake</p>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="p-6 border-b border-gray-200 bg-green-50">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Mission
            </h2>
            
            <div class="mb-6">
                <label for="mission_title" class="block text-sm font-medium text-gray-700 mb-2">Mission Title</label>
                <input type="text" name="about[mission_title]" id="mission_title" 
                       value="{{ old('about.mission_title', $settings['about.mission_title'] ?? 'Our Mission') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                @error('about.mission_title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="mission_content" class="block text-sm font-medium text-gray-700 mb-2">Mission Content</label>
                <textarea name="about[mission_content]" id="mission_content" rows="5" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">{{ old('about.mission_content', $settings['about.mission_content'] ?? '') }}</textarea>
                @error('about.mission_content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="mission_image" class="block text-sm font-medium text-gray-700 mb-2">Mission Image</label>
                @if(isset($settings['about.mission_image']) && $settings['about.mission_image'])
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings['about.mission_image']) }}" 
                         alt="Mission Image" 
                         class="w-48 h-24 object-cover rounded-lg">
                </div>
                @endif
                <input type="file" name="about.mission_image" id="mission_image" accept="image/*" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                @error('about.mission_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Recommended: Image of a man offering handshake</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="p-6 bg-gray-50">
            <div class="flex gap-4">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save About Us Page
                </button>
                <a href="{{ route('about') }}" target="_blank"
                   class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Preview Page
                </a>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textareas as user types
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Trigger on page load
        textarea.dispatchEvent(new Event('input'));
    });
});
</script>
@endpush
@endsection
