@php
    $languages = \App\Models\Language::where('is_active', true)->orderBy('label')->get();
    $currentLocale = session('locale', app()->getLocale());
@endphp

@if($languages->count() > 1)
    <div x-data="{ open: false }"
         @keydown.escape.window="open = false"
         class="relative w-full sm:w-auto">
        <button type="button"
                @click="open = !open"
                @click.outside="open = false"
                :aria-expanded="open.toString()"
                aria-haspopup="listbox"
                class="group inline-flex items-center w-full sm:w-auto justify-between sm:justify-start gap-2 px-3 sm:px-3 py-2 rounded-full border border-gray-200 bg-white shadow-sm hover:border-[#0481AE] hover:shadow-md transition text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0481AE]">
            <span class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="Earth-Refresh--Streamline-Ultimate" height="24" width="24">
                    <desc>
                        Change language. Source: https://streamlinehq.com
                    </desc>
                    <g id="Earth-Refresh--Streamline-Ultimate.svg">
                        <path d="M22.55 18.71a1 1 0 0 0 -1.24 0.61 4 4 0 0 1 -6.6 1.58 0.51 0.51 0 0 1 -0.15 -0.35 0.47 0.47 0 0 1 0.15 -0.35l1.51 -1.52a0.48 0.48 0 0 0 0.11 -0.53 0.49 0.49 0 0 0 -0.45 -0.3h-4.37a0.49 0.49 0 0 0 -0.49 0.49v4.37a0.5 0.5 0 0 0 0.3 0.45 0.51 0.51 0 0 0 0.54 -0.11l0.77 -0.77a0.5 0.5 0 0 1 0.69 0A6 6 0 0 0 23.16 20a1 1 0 0 0 -0.61 -1.29Z" fill="#000000" stroke-width="1"></path>
                        <path d="M9 23.13a0.45 0.45 0 0 0 0.37 -0.08 0.42 0.42 0 0 0 0.17 -0.34v-1.1a0.48 0.48 0 0 0 -0.35 -0.47 9.82 9.82 0 0 1 -1.61 -0.64v-1.28a2.47 2.47 0 0 1 0.87 -1.88 4.4 4.4 0 0 0 -2.82 -7.78H2.46A9.81 9.81 0 0 1 12 2a9.69 9.69 0 0 1 5.53 1.72h-3.32a2.7 2.7 0 1 0 0 5.39 2.52 2.52 0 0 1 1.84 0.82 6.75 6.75 0 0 1 1.19 -0.1 7.39 7.39 0 0 1 4.23 1.33 0.32 0.32 0 0 0 0.41 0 2 2 0 0 1 1.39 -0.57 0.37 0.37 0 0 0 0.28 -0.13 0.36 0.36 0 0 0 0.09 -0.3 11.76 11.76 0 0 0 -23.4 1.6C0.24 13 0.76 21 9 23.13Z" fill="#000000" stroke-width="1"></path>
                        <path d="M23.76 12.47a0.48 0.48 0 0 0 -0.3 -0.45 0.49 0.49 0 0 0 -0.54 0.1l-0.83 0.83a0.49 0.49 0 0 1 -0.69 0 6 6 0 0 0 -9.82 2.35 1 1 0 0 0 0.61 1.24 1 1 0 0 0 1.24 -0.61 4 4 0 0 1 6.57 -1.6 0.49 0.49 0 0 1 0.15 0.35 0.52 0.52 0 0 1 -0.15 0.32l-1.45 1.45a0.49 0.49 0 0 0 0.34 0.84h4.37a0.49 0.49 0 0 0 0.49 -0.49Z" fill="#000000" stroke-width="1"></path>
                    </g>
                </svg>
                <span class="font-semibold uppercase tracking-wide bg-[#0481AE]/10 text-[#0481AE] px-2 py-1 rounded-full text-xs">
                    {{ $currentLocale }}
                </span>
            </span>
            <svg class="w-4 h-4 text-gray-500 transition-transform duration-150" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        @else
                            <span class="w-4 h-4"></span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif
