@extends('admin.layouts.app')

@section('title', 'Overview')

@section('page-title', 'Overview')

@section('content')
    <div class="space-y-6">
        <!-- Content Breakdown Section -->
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Content Status</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- FAQ Stats -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-50 rounded-md p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total FAQs</dt>
                                    <dd>
                                        <div class="text-lg font-bold text-gray-900">{{ number_format($stats['faqs'] ?? 0) }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 border-t border-gray-100">
                        <div class="text-sm">
                            <a href="{{ route('admin.faqs.index') }}" class="font-medium text-blue-600 hover:text-blue-500">View details</a>
                        </div>
                    </div>
                </div>

                <!-- Services Stats -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-50 rounded-md p-3">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Services Offered</dt>
                                    <dd>
                                        <div class="text-lg font-bold text-gray-900">{{ number_format($stats['services'] ?? 0) }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Stats -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-50 rounded-md p-3">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Team Members</dt>
                                    <dd>
                                        <div class="text-lg font-bold text-gray-900">{{ number_format($stats['team'] ?? 0) }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles Stats -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-pink-50 rounded-md p-3">
                                <svg class="h-6 w-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Articles Published</dt>
                                    <dd>
                                        <div class="text-lg font-bold text-gray-900">{{ number_format($stats['articles'] ?? 0) }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System & Activity Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Booking Status Distribution (New Chart-style Layout) -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 lg:col-span-1">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Booking Status Distribution</h3>
                <div class="space-y-6">
                    @foreach($bookingStatusCounts ?? [] as $status => $count)
                        @php
                            $totalBookings = array_sum($bookingStatusCounts->toArray());
                            $percentage = $totalBookings > 0 ? ($count / $totalBookings) * 100 : 0;
                            $colorClass = match($status) {
                                'pending' => 'bg-amber-500',
                                'confirmed' => 'bg-emerald-500',
                                'cancelled' => 'bg-red-500',
                                'completed' => 'bg-blue-500', 
                                default => 'bg-gray-500' 
                            };
                            // Humanize status
                            $label = ucfirst($status);
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 capitalize">{{ $label }}</span>
                                <span class="text-sm font-bold text-gray-900">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="{{ $colorClass }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                    
                    @if(empty($bookingStatusCounts) || $bookingStatusCounts->isEmpty())
                        <div class="text-center py-4 text-gray-500 text-sm">No booking data available yet.</div>
                    @endif
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.bookings.index') }}" class="block w-full text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition">
                        Manage All Bookings
                    </a>
                </div>
            </div>

            <!-- Detailed Quick Actions -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 lg:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <p class="text-sm text-gray-500 mb-6">Common tasks to manage your website content effectively.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Create Service -->
                    <a href="{{ route('admin.services.create') }}" class="group flex items-start p-4 rounded-xl border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50/50 transition duration-200">
                        <div class="flex-shrink-0 p-2 bg-indigo-100 rounded-lg group-hover:bg-indigo-200 transition">
                            <svg class="w-6 h-6 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-semibold text-gray-900 group-hover:text-indigo-700">Add New Service</h4>
                            <p class="text-sm text-gray-500 mt-1">List a new service offering on your website.</p>
                        </div>
                    </a>

                    <!-- Write Article -->
                    <a href="{{ route('admin.articles.create') }}" class="group flex items-start p-4 rounded-xl border border-gray-200 hover:border-pink-300 hover:bg-pink-50/50 transition duration-200">
                        <div class="flex-shrink-0 p-2 bg-pink-100 rounded-lg group-hover:bg-pink-200 transition">
                            <svg class="w-6 h-6 text-pink-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-semibold text-gray-900 group-hover:text-pink-700">Write Article</h4>
                            <p class="text-sm text-gray-500 mt-1">Publish a new blog post or news update.</p>
                        </div>
                    </a>

                    <!-- Update Contact -->
                    <a href="{{ route('admin.settings.contact') }}" class="group flex items-start p-4 rounded-xl border border-gray-200 hover:border-gray-300 hover:bg-gray-50/50 transition duration-200">
                        <div class="flex-shrink-0 p-2 bg-gray-100 rounded-lg group-hover:bg-gray-200 transition">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-semibold text-gray-900 group-hover:text-gray-700">Update Contact Info</h4>
                            <p class="text-sm text-gray-500 mt-1">Change address, phone, or email details.</p>
                        </div>
                    </a>

                    <!-- Manage FAQs -->
                    <a href="{{ route('admin.faqs.create') }}" class="group flex items-start p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:bg-blue-50/50 transition duration-200">
                        <div class="flex-shrink-0 p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-base font-semibold text-gray-900 group-hover:text-blue-700">Add Question</h4>
                            <p class="text-sm text-gray-500 mt-1">Create a new FAQ item for the support page.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
