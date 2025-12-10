@props(['languages', 'model'])

@php
    $fallback = config('app.fallback_locale', 'en');
@endphp

<div class="flex flex-wrap gap-1 mt-2">
    @foreach($languages as $language)
        @php
            $isFallback = $language->code === $fallback;
            $hasTranslation = $isFallback || $model->translations->where('language_code', $language->code)->isNotEmpty();
            $colorClass = $hasTranslation 
                ? 'bg-blue-100 text-blue-800 border-blue-200' 
                : 'bg-gray-100 text-gray-400 border-gray-200 opacity-50';
        @endphp
        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium border {{ $colorClass }}" title="{{ $language->label }}">
            {{ strtoupper($language->code) }}
        </span>
    @endforeach
</div>
