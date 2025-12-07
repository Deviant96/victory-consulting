@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <livewire:admin.dashboard.dashboard-stats />
    
    {{-- Quick Actions Section (Kept from original) --}}
    @php
        $quickActions = [
            [
                'title' => 'Create service',
                'description' => 'Add a new offering and publish it instantly.',
                'href' => route('admin.services.create'),
                'color' => 'blue',
                'icon' => 'M12 4v16m8-8H4',
            ],
            [
                'title' => 'Add team member',
                'description' => 'Keep your leadership and delivery roster current.',
                'href' => route('admin.team.create'),
                'color' => 'emerald',
                'icon' => 'M5 13l4 4L19 7',
            ],
            [
                'title' => 'Publish article',
                'description' => 'Share new insights with the community.',
                'href' => route('admin.articles.create'),
                'color' => 'purple',
                'icon' => 'M12 6v12m6-6H6',
            ],
            [
                'title' => 'Update settings',
                'description' => 'Refresh contact, social, and branding details.',
                'href' => route('admin.settings.index'),
                'color' => 'amber',
                'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
            ],
        ];
    @endphp

    <section class="mt-8">
        <div x-data="{ open: true }" class="mb-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-700">Quick actions</h3>
                <button @click="open = !open" class="text-gray-400 hover:text-gray-700 transition" title="Toggle section">
                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div x-data="{ open: true }" x-show="open" x-transition.opacity class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach ($quickActions as $action)
                <a href="{{ $action['href'] }}" 
                   class="group relative overflow-hidden bg-white border border-gray-200 rounded-2xl shadow-sm p-6 transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition bg-gradient-to-br from-{{ $action['color'] }}-50 via-white to-white pointer-events-none"></div>
                    <div class="relative flex items-start gap-4">
                        <div class="shrink-0 flex items-center justify-center w-12 h-12 rounded-2xl bg-{{ $action['color'] }}-100 text-{{ $action['color'] }}-600 group-hover:scale-110 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ $action['title'] }}</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">{{ $action['description'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
