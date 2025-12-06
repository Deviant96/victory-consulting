@extends('admin.layouts.app')

@section('title', 'Languages')
@section('page-title', 'Languages')

@section('content')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Manage Languages</h1>
        <p class="text-sm text-slate-600">Add or enable languages for both the admin panel and the frontend.</p>
    </div>
    <a href="{{ route('admin.languages.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Language
    </a>
</div>

<div class="mt-6 bg-white shadow rounded-xl border border-slate-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Label</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($languages as $language)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">{{ $language->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $language->label }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($language->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-800">Disabled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.languages.edit', $language) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                @if ($language->code !== 'en')
                                    <form action="{{ route('admin.languages.destroy', $language) }}" method="POST" onsubmit="return confirm('Delete this language?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-sm text-slate-500">No languages found. Create one to get started.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3">
        {{ $languages->links() }}
    </div>
</div>
@endsection
