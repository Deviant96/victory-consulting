@extends('admin.layouts.app')

@section('title', 'Translations')
@section('page-title', 'Translations')

@section('content')
    <div class="flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-600">Manage static labels for admin and frontend.</p>
        </div>
        <a href="{{ route('admin.translations.create') }}"
            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Translation Key
        </a>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
        <div class="px-6 py-4 border-b border-gray-100 bg-indigo-50/50 text-sm text-indigo-900">
            Use <code class="font-mono text-indigo-700">"{{ t('your.key') }}"</code> inside Blade to pull translations for the current locale with automatic English fallback.
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Group</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Key</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Preview ({{ strtoupper($fallbackLocale) }})</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Translations</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($translationKeys as $translationKey)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $translationKey->group ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $translationKey->key }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if ($translationKey->preview)
                                    <span title="{{ $translationKey->preview }}">{{ $translationKey->preview }}</span>
                                @else
                                    <span class="text-gray-400">No {{ strtoupper($fallbackLocale) }} value yet</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($languages as $language)
                                        @php
                                            $value = optional($translationKey->values->firstWhere('language_code', $language->code))->value;
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs {{ $value ? 'bg-green-50 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                            {{ strtoupper($language->code) }} {{ $value ? '•' : '—' }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.translations.edit', $translationKey) }}" class="inline-flex items-center px-3 py-1.5 text-sm text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-sm text-gray-500">No translation keys have been added yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $translationKeys->links() }}
        </div>
    </div>
@endsection
