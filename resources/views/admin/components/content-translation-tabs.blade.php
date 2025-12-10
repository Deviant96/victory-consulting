@props([
    'languages',
    'fields' => [],
    'model' => null,
])

@php
    $fallback = config('app.fallback_locale', 'en');
    $translatableLanguages = $languages->where('code', '!=', $fallback);
    $defaultActive = $translatableLanguages->first()?->code ?? null;
@endphp

@if($translatableLanguages->isNotEmpty())
    <div class="bg-white border border-gray-200 rounded-xl" x-data="{ activeTab: '{{ $defaultActive }}' }">
        <div class="flex flex-wrap gap-2 px-4 pt-4 border-b border-gray-200">
            @foreach ($translatableLanguages as $language)
                <button type="button"
                        @click="activeTab = '{{ $language->code }}'"
                        :class="activeTab === '{{ $language->code }}' ? 'bg-white text-indigo-700 border-indigo-300' : 'text-gray-600'"
                        class="px-3 py-2 text-sm font-semibold rounded-t-lg border border-transparent">
                    {{ $language->label }} ({{ strtoupper($language->code) }})
                </button>
            @endforeach
        </div>

        <div class="p-4 space-y-6 bg-gray-50 rounded-b-xl">
            <p class="text-sm text-gray-600">Base language ({{ strtoupper($fallback) }}) is stored in the main fields above. Use these tabs to supply translations for additional languages.</p>

            @foreach ($translatableLanguages as $language)
                <div x-show="activeTab === '{{ $language->code }}'" class="space-y-4">
                    @foreach ($fields as $field => $label)
                        @php
                            $existing = optional($model?->translations)
                                ?->first(fn ($translation) => $translation->language_code === $language->code && $translation->field === $field)
                                ?->value ?? '';
                            $value = old('translations.' . $language->code . '.' . $field, $existing);
                        @endphp

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">{{ $label }} ({{ strtoupper($language->code) }})</label>
                            <textarea name="translations[{{ $language->code }}][{{ $field }}]"
                                      rows="{{ $field === 'content' ? 15 : 3 }}"
                                      class="mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 {{ $field === 'content' ? 'rich-text' : '' }}"
                                      placeholder="Enter {{ strtolower($label) }} translation">{{ $value }}</textarea>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endif
