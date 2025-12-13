<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Victory CMS</title>

    <!-- Favicon -->
    @if(settings('branding.favicon'))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . settings('branding.favicon')) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">

    @stack('styles')
</head>
<body class="font-sans antialiased admin-shell" x-data="adminLayout()">
    <div class="flex min-h-screen">
        <!-- Mobile Backdrop -->
        <div x-cloak x-show="sidebarOpen && window.innerWidth < 1024" x-transition.opacity class="fixed inset-0 bg-black/40 z-30 lg:hidden" @click="closeSidebar()"></div>

        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Header -->
            @include('admin.partials.header')

            <!-- Search Modal -->
            @include('admin.partials.search-modal')

            <!-- Page Content -->
            <main class="flex-1 py-8">
                <div class="admin-container space-y-6">
                    <!-- Page Heading -->
                    @if (isset($header))
                        <div class="mb-2">
                            <h1 class="text-3xl font-bold text-slate-900">
                                {{ $header }}
                            </h1>
                        </div>
                    @endif

                    <!-- Flash Messages -->
                    @if (session()->has('success') || session()->has('error'))
                        <div class="space-y-3">
                            @foreach (['success' => 'green', 'error' => 'red'] as $type => $color)
                                @if (session($type))
                                    <div
                                        x-data="{ show: true }"
                                        x-init="setTimeout(() => show = false, 4000)"
                                        x-show="show"
                                        x-transition.opacity.scale.duration.300ms
                                        class="flex items-start gap-3 bg-{{$color}}-50 border border-{{$color}}-200 text-{{$color}}-800 px-4 py-3 rounded-xl shadow-sm"
                                    >
                                        <div class="mt-0.5">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="flex-1 text-sm">{{ session($type) }}</p>
                                        <button type="button" @click="show = false" class="text-{{$color}}-700 hover:text-{{$color}}-900 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <!-- Main Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                allowInput: true,
            });
            
            flatpickr(".datetimepicker", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                allowInput: true,
            });
        });
    </script>
</body>
</html>
