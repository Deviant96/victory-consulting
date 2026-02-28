@extends('admin.layouts.app')
    
@section('title', 'Contact Page Content')
@section('page-title', 'Contact Page')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Contact Page Content</h1>
            <p class="text-sm text-gray-500 mt-1">Customize the headline and introductory text that visitors see on your "Contact Us" page.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.contact') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Manage Phone & Email
            </a>
            <a href="{{ route('admin.settings.social') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                Manage Social Links
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form Area -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">Page Header Content</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Visible on website
                    </span>
                </div>
                
                <form action="{{ route('admin.pages.contact.update') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    
                    <!-- Page Title Field -->
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:border-blue-200 transition-colors">
                         <x-admin.settings-field-with-translation
                            name="contact[page_title]"
                            label="Page Headline"
                            value="Contact Us"
                            :settings="$settings"
                            :languages="$languages"
                        />
                        <p class="mt-2 text-xs text-gray-500">The main title displayed at the top of the contact page (e.g., "Get in Touch", "Contact Us").</p>
                    </div>

                    <!-- Page Description Field -->
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:border-blue-200 transition-colors">
                        <x-admin.settings-field-with-translation
                            name="contact[page_description]"
                            label="Page Description"
                            type="textarea"
                            rows="4"
                            value="Get in touch with our team"
                            :settings="$settings"
                            :languages="$languages"
                        />
                         <p class="mt-2 text-xs text-gray-500">A short introductory paragraph encouraging visitors to reach out.</p>
                    </div>

                    <div class="pt-4 flex items-center justify-between border-t border-gray-100 mt-6">
                        <p class="text-sm text-gray-500 italic">Last saved: {{ now()->format('M d, Y') }} (Changes apply immediately)</p>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview / Info Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Preview Card -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white overflow-hidden relative">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold mb-2">Live Preview Tip</h3>
                    <p class="text-blue-100 text-sm mb-4">The content you edit here appears directly in the specific page header area of your "Contact Us" page.</p>
                    <a href="{{ url('/contact') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 border border-white/40 rounded-lg text-sm font-medium transition backdrop-blur-sm">
                        View Live Page <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
                <!-- Decor -->
                <svg class="absolute -bottom-6 -right-6 w-32 h-32 text-white/10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            </div>

            <!-- Contextual Help -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Did you know?
                </h3>
                <div class="space-y-4 text-sm text-gray-600">
                    <p>The "Contact Information" displayed on the website (phone, email, address) is managed separately in the global settings.</p>
                    <hr class="border-gray-100">
                    <p>Social media icons in the footer and contact page can be updated in the "Social Links" section.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection