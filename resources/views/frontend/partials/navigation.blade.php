<nav class="bg-white border-b border-gray-200 sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    @if(settings('branding.logo'))
                        <img src="{{ asset('storage/' . settings('branding.logo')) }}" 
                             alt="{{ settings('site.name', 'Victory') }}"
                             class="h-10 w-auto">
                    @else
                        <span class="text-2xl font-bold text-gray-900">
                            {{ settings('site.name', 'Victory') }}
                        </span>
                    @endif
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}"
                   class="text-gray-700 hover:text-[#0481AE] transition-colors {{ request()->routeIs('home') ? 'text-[#0481AE] font-semibold' : '' }}">
                    {{ t('frontend.navigation.home', 'Home') }}
                </a>
                <a href="{{ route('about') }}"
                   class="text-gray-700 hover:text-[#0481AE] transition-colors {{ request()->routeIs('about') ? 'text-[#0481AE] font-semibold' : '' }}">
                    About
                </a>
                
                <!-- Services Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ route('services.index') }}"
                       class="flex items-center text-gray-700 hover:text-[#0481AE] transition-colors {{ request()->routeIs('services.*') ? 'text-[#0481AE] font-semibold' : '' }}">
                        {{ t('frontend.navigation.services', 'Services') }}
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                         style="display: none;">
                        <div class="py-1 max-h-[80vh] overflow-y-auto">
                            @foreach($navServices as $service)
                                <a href="{{ route('services.show', $service->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#0481AE]">
                                    {{ $service->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Industries Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ route('industries.index') }}"
                       class="flex items-center text-gray-700 hover:text-[#0481AE] transition-colors {{ request()->routeIs('industries.*') ? 'text-[#0481AE] font-semibold' : '' }}">
                        {{ t('frontend.navigation.industries', 'Industries') }}
                    </a>
                </div>
                {{-- <a href="{{ route('team') }}" 
                   class="text-gray-700 hover:text-[#0481AE] transition-colors {{ request()->routeIs('team') ? 'text-[#0481AE] font-semibold' : '' }}">
                    Team
                </a> --}}
                <a href="{{ route('blog.index') }}" 
                   class="text-gray-700 hover:text-[#0481AE] transition-colors {{ request()->routeIs('blog.*') ? 'text-[#0481AE] font-semibold' : '' }}">
                    {{ t('frontend.navigation.blog', 'Blog') }}
                </a>
                <a href="{{ route('contact') }}"
                   class="text-gray-700 hover:text-[#0481AE] transition-colors {{ request()->routeIs('contact') ? 'text-[#0481AE] font-semibold' : '' }}">
                    {{ t('frontend.navigation.contact', 'Contact') }}
                </a>
            </div>

            <!-- Search + Locale -->
            <div class="hidden md:flex items-center space-x-3" x-data="frontendSearch()" @keydown.escape.window="close()">
                <div class="relative">
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-full transition-all duration-200 overflow-hidden"
                         :class="open ? 'w-80 pl-4 pr-2 py-2 shadow-sm ring-1 ring-blue-100' : 'w-10 justify-center py-2'">
                        <button type="button"
                                class="text-gray-600 hover:text-[#0481AE] focus:outline-none"
                                @click="toggle()"
                                :aria-expanded="open">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.65 5.65a7.5 7.5 0 0 0 11 11Z" />
                            </svg>
                        </button>

                        <input x-show="open"
                               x-ref="searchInput"
                               x-model="query"
                               type="search"
                               name="q"
                               placeholder="{{ t('frontend.search.placeholder', 'Search services, people, articles') }}"
                               class="flex-1 bg-transparent text-sm text-gray-900 placeholder-gray-400 focus:outline-none ml-2"
                               @focus="openPanel()"
                               @input="ensureIndex()"
                               @keydown.escape.stop="close()" />

                        <button x-show="open && query"
                                type="button"
                                class="ml-2 text-gray-400 hover:text-gray-600"
                                @click="clear()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 0 1 1.414 0L10 8.586l4.293-4.293a1 1 0 1 1 1.414 1.414L11.414 10l4.293 4.293a1 1 0 0 1-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 0 1-1.414-1.414L8.586 10 4.293 5.707a1 1 0 0 1 0-1.414Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div x-show="open"
                         x-cloak
                         @click.outside="close()"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute right-0 mt-2 w-96 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100 flex items-center space-x-2">
                            <div class="bg-blue-50 text-[#0481AE] rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.65 5.65a7.5 7.5 0 0 0 11 11Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-900" x-text="query ? `{{ t('frontend.search.searching_for', 'Searching for') }} \"${query}\"` : '{{ t('frontend.search.title', 'Search our site') }}'"></p>
                                <p class="text-xs text-gray-500">{{ t('frontend.search.subtitle', 'Services, team, articles, and contact info') }}</p>
                            </div>
                            <span class="text-[11px] text-gray-400 border border-gray-200 rounded px-2 py-1">Esc</span>
                        </div>

                        <div class="max-h-96 overflow-y-auto divide-y divide-gray-100">
                            <template x-if="loading">
                                <div class="p-4 text-sm text-gray-600 flex items-center space-x-2">
                                    <svg class="animate-spin h-4 w-4 text-[#0481AE]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"></path>
                                    </svg>
                                    <span>{{ t('frontend.search.loading', 'Loading search index...') }}</span>
                                </div>
                            </template>

                            <template x-if="error">
                                <div class="p-4 text-sm text-red-600" x-text="error"></div>
                            </template>

                            <template x-if="!loading && !error && !hasResults">
                                <div class="p-4 text-sm text-gray-600">{{ t('frontend.search.no_results', 'No matches found. Try another term.') }}</div>
                            </template>

                            <template x-for="group in groupedResults" :key="group.key">
                                <div x-show="group.items.length" class="p-3 space-y-2">
                                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide" x-text="group.label"></p>
                                    <template x-for="item in group.items" :key="item.url">
                                        <a :href="item.url"
                                           class="flex items-start space-x-3 p-2 rounded-lg hover:bg-blue-50">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#0481AE] bg-blue-50">
                                                <span class="text-xs font-semibold" x-text="item.type.charAt(0)"></span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-900" x-text="item.title"></p>
                                                <p class="text-xs text-gray-600" x-text="item.subtitle"></p>
                                            </div>
                                            <span class="text-xs text-gray-400">↗</span>
                                        </a>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <x-language-switcher />
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="text-gray-700 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="md:hidden border-t border-gray-200 bg-white"
         style="display: none;">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <div class="py-2">
                <x-language-switcher />
            </div>
            <a href="{{ route('home') }}"
               class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-[#0481AE] {{ request()->routeIs('home') ? 'bg-blue-50 text-[#0481AE]' : '' }}">
                {{ t('frontend.navigation.home', 'Home') }}
            </a>
            <a href="{{ route('about') }}" 
               class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-[#0481AE] {{ request()->routeIs('about') ? 'bg-blue-50 text-[#0481AE]' : '' }}">
                About
            </a>

            <!-- Mobile Services -->
            <div x-data="{ expanded: false }">
                <div class="flex items-center justify-between pr-3">
                    <a href="{{ route('services.index') }}" 
                       class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-[#0481AE] {{ request()->routeIs('services.*') ? 'bg-blue-50 text-[#0481AE]' : '' }}">
                        {{ t('frontend.navigation.services', 'Services') }}
                    </a>
                    <button @click="expanded = !expanded" class="p-2 text-gray-500 hover:text-[#0481AE]">
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
                <div x-show="expanded" class="pl-6 space-y-1 bg-gray-50" x-collapse>
                    @foreach($navServices as $service)
                        <a href="{{ route('services.show', $service->slug) }}" class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:text-[#0481AE]">
                            {{ $service->title }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Mobile Industries -->
            <div x-data="{ expanded: false }">
                <div class="flex items-center justify-between pr-3">
                    <a href="{{ route('industries.index') }}"
                       class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-[#0481AE] {{ request()->routeIs('industries.*') ? 'bg-blue-50 text-[#0481AE]' : '' }}">
                        {{ t('frontend.navigation.industries', 'Industries') }}
                    </a>
                    <button @click="expanded = !expanded" class="p-2 text-gray-500 hover:text-[#0481AE]">
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
                <div x-show="expanded" class="pl-6 space-y-1 bg-gray-50" x-collapse>
                    @foreach($navIndustries as $industry)
                        <a href="{{ route('industries.index') }}#industry-{{ $industry->id }}" class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:text-[#0481AE]">
                            {{ $industry->title }}
                        </a>
                    @endforeach
                </div>
            </div>
            {{-- <a href="{{ route('team') }}" 
               class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-[#0481AE] {{ request()->routeIs('team') ? 'bg-blue-50 text-[#0481AE]' : '' }}">
                Team
            </a> --}}
            <a href="{{ route('blog.index') }}" 
               class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-[#0481AE] {{ request()->routeIs('blog.*') ? 'bg-blue-50 text-[#0481AE]' : '' }}">
                {{ t('frontend.navigation.blog', 'Blog') }}
            </a>
            <a href="{{ route('contact') }}"
               class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-[#0481AE] {{ request()->routeIs('contact') ? 'bg-blue-50 text-[#0481AE]' : '' }}">
                {{ t('frontend.navigation.contact', 'Contact') }}
            </a>
            <a href="{{ route('contact') }}" 
               class="block px-3 py-2 mt-2 bg-[#0481AE] text-white rounded-lg text-center hover:bg-[#036494]">
                Get Started
            </a>
        </div>
    </div>
</nav>
