<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Victory CMS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-50">
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="min-h-screen flex bg-slate-100">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Header -->
            @include('admin.partials.header')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto space-y-6">
                    <!-- Page Heading -->
                    @if (isset($header))
                        <div class="flex items-center justify-between flex-wrap gap-3 bg-white border border-gray-200 shadow-sm rounded-2xl px-5 py-4">
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $header }}</h1>
                                @hasSection('page-description')
                                    <p class="text-sm text-gray-600">@yield('page-description')</p>
                                @endif
                            </div>
                            @yield('page-actions')
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
</body>
</html>
