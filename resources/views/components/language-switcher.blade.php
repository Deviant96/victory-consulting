@props(['transparent' => false])

@php
    $languages = \App\Models\Language::where('is_active', true)->orderBy('label')->get();
    $currentLocale = session('locale', app()->getLocale());
@endphp

@if($languages->count() > 1)
<div x-data="{ open: false }" 
     class="relative w-full sm:w-auto">
    <button type="button" 
            @click="open = !open" 
            @click.outside="open = false"
            title="Switch Language"
            :class="{ 
                'bg-white text-gray-700 border-gray-200': {{ $transparent ? 'scrolled || open || !sticky' : 'true' }}, 
                'bg-white/10 text-white border-white/20 hover:bg-white/20': {{ $transparent ? '!scrolled && !open && sticky' : 'false' }} 
            }"
            class="group inline-flex items-center justify-center gap-2 px-3 py-2 rounded-full border shadow-sm transition-all duration-300 text-sm focus:outline-none">
        
        <!-- Globe Icon -->
        <svg :class="{ 'text-gray-900': {{ $transparent ? 'scrolled || open || !sticky' : 'true' }}, 'text-white': {{ $transparent ? '!scrolled && !open && sticky' : 'false' }} }" 
             class="w-5 h-5 transition-colors duration-300" 
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <span :class="{ 'text-[#0481AE] bg-[#0481AE]/10': {{ $transparent ? 'scrolled || open || !sticky' : 'true' }}, 'text-white bg-white/20': {{ $transparent ? '!scrolled && !open && sticky' : 'false' }} }"
              class="font-semibold uppercase tracking-wide px-2 py-0.5 rounded-full text-xs transition-colors duration-300">
            {{ $currentLocale }}
        </span>

        <svg :class="{ 'rotate-180': open, 'text-gray-500': {{ $transparent ? 'scrolled || open || !sticky' : 'true' }}, 'text-white': {{ $transparent ? '!scrolled && !open && sticky' : 'false' }} }"
             class="w-4 h-4 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1"
         class="absolute right-0 mt-2 w-full sm:w-56 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden"
         style="display: none;">
        <div class="py-2" role="listbox">
            @foreach($languages as $language)
                <a href="{{ route('set-locale', $language->code) }}"
                   class="flex items-center justify-between gap-2 px-4 py-2 text-sm transition hover:bg-blue-50 {{ $currentLocale === $language->code ? 'bg-blue-50 text-[#0481AE] font-semibold' : 'text-gray-800' }}">
                    <div class="flex items-center gap-2">
                        <span class="w-8 inline-flex justify-center font-mono uppercase text-xs text-gray-600">{{ $language->code }}</span>
                        <span>{{ $language->label }}</span>
                    </div>
                    @if($currentLocale === $language->code)
                        <svg class="w-4 h-4 text-[#0481AE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4 10-10" />
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif
