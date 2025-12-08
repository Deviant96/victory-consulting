@extends('admin.layouts.app')

@section('title', 'Translations')
@section('page-title', 'Translations')

@section('content')
    @php
        $languageMeta = $languages->map(fn($language) => [
            'code' => $language->code,
            'label' => $language->label,
        ]);

        $rows = $translationKeys
            ->map(function ($translationKey) use ($languages, $fallbackLocale) {
                return [
                    'id' => $translationKey->id,
                    'group' => $translationKey->group,
                    'key' => $translationKey->key,
                    'preview' => $translationKey->valueForLocale($fallbackLocale) ?? '',
                    'values' => $languages
                        ->mapWithKeys(function ($language) use ($translationKey) {
                            $value = optional($translationKey->values->firstWhere('language_code', $language->code))->value ?? '';

                            return [$language->code => $value];
                        })
                        ->toArray(),
                ];
            })
            ->values()
            ->toArray();
    @endphp

    <div class="space-y-6" x-data="translationGrid({
        languages: @json($languageMeta),
        rows: @json($rows),
        groups: @json($groups),
        fallback: '{{ $fallbackLocale }}',
        updateUrl: '{{ route('admin.translations.inline', '__ID__') }}',
        csrf: '{{ csrf_token() }}'
    })">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm text-gray-600">Manage static labels for admin and frontend with quick inline edits.</p>
                <p class="text-xs text-gray-500">Use <code class="font-mono text-indigo-700">"{{ t('your.key') }}"</code> inside Blade. Values save automatically.</p>
            </div>
            <div class="flex gap-2 items-center">
                <a href="{{ route('admin.translations.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Translation Key
                </a>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-4">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="flex gap-3 items-center">
                    <div class="relative">
                        <input type="search" x-model.debounce.300ms="filters.search" @input="applyFilters" placeholder="Search key or value" class="w-72 rounded-lg border-gray-300 pl-9 focus:border-indigo-500 focus:ring-indigo-500">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                    </div>
                    <div>
                        <select x-model="filters.group" @change="applyFilters" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="all">All groups</option>
                            <template x-for="group in groups" :key="group">
                                <option :value="group" x-text="group"></option>
                            </template>
                        </select>
                    </div>
                </div>
                <div class="text-xs text-gray-500" x-show="lastNotice" x-text="lastNotice"></div>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="sticky left-0 bg-gray-50 z-10 px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider shadow">Key</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Preview ({{ strtoupper($fallbackLocale) }})</th>
                            @foreach ($languages as $language)
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">{{ $language->label }} ({{ strtoupper($language->code) }})</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" x-show="filteredRows.length">
                        <template x-for="row in filteredRows" :key="row.id">
                            <tr class="hover:bg-indigo-50/40 transition-colors">
                                <td class="sticky left-0 bg-white px-4 py-3 align-top shadow">
                                    <div class="text-xs uppercase text-gray-500" x-text="row.group ?? '—'"></div>
                                    <div class="font-semibold text-gray-900" x-text="row.key"></div>
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-indigo-50 text-indigo-700">{{ strtoupper($fallbackLocale) }}</span>
                                        <span class="line-clamp-2" x-text="row.preview || 'No value yet'"></span>
                                    </div>
                                </td>
                                @foreach ($languages as $language)
                                    <td class="px-4 py-3 align-top">
                                        <div class="relative">
                                            <textarea rows="2" x-model="row.values['{{ $language->code }}']" @input.debounce.700ms="saveCell(row, '{{ $language->code }}')" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                                            <div class="absolute right-2 bottom-2 flex items-center gap-2 text-xs" x-show="isSaving(row.id, '{{ $language->code }}')">
                                                <svg class="w-4 h-4 text-indigo-500 animate-spin" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4z"></path>
                                                </svg>
                                                <span class="text-indigo-600">Saving…</span>
                                            </div>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        </template>
                    </tbody>
                    <tbody x-show="!filteredRows.length">
                        <tr>
                            <td colspan="{{ $languages->count() + 2 }}" class="px-6 py-6 text-center text-sm text-gray-500">No translations match your filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 border-t border-gray-100 pt-4 flex items-center justify-between text-sm text-gray-600">
                <div>Showing {{ $translationKeys->count() }} of {{ $translationKeys->total() }} keys</div>
                <div>{{ $translationKeys->links() }}</div>
            </div>
        </div>
    </div>
@endsection
