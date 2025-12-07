@php
    $languages = \App\Models\Language::where('is_active', true)->orderBy('label')->get();
    $currentLocale = session('locale', app()->getLocale());
@endphp

@if($languages->count() > 1)
    <div x-data="{ open: false }" class="relative">
        <button type="button" @click="open = !open" @click.away="open = false"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.657-1.567 3-3.5 3S5 12.657 5 11s1.567-3 3.5-3S12 9.343 12 11zm0 0c0 1.657 1.567 3 3.5 3S19 12.657 19 11s-1.567-3-3.5-3S12 9.343 12 11zm0 0v9" />
            </svg>
            <span class="font-semibold uppercase">{{ $currentLocale }}</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50" style="display: none;">
            <div class="py-2">
                @foreach($languages as $language)
                    <a href="{{ route('set-locale', $language->code) }}" class="flex items-center px-4 py-2 text-sm hover:bg-gray-50 {{ $currentLocale === $language->code ? 'font-semibold text-indigo-700' : 'text-gray-700' }}">
                        <span class="w-6 inline-block font-mono uppercase">{{ $language->code }}</span>
                        <span class="ml-2">{{ $language->label }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif
