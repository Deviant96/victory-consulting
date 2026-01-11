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
    <form action="{{ route('admin.pages.industry.update') }}" method="POST">
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
@endsection
