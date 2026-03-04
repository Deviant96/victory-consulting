@extends('admin.layouts.app')
    
@section('title', 'Industries Page Settings')
@section('page-title', 'Industries Page')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Industries Page Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Configure the landing page for your industry sectors and business solutions.</p>
        </div>
        <div class="flex items-center gap-3">
             <a href="{{ route('admin.business-solutions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Manage Solutions List
            </a>
            <a href="{{ route('admin.business-solutions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Add Solution
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

    <form action="{{ route('admin.pages.industry.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf

        <!-- Main Settings Area -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Header Content Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Header Content</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Page Title -->
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:border-blue-200 transition-colors">
                        <x-admin.settings-field-with-translation
                            name="industry[page_title]"
                            label="Page Title"
                            value="Industries We Serve"
                            :settings="$settings"
                            :languages="$languages"
                        />
                        <p class="mt-2 text-xs text-gray-500">The main headline displayed at the top of the industries page.</p>
                    </div>

                    <!-- Page Description -->
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:border-blue-200 transition-colors">
                        <x-admin.settings-field-with-translation
                            name="industry[page_description]"
                            label="Page Description"
                            type="textarea"
                            rows="3"
                            value="Whatever your business, we can handle it. Comprehensive solutions tailored to your industry's unique challenges and opportunities."
                            :settings="$settings"
                            :languages="$languages"
                        />
                        <p class="mt-2 text-xs text-gray-500">A brief introduction text shown below the headline.</p>
                    </div>
                </div>
            </div>

            <!-- Hero Image Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">Banner Image</h2>
                    <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Visual Impact</span>
                </div>
                <div class="p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-4">Full-Width Hero Image</label>
                    
                    <div class="space-y-4">
                        <!-- Current Image Display -->
                        @if(settings('hero.industry_image'))
                            <div class="relative group rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                                <img src="{{ asset('storage/' . settings('hero.industry_image')) }}" alt="Current Hero" class="w-full h-48 object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-white font-medium text-sm">Current Banner</span>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-32 bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center text-gray-400">
                                No image currently set
                            </div>
                        @endif

                        <!-- Image Preview (Hidden by default) -->
                        <div id="image-preview-container" class="hidden relative group rounded-xl overflow-hidden border-2 border-blue-500 shadow-md transition-all duration-300">
                            <img id="image-preview" src="" alt="New Preview" class="w-full h-48 object-cover">
                            <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-white font-medium text-sm mb-2">New Selection</span>
                                <button type="button" id="clear-image-btn" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-semibold shadow transition">
                                    Clear Selection
                                </button>
                            </div>
                            <div class="absolute top-2 right-2 bg-blue-500 text-white px-2 py-0.5 rounded text-xs font-semibold shadow">New</div>
                        </div>

                        <!-- Upload Input -->
                        <div class="relative">
                            <input type="file" name="industry_image" id="industry_image" accept="image/*" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-xl file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                                transition cursor-pointer
                            "/>
                        </div>
                        <p class="text-xs text-gray-500">Recommended size: 1920x400px. Max size: 4MB.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">Bottom Call to Action</h2>
                    <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Lead Gen</span>
                </div>
                <div class="p-6 space-y-6">
                    <x-admin.settings-field-with-translation
                        name="industry[cta_title]"
                        label="CTA Heading"
                        value="Ready to transform your business?"
                        :settings="$settings"
                        :languages="$languages"
                    />

                    <x-admin.settings-field-with-translation
                        name="industry[cta_description]"
                        label="CTA Description"
                        type="textarea"
                        rows="2"
                        value="Contact us today to discuss how we can help you achieve your goals."
                        :settings="$settings"
                        :languages="$languages"
                    />

                    <x-admin.settings-field-with-translation
                        name="industry[cta_button]"
                        label="Button Text"
                        value="Get Started"
                        :settings="$settings"
                        :languages="$languages"
                    />
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
            
            <!-- Quick Link to Solutions -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 mb-2">Manage Business Solutions</h3>
                    <p class="text-sm text-gray-600 mb-4">Edit individual industry sectors (e.g., Finance, Healthcare) and their sub-solutions.</p>
                    <a href="{{ route('admin.business-solutions.index') }}" class="block w-full text-center px-4 py-2 border border-blue-200 text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg text-sm font-medium transition">
                        Edit Solutions
                    </a>
                </div>
            </div>

            <!-- Preview / Context -->
             <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-bold text-lg mb-2">Industry Page Preview</h3>
                    <p class="text-emerald-100 text-sm mb-4">See how your expertise is presented to potential corporate clients.</p>
                    <a href="{{ url('/industry') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 border border-white/40 rounded-lg text-sm font-medium transition backdrop-blur-sm">
                        View Industry Page <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
                <svg class="absolute -bottom-6 -right-6 w-32 h-32 text-white/10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/></svg>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    Pro Tip
                </h3>
                <p class="text-sm text-gray-600">
                    High-quality images build trust. Ensure your "Banner Image" is professional and relevant to your target industries.
                </p>
            </div>

        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('industry_image');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');
    const clearButton = document.getElementById('clear-image-btn');

    if (input && previewContainer && previewImage && clearButton) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                 // Check file size (4MB)
                if (file.size > 4 * 1024 * 1024) {
                    alert('File size must be less than 4MB');
                    input.value = '';
                    previewContainer.classList.add('hidden');
                    return;
                }
                
                // Check file type
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

        clearButton.addEventListener('click', function() {
            input.value = '';
            previewContainer.classList.add('hidden');
            previewImage.src = '';
        });
    }
});
</script>
@endsection