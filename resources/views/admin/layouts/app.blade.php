<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="vapid-public-key" content="{{ config('services.webpush.vapid_public_key') }}">

    <title>@yield('title', 'Dashboard') - Victory CMS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            @include('admin.partials.header')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Page Heading -->
                @if (isset($header))
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ $header }}
                        </h1>
                    </div>
                @endif

                <!-- Flash Messages -->
                @if (session()->has('success') || session()->has('error'))
                    <div class="mb-6 space-y-3">
                        @foreach (['success' => 'green', 'error' => 'red'] as $type => $color)
                            @if (session($type))
                                <div
                                    x-data="{ show: true }"
                                    x-init="setTimeout(() => show = false, 4000)"
                                    x-show="show"
                                    x-transition.opacity.scale.duration.300ms
                                    class="flex items-start gap-3 bg-{{$color}}-50 border border-{{$color}}-200 text-{{$color}}-800 px-4 py-3 rounded-lg shadow-sm"
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
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
