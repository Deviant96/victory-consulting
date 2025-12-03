<header class="bg-white/90 backdrop-blur border-b border-slate-200 sticky top-0 z-20">
    <div class="admin-container h-16 flex items-center justify-between gap-4">
        <!-- Left side - Title -->
        <div class="flex items-center gap-3">
            <button class="lg:hidden p-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition" @click="toggleSidebar()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Admin</p>
                <h2 class="text-lg font-semibold text-slate-900">
                    @yield('page-title', 'Dashboard')
                </h2>
            </div>
        </div>

        <!-- Right side - User actions -->
        <div class="flex items-center gap-3">
            <a href="{{ url('/') }}"
               target="_blank"
               class="hidden sm:inline-flex items-center px-3 py-2 text-sm text-slate-700 border border-slate-200 rounded-lg hover:bg-slate-50 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                View Site
            </a>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-2 bg-slate-100 text-slate-800 rounded-xl hover:bg-slate-200 transition">
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-medium shadow-inner shadow-blue-900/30">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-cloak x-show="open"
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl py-2 z-50 border border-slate-200"
                     style="display: none;">

                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>

                    <div class="border-t border-slate-100 my-1"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
