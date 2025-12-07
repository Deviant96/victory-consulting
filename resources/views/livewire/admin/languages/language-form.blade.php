<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $language?->exists ? 'Edit Language' : 'New Language' }}
                </h1>
                <p class="text-gray-600 mt-2">Configure language settings and availability</p>
            </div>
            <a href="{{ route('admin.languages.index') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Languages
            </a>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit.prevent="save">
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="p-6 space-y-6">
                <!-- Language Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Language Code <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="code"
                        wire:model="code"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 font-mono uppercase @error('code') border-red-500 @enderror"
                        placeholder="en"
                        maxlength="10"
                        required
                        {{ $language?->exists ? 'readonly' : '' }}
                    >
                    <p class="text-sm text-gray-500 mt-1">ISO 639-1 language code (e.g., en, es, fr, de)</p>
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Language Label -->
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700 mb-2">
                        Language Label <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="label"
                        wire:model="label"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('label') border-red-500 @enderror"
                        placeholder="English"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-1">Full language name as displayed to users</p>
                    @error('label')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            wire:model="is_active"
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-colors duration-200"
                        >
                        <div>
                            <span class="text-sm font-medium text-gray-700">Active Language</span>
                            <p class="text-xs text-gray-500">Make this language available for translations</p>
                        </div>
                    </label>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Language Guidelines</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Use standard ISO 639-1 codes (2 letters)</li>
                                    <li>Language code cannot be changed after creation</li>
                                    <li>Inactive languages won't appear in translation forms</li>
                                    <li>Languages with translations cannot be deleted</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                <a 
                    href="{{ route('admin.languages.index') }}"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                >
                    Cancel
                </a>
                <button 
                    type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center"
                >
                    <i class="fas fa-save mr-2"></i>
                    Save Language
                </button>
            </div>
        </div>
    </form>
</div>
