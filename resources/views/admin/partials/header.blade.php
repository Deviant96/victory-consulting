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
    <div class="flex items-center space-x-3">
        <button @click="$dispatch('open-search')" class="hidden md:flex items-center px-3 py-2 rounded-xl bg-gray-100 border border-gray-200 text-sm text-gray-600 hover:bg-gray-200 hover:border-gray-300 transition cursor-pointer">
            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0011.15 11.15z" />
            </svg>
            Quick search
            <kbd class="ml-2 px-1.5 py-0.5 text-xs bg-white border border-gray-300 rounded">Ctrl+K</kbd>
        </button>

        <!-- Notifications -->
        @php
            $notifications = $adminNotifications ?? collect();
            $unreadCount = $adminUnreadNotificationsCount ?? 0;
        @endphp

        <div x-data="{ open: false }" class="relative">
            <button
                @click="open = !open"
                @click.away="open = false"
                @keydown.escape.window="open = false"
                class="relative p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition"
                aria-label="Notifications"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>

                @if ($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-semibold leading-none text-white bg-red-500 rounded-full ring-2 ring-white">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-96 max-w-[90vw] bg-white rounded-xl shadow-2xl border border-gray-200 z-50"
                style="display: none;"
            >
                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Notifications</p>
                        <p class="text-xs text-gray-500">{{ $unreadCount }} unread</p>
                    </div>

                    @if ($notifications->isNotEmpty())
                        <form method="POST" action="{{ route('admin.notifications.read') }}">
                            @csrf
                            <button type="submit" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                Mark all as read
                            </button>
                        </form>
                    @endif
                </div>

                <div class="max-h-80 overflow-y-auto">
                    @forelse ($notifications as $notification)
                        @php
                            $data = $notification->data ?? [];
                            $bookingId = $data['booking_id'] ?? null;
                            $url = $bookingId ? route('admin.bookings.show', $bookingId) : null;
                            $title = 'Notification';
                            $description = $data['message'] ?? 'Open for more details.';

                            if ($notification->type === \App\Notifications\NewBookingNotification::class) {
                                $title = 'New booking from ' . ($data['name'] ?? 'Client');
                                $description = $data['service'] ?? 'A consultation request is ready to review.';
                            }

                            $statusStyles = [
                                'pending' => ['badge' => 'bg-amber-100 text-amber-800', 'dot' => 'bg-amber-400'],
                                'confirmed' => ['badge' => 'bg-green-100 text-green-800', 'dot' => 'bg-green-500'],
                                'completed' => ['badge' => 'bg-blue-100 text-blue-800', 'dot' => 'bg-blue-500'],
                            ];

                            $statusStyle = $statusStyles[$data['status'] ?? ''] ?? ['badge' => 'bg-gray-100 text-gray-700', 'dot' => 'bg-gray-400'];
                        @endphp

                        <a
                            href="{{ $url ?? '#' }}"
                            class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50"
                        >
                            <div class="mt-0.5">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $title }}</p>
                                    <span class="text-[11px] text-gray-500 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">{{ $description }}</p>

                                <div class="flex items-center gap-2 mt-2 text-[11px] text-gray-500">
                                    @if (!empty($data['preferred_date']))
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ \Illuminate\Support\Carbon::parse($data['preferred_date'])->format('M j, Y') }}</span>
                                        </span>
                                    @endif

                                    @if (!empty($data['preferred_time']))
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $data['preferred_time'] }}</span>
                                        </span>
                                    @endif

                                    @if (!empty($data['status']))
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full capitalize {{ $statusStyle['badge'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $statusStyle['dot'] }}"></span>
                                            {{ $data['status'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if (is_null($notification->read_at))
                                <span class="mt-1 w-2 h-2 rounded-full bg-indigo-500"></span>
                            @endif
                        </a>
                    @empty
                        <div class="px-4 py-6 text-center text-sm text-gray-500">
                            No notifications yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="hidden sm:block">
            <x-language-switcher />
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
