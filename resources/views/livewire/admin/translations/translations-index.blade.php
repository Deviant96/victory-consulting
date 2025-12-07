<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Translations</h1>
                <p class="text-gray-600 mt-2">Manage translation keys and values for multiple languages</p>
            </div>
            <a href="{{ route('admin.translations.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add Translation
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Keys/Values</label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search translation keys or values..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Group Filter -->
            <div>
                <label for="groupFilter" class="block text-sm font-medium text-gray-700 mb-2">Filter by Group</label>
                <select 
                    id="groupFilter"
                    wire:model.live="groupFilter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                >
                    <option value="">All Groups</option>
                    @foreach($groups as $group)
                        <option value="{{ $group }}">{{ $group }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Clear Filters -->
            <div class="flex items-end">
                <button 
                    wire:click="$set('search', ''); $set('groupFilter', '')"
                    class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                >
                    <i class="fas fa-times mr-2"></i>
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Translations Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Key
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Group
                        </th>
                        @foreach($languages as $language)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ strtoupper($language->code) }}
                                <span class="text-gray-400 font-normal">({{ $language->label }})</span>
                            </th>
                        @endforeach
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($translationKeys as $translationKey)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-gray-900">{{ $translationKey->key }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($translationKey->group)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                        {{ $translationKey->group }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            @foreach($languages as $language)
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-700">
                                        {{ Str::limit($translationKey->valueForLocale($language->code) ?? '-', 40) }}
                                    </span>
                                </td>
                            @endforeach
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a 
                                    href="{{ route('admin.translations.edit', $translationKey->id) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-3"
                                    title="Edit"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button 
                                    wire:click="delete({{ $translationKey->id }})"
                                    wire:confirm="Are you sure you want to delete this translation key?"
                                    class="text-red-600 hover:text-red-900"
                                    title="Delete"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 3 + count($languages) }}" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-language text-4xl mb-4 block text-gray-300"></i>
                                <p class="text-lg font-medium">No translations found</p>
                                <p class="text-sm mt-1">Create your first translation key to get started</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($translationKeys->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $translationKeys->links() }}
            </div>
        @endif
    </div>
</div>
