@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'settings' => null,
    'languages' => null,
    'rows' => 3,
    'required' => false,
])

@php
    $fallback = config('app.fallback_locale', 'en');
    $translatableLanguages = $languages ? $languages->where('code', '!=', $fallback) : collect();
    $settingKey = str_contains($name, '[') ? str_replace(['[', ']'], ['.', ''], $name) : $name;
    $fieldName = explode('.', $settingKey)[1] ?? $settingKey;
    $uniqueId = 'field_' . md5($name);
@endphp

<div x-data="{ showTranslations: false }">
    <!-- Base Language Field -->
    <div>
        <div class="flex items-center justify-between mb-2">
            <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
                {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
            </label>
            
            @if($translatableLanguages->isNotEmpty())
                <button 
                    type="button"
                    @click="showTranslations = !showTranslations"
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-md transition"
                >
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                    </svg>
                    <span x-text="showTranslations ? 'Hide translations' : 'Add translations'"></span>
                    <svg class="w-3.5 h-3.5 ml-1 transition-transform" :class="showTranslations ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            @endif
        </div>
        
        @if($type === 'textarea')
            <textarea 
                name="{{ $name }}" 
                id="{{ $name }}" 
                rows="{{ $rows }}"
                {{ $required ? 'required' : '' }}
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500"
            >{{ old($settingKey, optional($settings?->get($settingKey))->value ?? $value) }}</textarea>
        @else
            <input 
                type="{{ $type }}" 
                name="{{ $name }}" 
                id="{{ $name }}" 
                value="{{ old($settingKey, optional($settings?->get($settingKey))->value ?? $value) }}"
                {{ $required ? 'required' : '' }}
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500"
            />
        @endif
    </div>

    <!-- Translation Fields (Collapsible) -->
    @if($translatableLanguages->isNotEmpty())
        <div 
            x-show="showTranslations" 
            x-collapse
            class="mt-3 space-y-2 pl-4 border-l-2 border-blue-200 bg-gradient-to-r from-blue-50/50 to-transparent rounded-r-lg py-3 pr-3"
        >
            @foreach($translatableLanguages as $language)
                @php
                    $setting = $settings?->get($settingKey);
                    $existing = '';
                    if ($setting) {
                        $translation = optional($setting->translations)
                            ->first(fn ($t) => $t->language_code === $language->code && $t->field === $fieldName);
                        $existing = $translation ? $translation->value : '';
                    }
                    $translationValue = old('translations.' . $language->code . '.' . $fieldName, $existing);
                @endphp
                
                <div>
                    <label for="translation_{{ $language->code }}_{{ $fieldName }}" class="block text-xs font-medium text-blue-700 mb-1">
                        {{ $language->label }} ({{ strtoupper($language->code) }})
                    </label>
                    
                    @if($type === 'textarea')
                        <textarea 
                            name="translations[{{ $language->code }}][{{ $fieldName }}]" 
                            id="translation_{{ $language->code }}_{{ $fieldName }}" 
                            rows="{{ $rows }}"
                            placeholder="Enter {{ strtolower($label) }} in {{ $language->label }}"
                            class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-400 focus:border-blue-400 bg-white text-sm"
                        >{{ $translationValue }}</textarea>
                    @else
                        <input 
                            type="{{ $type }}" 
                            name="translations[{{ $language->code }}][{{ $fieldName }}]" 
                            id="translation_{{ $language->code }}_{{ $fieldName }}" 
                            value="{{ $translationValue }}"
                            placeholder="Enter {{ strtolower($label) }} in {{ $language->label }}"
                            class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-blue-400 focus:border-blue-400 bg-white text-sm"
                        />
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
