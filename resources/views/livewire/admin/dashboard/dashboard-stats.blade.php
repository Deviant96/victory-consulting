{{-- Livewire Dashboard Stats Component --}}
<div wire:poll.{{ $refreshInterval }}ms="loadStats">
    {{-- Hero Section --}}
    <section class="grid gap-6 xl:grid-cols-3 mb-8">
        {{-- Main Hero Card --}}
        <div x-data="{ open: true }" class="xl:col-span-2 bg-gradient-to-br from-indigo-700 via-blue-700 to-sky-600 text-white rounded-3xl shadow-xl ring-1 ring-white/10 p-6 sm:p-8 relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_45%)] pointer-events-none"></div>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 relative">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Admin overview</p>
                    <h1 class="text-2xl sm:text-3xl font-semibold drop-shadow">Welcome back</h1>
                    <p class="text-sm text-blue-100/90 max-w-xl">Monitor performance, curate fresh content, and keep communication flowing smoothly—all from one streamlined dashboard.</p>
                </div>
                
                <div class="bg-white/15 backdrop-blur border border-white/30 rounded-2xl px-4 py-3 w-full sm:w-64 shadow-lg shadow-blue-900/20">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-blue-50">Pending bookings</span>
                        <span class="text-white font-semibold">{{ number_format($bookingStatusCounts['pending'] ?? 0) }}</span>
                    </div>
                    <div class="mt-3 h-2 rounded-full bg-white/25 overflow-hidden">
                        <div class="h-full bg-white rounded-full shadow-inner shadow-blue-900/40" 
                             style="width: {{ $this->getBookingCompletionPercentage() }}%"
                             wire:loading.class="animate-pulse"></div>
                    </div>
                    <p class="mt-3 text-xs text-blue-50">Stay responsive to requests and keep prospects moving forward.</p>
                </div>
                
                <button @click="open = !open" class="absolute top-2 right-2 text-blue-50/80 hover:text-white transition" title="Toggle card">
                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-3" x-show="open" x-transition.opacity x-cloak>
                <div class="bg-white/15 border border-white/20 rounded-2xl p-3 shadow-sm shadow-blue-900/10">
                    <p class="text-xs text-blue-50">Services live</p>
                    <p class="text-xl font-semibold">{{ number_format($stats['services'] ?? 0) }}</p>
                </div>
                <div class="bg-white/15 border border-white/20 rounded-2xl p-3 shadow-sm shadow-blue-900/10">
                    <p class="text-xs text-blue-50">Published articles</p>
                    <p class="text-xl font-semibold">{{ number_format($stats['articles'] ?? 0) }}</p>
                </div>
                <div class="bg-white/15 border border-white/20 rounded-2xl p-3 shadow-sm shadow-blue-900/10">
                    <p class="text-xs text-blue-50">FAQs maintained</p>
                    <p class="text-xl font-semibold">{{ number_format($stats['faqs'] ?? 0) }}</p>
                </div>
                <div class="bg-white/15 border border-white/20 rounded-2xl p-3 shadow-sm shadow-blue-900/10">
                    <p class="text-xs text-blue-50">Bookings logged</p>
                    <p class="text-xl font-semibold">{{ number_format($stats['bookings'] ?? 0) }}</p>
                </div>
            </div>
        </div>

        {{-- Today Card --}}
        <div x-data="{ open: true }" class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6 flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Today</p>
                    <h3 class="text-lg font-semibold text-gray-900">Operations snapshot</h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-full">
                        <span wire:loading.remove>Live</span>
                        <span wire:loading>Updating...</span>
                    </span>
                    <button wire:click="refresh" class="p-1.5 rounded-lg hover:bg-gray-100 transition" title="Refresh">
                        <svg class="w-4 h-4 text-gray-500" wire:loading.class="animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </button>
                    <button @click="open = !open" class="text-gray-400 hover:text-gray-700 transition" title="Toggle card">
                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="space-y-3" x-show="open" x-transition.opacity x-cloak>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <p class="text-sm text-gray-700">Content pieces</p>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">{{ number_format(($stats['articles'] ?? 0) + ($stats['faqs'] ?? 0)) }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <p class="text-sm text-gray-700">Active clients</p>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">{{ number_format($stats['bookings'] ?? 0) }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <p class="text-sm text-gray-700">Team collaborators</p>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">{{ number_format($stats['team'] ?? 0) }}</p>
                </div>
            </div>
            
            <div class="rounded-2xl bg-gray-50 border border-dashed border-gray-200 px-4 py-3" x-show="open" x-transition.opacity x-cloak>
                <p class="text-sm text-gray-700 font-medium">Next actions</p>
                <p class="text-xs text-gray-500 mt-1">Review bookings, add fresh content, and keep FAQs concise.</p>
            </div>
        </div>
    </section>

    {{-- Loading Indicator --}}
    <div wire:loading.delay class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white px-4 py-2 rounded-full shadow-lg z-50 flex items-center gap-2">
        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-sm">Loading...</span>
    </div>
</div>
