@extends('admin.layouts.app')
    
@section('title', 'Services Page Settings')
@section('page-title', 'Services Page')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Services Page Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Configure the main landing page for your services.</p>
        </div>
        <div class="flex items-center gap-3">
             <a href="{{ route('admin.services.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Manage Services List
            </a>
            <a href="{{ route('admin.services.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Add New Service
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

    <form action="{{ route('admin.pages.services.update') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
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
                            name="services[page_title]"
                            label="Page Title"
                            value="Our Services"
                            :settings="$settings"
                            :languages="$languages"
                        />
                        <p class="mt-2 text-xs text-gray-500">The main headline displayed at the top of the services page.</p>
                    </div>

                    <!-- Page Description -->
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:border-blue-200 transition-colors">
                        <x-admin.settings-field-with-translation
                            name="services[page_description]"
                            label="Page Description"
                            type="textarea"
                            rows="2"
                            value="Explore our comprehensive range of professional services"
                            :settings="$settings"
                            :languages="$languages"
                        />
                        <p class="mt-2 text-xs text-gray-500">A brief introduction text shown below the headline.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">Bottom Call to Action</h2>
                    <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Conversion Driver</span>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <x-admin.settings-field-with-translation
                                name="services[cta_heading]"
                                label="Heading"
                                value="We can tailor our services to meet your specific business needs"
                                :settings="$settings"
                                :languages="$languages"
                            />
                            <p class="mt-1 text-xs text-gray-500">Encourage users to take action after viewing your services.</p>
                        </div>

                        <x-admin.settings-field-with-translation 
                            name="services[cta_description]" 
                            label="Description" 
                            type="textarea" 
                            rows="2" 
                            value=""
                            :settings="$settings" 
                            :languages="$languages"
                        />

                        <div>
                            <x-admin.settings-field-with-translation
                                name="services[cta_button]"
                                label="Button Text"
                                value="Book Now"
                                :settings="$settings"
                                :languages="$languages"
                            />
                            <p class="mt-1 text-xs text-gray-500">The text on the button that links to the booking/contact page.</p>
                        </div>
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
            
            <!-- Quick Link to Services -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 mb-2">Manage Individual Services</h3>
                    <p class="text-sm text-gray-600 mb-4">You can edit the details, pricing, and images for each service individually.</p>
                    <a href="{{ route('admin.services.index') }}" class="block w-full text-center px-4 py-2 border border-blue-200 text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg text-sm font-medium transition">
                        Go to Services List
                    </a>
                </div>
            </div>

            <!-- Preview / Context -->
            <div class="bg-gradient-to-br from-indigo-500 to-cyan-500 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-bold text-lg mb-2">Services Preview</h3>
                    <p class="text-indigo-100 text-sm mb-4">Check how your services catalog appears to potential clients.</p>
                    <a href="{{ url('/services') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 border border-white/40 rounded-lg text-sm font-medium transition backdrop-blur-sm">
                        View Services Page <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
                <svg class="absolute -bottom-6 -right-6 w-32 h-32 text-white/10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/></svg>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Tip
                </h3>
                <p class="text-sm text-gray-600">
                    Make sure your "Page Description" is catchy. This is often the first thing clients read before browsing your offerings.
                </p>
            </div>

        </div>
    </form>
</div>
@endsection
