@extends('admin.layouts.app')

@section('title', 'Translations')
@section('page-title', 'Translations')

@section('content')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Translation Keys</h1>
        <p class="text-sm text-slate-600">Manage static translation keys and edit their values per language.</p>
    </div>
    <a href="{{ route('admin.translations.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Key
    </a>
</div>

<div class="mt-6 bg-white shadow rounded-xl border border-slate-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Group</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Key</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Languages</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($translationKeys as $translationKey)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $translationKey->group }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">{{ $translationKey->key }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                            <div class="flex flex-wrap gap-1">
                                @foreach ($languages as $language)
                                    @php
                                        $value = $translationKey->values->firstWhere('language_code', $language->code);
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-[11px] {{ $value ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-700' }}">
                                        {{ strtoupper($language->code) }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.translations.edit', $translationKey) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('admin.translations.destroy', $translationKey) }}" method="POST" onsubmit="return confirm('Delete this translation key?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-sm text-slate-500">No translation keys found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3">
        {{ $translationKeys->links() }}
    </div>
</div>
@endsection
