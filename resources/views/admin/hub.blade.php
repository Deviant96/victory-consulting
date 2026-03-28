@extends('admin.layouts.app')

@section('title', 'Admin Hub')

@section('page-title', 'Admin Hub')

@section('content')
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name ?? 'Admin' }}</h1>
                <p class="text-sm text-gray-500 mt-1">Here's an overview of your website performance today.</p>
            </div>
            <div>
                <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.389 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Check Inquiries
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Bookings -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Inquiries</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['bookings'] ?? 0 }}</h3>
                    </div>
                    <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Published Articles -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Articles</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['articles'] ?? 0 }}</h3>
                    </div>
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Services</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['services'] ?? 0 }}</h3>
                    </div>
                    <div class="p-2 bg-amber-50 rounded-lg text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Team Members -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Team Members</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['team'] ?? 0 }}</h3>
                    </div>
                    <div class="p-2 bg-rose-50 rounded-lg text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Navigation Grid -->
        <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Modules</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Overview Module -->
                <a href="{{ route('admin.overview') }}" class="group relative bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:border-blue-300 transition-all duration-300 flex flex-col h-full">
                    <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity pointer-events-none">
                         <svg class="w-24 h-24 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/></svg>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Overview</h3>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed">Comprehensive status snapshot, recent activity logs, and system analytics.</p>
                    <div class="mt-auto pt-4 flex items-center text-sm font-semibold text-blue-600 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        Open Dashboard <span class="ml-2">&rarr;</span>
                    </div>
                </a>

                <!-- Website Management Module -->
                <a href="{{ route('admin.pages.home') }}" class="group relative bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:border-purple-300 transition-all duration-300 flex flex-col h-full">
                    <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity pointer-events-none">
                        <svg class="w-24 h-24 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.002 6.002 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.236-.497.623-.737 1.138-.479 1.03-.836 2.379-.922 3.861h4.248c-.086-1.482-.443-2.831-.922-3.861-.24-.515-.499-.902-.737-1.138C10.232 4.032 10.076 4 10 4zm9.917 5h-1.946c-.089-1.546-.383-2.97-.837-4.118A6.002 6.002 0 0119.917 9zM10 18a8.006 8.006 0 01-5.917-2.656c.926-.262 2.657-.65 3.967-.834.341 1.696.96 2.932 1.95 2.932s1.609-1.236 1.95-2.932c1.31.184 3.04.572 3.967.834A8.006 8.006 0 0110 18z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600 transition-colors">Website Content</h3>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed">Manage pages, services, industries, blog posts, team members, and FAQs.</p>
                    <div class="mt-auto pt-4 flex items-center text-sm font-semibold text-purple-600 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        Manage Content <span class="ml-2">&rarr;</span>
                    </div>
                </a>

                <!-- Inquiries Module -->
                <a href="{{ route('admin.bookings.index') }}" class="group relative bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:border-orange-300 transition-all duration-300 flex flex-col h-full">
                     <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity pointer-events-none">
                        <svg class="w-24 h-24 text-orange-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    </div>
                    <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="relative inline-flex">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            @if(($stats['bookingStatusCounts']['pending'] ?? 0) > 0)
                                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
                                </span>
                            @endif
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-orange-600 transition-colors">Client Inquiries</h3>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed">View bookings, manage notification settings, and configure WhatsApp agents.</p>
                    <div class="mt-auto pt-4 flex items-center text-sm font-semibold text-orange-600 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        View Inquiries <span class="ml-2">&rarr;</span>
                    </div>
                </a>

                <!-- Settings Module -->
                <a href="{{ route('admin.settings.branding') }}" class="group relative bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:border-gray-400 transition-all duration-300 flex flex-col h-full">
                     <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity pointer-events-none">
                        <svg class="w-24 h-24 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-gray-700 transition-colors">Settings</h3>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed">Configure branding, contact details, social links, languages, and system translations.</p>
                    <div class="mt-auto pt-4 flex items-center text-sm font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        Open Settings <span class="ml-2">&rarr;</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Inquiries -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-semibold text-gray-900">Recent Inquiries</h3>
                    <a href="{{ route('admin.bookings.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentBookings ?? [] as $booking)
                        <div class="px-6 py-4 hover:bg-gray-50 transition flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-sm">
                                    {{ substr($booking->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $booking->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->created_at->diffForHumans() }} &bull; {{ $booking->service->title ?? 'General Inquiry' }}</p>
                                </div>
                            </div>
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $booking->status === 'pending' ? 'yellow' : ($booking->status === 'confirmed' ? 'green' : 'gray') }}-100 text-{{ $booking->status === 'pending' ? 'yellow' : ($booking->status === 'confirmed' ? 'green' : 'gray') }}-800">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 text-sm">
                            No recent inquiries found.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Articles -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-semibold text-gray-900">Recent Articles</h3>
                    <a href="{{ route('admin.articles.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentPosts ?? [] as $post)
                        <div class="px-6 py-4 hover:bg-gray-50 transition flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-lg overflow-hidden">
                                    @if($post->thumbnail)
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $post->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $post->created_at->format('M d, Y') }} &bull; {{ $post->is_published ? 'Published' : 'Draft' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.articles.edit', $post) }}" class="text-gray-400 hover:text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 text-sm">
                            No recent articles found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
