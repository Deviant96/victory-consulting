@extends('admin.layouts.app')

@section('title', 'Edit Language')
@section('page-title', 'Edit Language')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow border border-slate-200 p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Edit Language</h1>
        <p class="text-sm text-slate-600">Update the language code, label, or activation status.</p>
    </div>

    <form method="POST" action="{{ route('admin.languages.update', $language) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-slate-700">Code</label>
            <input type="text" name="code" value="{{ old('code', $language->code) }}" class="mt-1 w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500" required {{ $language->code === 'en' ? 'readonly' : '' }}>
            @error('code')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            @if ($language->code === 'en')
                <p class="text-xs text-slate-500 mt-1">The default English locale cannot be changed.</p>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Label</label>
            <input type="text" name="label" value="{{ old('label', $language->label) }}" class="mt-1 w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500" required>
            @error('label')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" {{ old('is_active', $language->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="text-sm text-slate-700">Active</label>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4">
            <a href="{{ route('admin.languages.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow">Update Language</button>
        </div>
    </form>
</div>
@endsection
