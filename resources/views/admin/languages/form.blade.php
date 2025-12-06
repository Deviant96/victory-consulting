<div class="space-y-6">
    <div>
        <label class="block text-sm font-semibold text-gray-700">Code</label>
        <input type="text" name="code" value="{{ old('code', $language->code ?? '') }}" placeholder="en" class="mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
        <p class="text-xs text-gray-500 mt-1">Use ISO code like en, id, th.</p>
        @error('code')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700">Label</label>
        <input type="text" name="label" value="{{ old('label', $language->label ?? '') }}" placeholder="English" class="mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
        @error('label')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" id="is_active" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_active', $language->is_active ?? true) ? 'checked' : '' }}>
        <label for="is_active" class="text-sm text-gray-700">Mark as active</label>
    </div>
</div>
