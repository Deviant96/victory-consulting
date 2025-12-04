<aside x-cloak :class="['fixed inset-y-0 left-0 z-40 w-72 transform bg-slate-900 text-gray-100 transition-all duration-300 lg:relative lg:translate-x-0 lg:shadow-none', sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full lg:translate-x-0']">
    <div class="flex flex-col min-h-full">
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-4 bg-gradient-to-r from-slate-950 to-slate-900 border-b border-slate-800">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/20">VC</span>
                <div>
                    <p class="text-sm uppercase tracking-widest text-slate-400">Victory CMS</p>
                    <p class="text-base font-semibold text-white">Admin</p>
                </div>
            </div>
            <button class="lg:hidden text-slate-300 hover:text-white transition" @click="closeSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 space-y-6">
            <!-- Dashboard -->
            <div class="px-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Content Section -->
            <div class="space-y-2">
                <p class="px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Content</p>

                <div class="space-y-1 px-2">
                    <a href="{{ route('admin.bookings.index') ?? '#' }}"
                       class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : 'text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Bookings</span>
                    </a>

                    <a href="{{ route('admin.services.index') ?? '#' }}"
                       class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : 'text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Services</span>
                    </a>

                    <a href="{{ route('admin.team.index') ?? '#' }}"
                       class="sidebar-link {{ request()->routeIs('admin.team.*') ? 'active' : 'text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Team Members</span>
                    </a>

                    <a href="{{ route('admin.faqs.index') ?? '#' }}"
                       class="sidebar-link {{ request()->routeIs('admin.faqs.*') ? 'active' : 'text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>FAQs</span>
                    </a>

                    <a href="{{ route('admin.articles.index') ?? '#' }}"
                       class="sidebar-link {{ request()->routeIs('admin.articles.*') ? 'active' : 'text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <span>Articles</span>
                    </a>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="space-y-2">
                <p class="px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Settings</p>
                <div class="space-y-1 px-2">
                    <a href="{{ route('admin.settings.contact') ?? '#' }}"
                       class="sidebar-link {{ request()->routeIs('admin.settings.contact') ? 'active' : 'text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Contact Info</span>
                    </a>

                    <a href="{{ route('admin.settings.social') ?? '#' }}"
                       class="sidebar-link {{ request()->routeIs('admin.settings.social') ? 'active' : 'text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        <span>Social Links</span>
                    </a>

                    <a href="{{ route('admin.settings.booking') ?? '#' }}"
                       class="sidebar-link {{ request()->routeIs('admin.settings.booking') ? 'active' : 'text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" />
                        </svg>
                        <span>Booking Notifications</span>
                    </a>

                    <a href="{{ route('admin.settings.branding') ?? '#' }}"
                       class="sidebar-link {{ request()->routeIs('admin.settings.branding') ? 'active' : 'text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                        <span>Branding</span>
                    </a>
                </div>
            </div>

            <div class="space-y-2">
                <p class="px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">System</p>
                <div class="space-y-1 px-2">
                    <a href="{{ route('admin.logs.index') ?? '#' }}"
                       class="sidebar-link {{ request()->routeIs('admin.logs.*') ? 'active' : 'text-slate-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                        <span>Activity Log</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- User Section -->
        <div class="border-t border-slate-800 p-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-slate-800 flex items-center justify-center text-white text-sm font-semibold shadow-inner shadow-black/30">
                    <span>{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-slate-400">{{ auth()->user()->email ?? '' }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="text-xs text-blue-200 hover:text-white transition">Profile</a>
            </div>
        </div>
    </div>
</aside>
