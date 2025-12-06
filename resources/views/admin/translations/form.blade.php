<div class="space-y-6" x-data="{ activeTab: '{{ $languages->first()->code ?? 'en' }}' }">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700">Group</label>
            <input type="text" name="group" value="{{ old('group', $translationKey->group ?? '') }}" placeholder="admin" class="mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            <p class="text-xs text-gray-500 mt-1">Optional category such as admin or frontend.</p>
            @error('group')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700">Key</label>
            <input type="text" name="key" value="{{ old('key', $translationKey->key ?? '') }}" placeholder="admin.dashboard.title" class="mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
            @error('key')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="bg-gray-50 border border-gray-200 rounded-xl">
        <div class="flex flex-wrap gap-2 px-4 pt-4 border-b border-gray-200">
            @foreach ($languages as $language)
                <button type="button" @click="activeTab = '{{ $language->code }}'" :class="activeTab === '{{ $language->code }}' ? 'bg-white text-indigo-700 border-indigo-300' : 'text-gray-600'" class="px-3 py-2 text-sm font-semibold rounded-t-lg border border-transparent">
                    {{ $language->label }} ({{ strtoupper($language->code) }})
                </button>
            @endforeach
        </div>
        <div class="p-4 bg-white rounded-b-xl">
            @foreach ($languages as $language)
                @php
                    $value = old('translations.' . $language->code, optional($translationKey->values->firstWhere('language_code', $language->code))->value ?? '');
                @endphp
                <div x-show="activeTab === '{{ $language->code }}'">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ $language->label }} value</label>
                    <textarea name="translations[{{ $language->code }}]" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter translation">{{ $value }}</textarea>
                </div>
            @endforeach
        </div>
    </div>
</div>
