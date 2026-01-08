@extends('admin.layouts.app')
    
@section('title', 'Services Page Settings')
@section('page-title', 'Services Page Settings')
@section('page-description', 'Manage content for the Services Page')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Services Page Settings</h1>
    <p class="text-gray-600 mt-2">Manage header and description for the Services Page</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.pages.services.update') }}" method="POST">
        @csrf

        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Header Content</h2>
            
            <x-admin.settings-field-with-translation
                name="services[page_title]"
                label="Page Title"
                value="Our Services"
                :settings="$settings"
                :languages="$languages"
            />

            <div class="mt-6">
                <x-admin.settings-field-with-translation
                    name="services[page_description]"
                    label="Page Description"
                    type="textarea"
                    rows="3"
                    value="Explore our comprehensive range of professional services"
                    :settings="$settings"
                    :languages="$languages"
                />
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Save Services Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
