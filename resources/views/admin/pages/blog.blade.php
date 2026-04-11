@extends('admin.layouts.app')
    
@section('title', 'Blog Page Settings')
@section('page-title', 'Blog Page')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Blog Page Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Configure how your blog index page appears to visitors.</p>
        </div>
        <div class="flex items-center gap-3">
             <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Manage Articles
            </a>
            <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Write New Article
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

    <form action="{{ route('admin.pages.blog.update') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
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
                            name="blog[page_title]"
                            label="Page Title"
                            value="Our Blog"
                            :settings="$settings"
                            :languages="$languages"
                        />
                        <p class="mt-2 text-xs text-gray-500">The main headline displayed at the top of the blog index.</p>
                    </div>

                    <!-- Page Description -->
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:border-blue-200 transition-colors">
                        <x-admin.settings-field-with-translation
                            name="blog[page_description]"
                            label="Page Description"
                            type="textarea"
                            rows="2"
                            value="Insights, strategies, and expert perspectives on business growth and success"
                            :settings="$settings"
                            :languages="$languages"
                        />
                        <p class="mt-2 text-xs text-gray-500">A brief introduction below the headline.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">Subscription / CTA Section</h2>
                    <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Optional</span>
                </div>
                <div class="p-6 space-y-6">
                    <x-admin.settings-field-with-translation
                        name="blog[cta_title]"
                        label="Heading"
                        value="Stay Updated"
                        :settings="$settings"
                        :languages="$languages"
                    />

                    <x-admin.settings-field-with-translation
                        name="blog[cta_description]"
                        label="Description"
                        type="textarea"
                        rows="2"
                        value="Subscribe to our newsletter for the latest insights and business strategies"
                        :settings="$settings"
                        :languages="$languages"
                    />

                    <x-admin.settings-field-with-translation
                        name="blog[cta_button]"
                        label="Button Text"
                        value="Subscribe"
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
            
            <!-- Filters Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-100 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    <h2 class="text-lg font-medium text-blue-900">Sidebar & Filters</h2>
                </div>
                
                <div class="p-6">
                    <div class="flex items-start gap-3 bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:border-blue-400 transition cursor-pointer" onclick="document.getElementById('enable_filters').click()">
                        <div class="flex items-center h-5 mt-1">
                            <input type="hidden" name="blog[enable_filters]" value="0">
                            <input type="checkbox" name="blog[enable_filters]" id="enable_filters" value="1" 
                                {{ old('blog.enable_filters', optional($settings->get('blog.enable_filters'))->value ?? '1') == '1' ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                        </div>
                        <div class="ml-2">
                            <label for="enable_filters" class="text-sm font-medium text-gray-900 cursor-pointer">
                                Enable Search & Filters
                            </label>
                            <p class="text-xs text-gray-500 mt-1">
                                Allows visitors to search articles, filter by category/tag, and sort by date.
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pro Tip</h4>
                        <p class="text-sm text-gray-600">
                            Keeping filters enabled increases user engagement by helping visitors find relevant content faster.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Preview / Context -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-bold text-lg mb-2">Blog Preview</h3>
                    <p class="text-indigo-100 text-sm mb-4">See how your blog index page looks to the world.</p>
                    <a href="{{ url('/blog') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 border border-white/40 rounded-lg text-sm font-medium transition backdrop-blur-sm">
                        Open Live Blog <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
                <svg class="absolute -bottom-6 -right-6 w-32 h-32 text-white/10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/></svg>
            </div>

        </div>
    </form>
</div>
@endsection
