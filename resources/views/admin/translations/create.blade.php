@extends('admin.layouts.app')

@section('title', 'Add Translation Key')
@section('page-title', 'Add Translation Key')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-xl shadow border border-slate-200 p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">New Translation Key</h1>
        <p class="text-sm text-slate-600">Define a key and provide translated text for each active language.</p>
    </div>

    <form method="POST" action="{{ route('admin.translations.store') }}" class="space-y-6" x-data="{ tab: '{{ $languages->first()->code ?? 'en' }}' }">
        @csrf
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700">Key</label>
                <input type="text" name="key" value="{{ old('key') }}" placeholder="admin.dashboard.title" class="mt-1 w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500" required>
                @error('key')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Group</label>
                <input type="text" name="group" value="{{ old('group', 'admin') }}" class="mt-1 w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                @error('group')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-2">
                @foreach ($languages as $language)
                    <button type="button" @click="tab='{{ $language->code }}'" :class="tab === '{{ $language->code }}' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg text-sm font-medium">{{ $language->label }} ({{ strtoupper($language->code) }})</button>
                @endforeach
            </div>
            <div class="mt-4">
                @foreach ($languages as $language)
                    <div x-show="tab === '{{ $language->code }}'" class="space-y-2" x-cloak>
                        <label class="text-sm font-medium text-slate-700">Translation ({{ $language->label }})</label>
                        <textarea name="translations[{{ $language->code }}]" rows="4" class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter translation for {{ $language->label }}">{{ old('translations.' . $language->code) }}</textarea>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('admin.translations.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow">Save Key</button>
        </div>
    </form>
</div>
@endsection
