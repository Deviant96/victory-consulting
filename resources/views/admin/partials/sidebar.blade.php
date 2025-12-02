<aside class="w-64 bg-gray-900 text-gray-100 flex-shrink-0">
    <div class="flex flex-col h-screen">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 bg-gray-950 border-b border-gray-800">
            <h2 class="text-xl font-bold text-white">Victory CMS</h2>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <!-- Content Section -->
            <div class="mt-4">
                <div class="px-6 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Content
                </div>

                <!-- Bookings -->
                <a href="{{ route('admin.bookings.index') ?? '#' }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.bookings.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Bookings
                </a>
                
                <!-- Services -->
                <a href="{{ route('admin.services.index') ?? '#' }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.services.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Services
                </a>

                <!-- Team Members -->
                <a href="{{ route('admin.team.index') ?? '#' }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.team.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Team Members
                </a>

                <!-- FAQs -->
                <a href="{{ route('admin.faqs.index') ?? '#' }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.faqs.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    FAQs
                </a>

                <!-- Articles -->
                <a href="{{ route('admin.articles.index') ?? '#' }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.articles.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    Articles
                </a>
            </div>

            <!-- Settings Section -->
            <div class="mt-4">
                <div class="px-6 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Settings
                </div>
                
                <!-- Contact Info -->
                <a href="{{ route('admin.settings.contact') ?? '#' }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.settings.contact') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Contact Info
                </a>

                <!-- Social Links -->
                <a href="{{ route('admin.settings.social') ?? '#' }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.settings.social') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                    Social Links
                </a>

                <!-- Booking Notifications -->
                <a href="{{ route('admin.settings.booking') ?? '#' }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.settings.booking') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" />
                    </svg>
                    Booking Notifications
                </a>

                <!-- Branding -->
                <a href="{{ route('admin.settings.branding') ?? '#' }}" 
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.settings.branding') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                    Branding
                </a>
            </div>
        </nav>

        <!-- User Section -->
        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">
                    <span class="text-sm font-medium">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-white">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-400">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>
</aside>
