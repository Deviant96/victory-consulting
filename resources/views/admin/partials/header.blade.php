<header class="sticky top-0 z-20 bg-white border-b border-gray-200 h-16 flex items-center px-4 sm:px-6 justify-between shadow-sm">
    <!-- Left side - Breadcrumbs or Page title -->
    <div class="flex items-center gap-3">
        <button class="lg:hidden p-2 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition" @click="sidebarOpen = true">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Control panel</p>
            <h2 class="text-lg font-semibold text-gray-900 leading-tight">
                @yield('page-title', 'Dashboard')
            </h2>
        </div>
    </div>

    <!-- Right side - User actions -->
    @php
        $user = auth()->user();
        $recentNotifications = $user?->notifications()->latest()->limit(5)->get() ?? collect();
        $unreadCount = $user?->unreadNotifications()->count() ?? 0;
    @endphp
    <div class="flex items-center space-x-3">
        <button @click="$dispatch('open-search')" class="hidden md:flex items-center px-3 py-2 rounded-xl bg-gray-100 border border-gray-200 text-sm text-gray-600 hover:bg-gray-200 hover:border-gray-300 transition cursor-pointer">
            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0011.15 11.15z" />
            </svg>
            Quick search
            <kbd class="ml-2 px-1.5 py-0.5 text-xs bg-white border border-gray-300 rounded">Ctrl+K</kbd>
        </button>

        <!-- Notifications -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="relative p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                @if ($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center h-5 min-w-5 px-1 text-xs font-bold text-white bg-red-500 rounded-full">
                        {{ $unreadCount }}
                    </span>
                @endif
            </button>

            <div x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 z-50"
                 style="display: none;">
                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Notifications</p>
                        <p class="text-xs text-gray-500">Latest updates for administrators</p>
                    </div>
                    <form method="POST" action="{{ route('admin.notifications.markAllRead') }}">
                        @csrf
                        <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">Mark all read</button>
                    </form>
                </div>

                <div class="max-h-96 overflow-y-auto divide-y divide-gray-100">
                    @forelse ($recentNotifications as $notification)
                        @php
                            $data = $notification->data;
                            $title = $data['title'] ?? 'Notification';
                            $message = $data['summary'] ?? $data['message'] ?? ($data['service'] ?? 'You have a new update.');
                            $url = $data['url'] ?? null;
                        @endphp
                        <a href="{{ $url ?? route('admin.notifications.index') }}"
                           class="block px-4 py-3 hover:bg-gray-50 transition">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg {{ $notification->read_at ? 'bg-gray-100 text-gray-500' : 'bg-blue-100 text-blue-700' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0 space-y-0.5">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-gray-900">{{ $title }}</p>
                                        @if (!$notification->read_at)
                                            <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-semibold bg-blue-100 text-blue-700 rounded-full">New</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-600 line-clamp-2">{{ $message }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-6 text-center text-gray-500">
                            <p class="text-sm font-semibold text-gray-700">No notifications yet</p>
                            <p class="text-xs text-gray-500">New booking requests will appear here.</p>
                        </div>
                    @endforelse
                </div>

                <div class="px-4 py-3 border-t border-gray-100 bg-gray-50 rounded-b-xl">
                    <a href="{{ route('admin.notifications.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">View all notifications</a>
                </div>
            </div>
        </div>

        <!-- View Site -->
        <a href="{{ url('/') }}"
           target="_blank"
           class="hidden sm:inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-100 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            View Site
        </a>

        <!-- User Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="flex items-center space-x-2 px-3 py-2 bg-gray-900 text-white rounded-xl shadow-sm hover:shadow-md transition">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-semibold">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-200"
                 style="display: none;">

                <!-- Profile -->
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile
                </a>

                <div class="border-t border-gray-100 my-1"></div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
