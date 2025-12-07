<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Languages</h1>
                <p class="text-gray-600 mt-2">Manage available languages for the website</p>
            </div>
            <a href="{{ route('admin.languages.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add Language
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by code or label..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select 
                    id="statusFilter"
                    wire:model.live="statusFilter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                >
                    <option value="">All Languages</option>
                    <option value="1">Active Only</option>
                    <option value="0">Inactive Only</option>
                </select>
            </div>

            <!-- Clear Filters -->
            <div class="flex items-end">
                <button 
                    wire:click="$set('search', ''); $set('statusFilter', '')"
                    class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                >
                    <i class="fas fa-times mr-2"></i>
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Languages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($languages as $language)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <!-- Language Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">
                                {{ $language->label }}
                            </h3>
                            <span class="px-3 py-1 text-sm font-mono font-bold rounded-full bg-blue-100 text-blue-800">
                                {{ strtoupper($language->code) }}
                            </span>
                        </div>
                        
                        <!-- Status Badge -->
                        <button 
                            wire:click="toggleStatus({{ $language->id }})"
                            class="flex items-center space-x-2 px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 {{ $language->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}"
                            title="Click to toggle status"
                        >
                            <i class="fas fa-circle text-xs"></i>
                            <span>{{ $language->is_active ? 'Active' : 'Inactive' }}</span>
                        </button>
                    </div>

                    <!-- Language Info -->
                    <div class="space-y-2 mb-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-globe w-5 text-gray-400"></i>
                            <span>Language Code: {{ $language->code }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar w-5 text-gray-400"></i>
                            <span>Added {{ $language->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a 
                            href="{{ route('admin.languages.edit', $language->id) }}"
                            class="text-blue-600 hover:text-blue-900 font-medium"
                        >
                            <i class="fas fa-edit mr-1"></i>
                            Edit
                        </a>
                        <button 
                            wire:click="delete({{ $language->id }})"
                            wire:confirm="Are you sure you want to delete this language? This action cannot be undone."
                            class="text-red-600 hover:text-red-900 font-medium"
                        >
                            <i class="fas fa-trash mr-1"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow-md p-12 text-center">
                <i class="fas fa-language text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No languages found</h3>
                <p class="text-gray-600 mb-6">Get started by adding your first language</p>
                <a 
                    href="{{ route('admin.languages.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200"
                >
                    <i class="fas fa-plus mr-2"></i>
                    Add Language
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($languages->hasPages())
        <div class="mt-6">
            {{ $languages->links() }}
        </div>
    @endif
</div>
