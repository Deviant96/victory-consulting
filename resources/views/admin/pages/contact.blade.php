@extends('admin.layouts.app')
    
@section('title', 'Contact Page Settings')
@section('page-title', 'Contact Page Settings')
@section('page-description', 'Manage content for the Contact Page')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Contact Page Settings</h1>
    <p class="text-gray-600 mt-2">Manage header and description for the Contact Page</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('admin.pages.contact.update') }}" method="POST">
                @csrf

                <div class="mb-8 pb-8 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Header Content</h2>
                    
                    <x-admin.settings-field-with-translation
                        name="contact[page_title]"
                        label="Page Title"
                        value="Contact Us"
                        :settings="$settings"
                        :languages="$languages"
                    />

                    <div class="mt-6">
                        <x-admin.settings-field-with-translation
                            name="contact[page_description]"
                            label="Page Description"
                            type="textarea"
                            rows="3"
                            value="Get in touch with our team"
                            :settings="$settings"
                            :languages="$languages"
                        />
                    </div>
                </div>

                <div class="flex justify-end pt-5">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Links Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Contact Info Card -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Contact Information
            </h2>
            <p class="text-sm text-gray-600 mb-4">
                Update your phone number, email address, physical address, and business hours.
            </p>
            <a href="{{ route('admin.settings.contact') }}" class="block text-center w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded transition">
                Manage Contact Info
            </a>
        </div>

        <!-- Social Media Card -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                Social Media Links
            </h2>
            <p class="text-sm text-gray-600 mb-4">
                Manage links to your social media profiles (Facebook, Twitter, LinkedIn, etc).
            </p>
            <a href="{{ route('admin.settings.social') }}" class="block text-center w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded transition">
                Manage Social Links
            </a>
        </div>
    </div>
</div>
@endsection