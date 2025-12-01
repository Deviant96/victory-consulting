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
                   class="text-gray-700 hover:text-blue-600 transition-colors {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">
                    Home
                </a>
                <a href="{{ route('services.index') }}" 
                   class="text-gray-700 hover:text-blue-600 transition-colors {{ request()->routeIs('services.*') ? 'text-blue-600 font-semibold' : '' }}">
                    Services
                </a>
                <a href="{{ route('team') }}" 
                   class="text-gray-700 hover:text-blue-600 transition-colors {{ request()->routeIs('team') ? 'text-blue-600 font-semibold' : '' }}">
                    Team
                </a>
                <a href="{{ route('blog.index') }}" 
                   class="text-gray-700 hover:text-blue-600 transition-colors {{ request()->routeIs('blog.*') ? 'text-blue-600 font-semibold' : '' }}">
                    Blog
                </a>
                <a href="{{ route('contact') }}" 
                   class="text-gray-700 hover:text-blue-600 transition-colors {{ request()->routeIs('contact') ? 'text-blue-600 font-semibold' : '' }}">
                    Contact
                </a>
            </div>

            <!-- CTA Button -->
            <div class="hidden md:block">
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Get Started
                </a>
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
            <a href="{{ route('home') }}" 
               class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">
                Home
            </a>
            <a href="{{ route('services.index') }}" 
               class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600 {{ request()->routeIs('services.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                Services
            </a>
            <a href="{{ route('team') }}" 
               class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600 {{ request()->routeIs('team') ? 'bg-blue-50 text-blue-600' : '' }}">
                Team
            </a>
            <a href="{{ route('blog.index') }}" 
               class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600 {{ request()->routeIs('blog.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                Blog
            </a>
            <a href="{{ route('contact') }}" 
               class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50 hover:text-blue-600 {{ request()->routeIs('contact') ? 'bg-blue-50 text-blue-600' : '' }}">
                Contact
            </a>
            <a href="{{ route('contact') }}" 
               class="block px-3 py-2 mt-2 bg-blue-600 text-white rounded-lg text-center hover:bg-blue-700">
                Get Started
            </a>
        </div>
    </div>
</nav>
