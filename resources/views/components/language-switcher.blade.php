@php
    $languages = \App\Models\Language::active()->orderBy('label')->get();
    $currentLocale = session('locale', app()->getLocale() ?? 'en');
    $currentLabel = optional($languages->firstWhere('code', $currentLocale))->label ?? strtoupper($currentLocale);
@endphp

@if ($languages->count() > 0)
    <div x-data="{ open: false }" class="relative">
        <button type="button" @click="open = !open" @click.away="open = false" class="inline-flex items-center px-3 py-2 border border-slate-200 rounded-lg bg-white text-sm font-medium text-slate-700 hover:bg-slate-50 shadow-sm">
            <span class="mr-2">{{ $currentLabel }}</span>
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-cloak x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 z-50">
            <div class="py-2">
                @foreach ($languages as $language)
                    <a href="{{ route('set-locale', $language->code) }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 {{ $currentLocale === $language->code ? 'font-semibold text-blue-600' : '' }}">
                        <span class="mr-2 w-2 h-2 rounded-full {{ $currentLocale === $language->code ? 'bg-blue-500' : 'bg-slate-300' }}"></span>
                        {{ $language->label }} ({{ strtoupper($language->code) }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif
