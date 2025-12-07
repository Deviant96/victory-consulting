<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $translationKey?->exists ? 'Edit Translation' : 'New Translation' }}
                </h1>
                <p class="text-gray-600 mt-2">Manage translation key and values for all active languages</p>
            </div>
            <a href="{{ route('admin.translations.index') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Translations
            </a>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit.prevent="save">
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="p-6 space-y-6">
                <!-- Translation Key -->
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                        Translation Key <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="key"
                        wire:model="key"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 font-mono @error('key') border-red-500 @enderror"
                        placeholder="e.g., navigation.home, auth.login, common.save"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-1">Use dot notation for nested keys (e.g., section.subsection.key)</p>
                    @error('key')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Group -->
                <div>
                    <label for="group" class="block text-sm font-medium text-gray-700 mb-2">
                        Group (Optional)
                    </label>
                    <input 
                        type="text" 
                        id="group"
                        wire:model="group"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('group') border-red-500 @enderror"
                        placeholder="e.g., navigation, auth, validation"
                        list="existing-groups"
                    >
                    <datalist id="existing-groups">
                        <option value="navigation">
                        <option value="auth">
                        <option value="validation">
                        <option value="common">
                        <option value="errors">
                    </datalist>
                    <p class="text-sm text-gray-500 mt-1">Organize translations by grouping related keys together</p>
                    @error('group')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-language mr-2 text-blue-600"></i>
                        Translations by Language
                    </h3>
                </div>

                <!-- Language Translations -->
                <div class="space-y-4">
                    @forelse($languages as $language)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors duration-200">
                            <label for="translation_{{ $language->code }}" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="inline-flex items-center">
                                    <span class="px-2 py-1 text-xs font-bold rounded bg-blue-100 text-blue-800 mr-2">
                                        {{ strtoupper($language->code) }}
                                    </span>
                                    {{ $language->label }}
                                </span>
                            </label>
                            <textarea 
                                id="translation_{{ $language->code }}"
                                wire:model="translations.{{ $language->code }}"
                                rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('translations.' . $language->code) border-red-500 @enderror"
                                placeholder="Enter translation for {{ $language->label }}"
                            ></textarea>
                            @error('translations.' . $language->code)
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-exclamation-circle text-3xl mb-3 block text-gray-300"></i>
                            <p class="font-medium">No active languages found</p>
                            <p class="text-sm mt-1">Please activate at least one language before creating translations</p>
                            <a href="{{ route('admin.languages.index') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                                <i class="fas fa-arrow-right mr-1"></i>
                                Manage Languages
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                <a 
                    href="{{ route('admin.translations.index') }}"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                >
                    Cancel
                </a>
                <button 
                    type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center"
                    @if(count($languages) === 0) disabled @endif
                >
                    <i class="fas fa-save mr-2"></i>
                    Save Translation
                </button>
            </div>
        </div>
    </form>
</div>
