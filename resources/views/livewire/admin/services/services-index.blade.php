{{-- Services Index Component --}}
<div>
    {{-- Header --}}
    <div class="admin-card p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Services</h1>
                <p class="text-sm text-slate-600 mt-1">Manage your service offerings and features</p>
            </div>
            <div class="flex items-center gap-3">
                <button 
                    wire:click="$toggle('showFilters')" 
                    class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filters
                </button>
                <a href="{{ route('admin.services.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Service
                </a>
            </div>
        </div>

        {{-- Filters --}}
        @if($showFilters)
            <div 
                x-data
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="mt-6 pt-6 border-t border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium uppercase tracking-wide text-slate-500 mb-1">Search</label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by title, summary, or description..."
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wide text-slate-500 mb-1">Status</label>
                        <select 
                            wire:model.live="published"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">All Services</option>
                            <option value="1">Published</option>
                            <option value="0">Unpublished</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button 
                            wire:click="clearFilters"
                            class="w-full px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition">
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Services Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($services as $service)
            <div 
                wire:key="service-{{ $service->id }}"
                class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition group">
                {{-- Featured Image --}}
                <div class="aspect-video bg-slate-100 overflow-hidden relative">
                    @if($service->featured_image)
                        <img 
                            src="{{ asset('storage/' . $service->featured_image) }}" 
                            alt="{{ $service->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    {{-- Published Badge --}}
                    <div class="absolute top-2 right-2">
                        @if($service->published)
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Published</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded-full">Draft</span>
                        @endif
                    </div>
                </div>
                
                {{-- Content --}}
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $service->title }}</h3>
                    
                    @if($service->summary)
                        <p class="text-sm text-slate-600 line-clamp-2 mb-3">{{ $service->summary }}</p>
                    @endif
                    
                    @if($service->highlights->count() > 0)
                        <div class="mb-4">
                            <p class="text-xs font-medium text-slate-500 mb-1">Highlights:</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($service->highlights->take(3) as $highlight)
                                    <span class="px-2 py-1 text-xs bg-blue-50 text-blue-700 rounded-lg">{{ $highlight->title }}</span>
                                @endforeach
                                @if($service->highlights->count() > 3)
                                    <span class="px-2 py-1 text-xs bg-slate-100 text-slate-600 rounded-lg">+{{ $service->highlights->count() - 3 }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                        <button 
                            wire:click="togglePublished({{ $service->id }})"
                            class="flex-1 px-3 py-2 {{ $service->published ? 'bg-slate-50 text-slate-600' : 'bg-green-50 text-green-600' }} rounded-lg hover:opacity-75 transition text-center text-sm font-medium">
                            {{ $service->published ? 'Unpublish' : 'Publish' }}
                        </button>
                        <a 
                            href="{{ route('admin.services.edit', $service->id) }}"
                            class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-center text-sm font-medium">
                            Edit
                        </a>
                        <button 
                            wire:click="delete({{ $service->id }})"
                            wire:confirm="Are you sure you want to delete {{ $service->title }}?"
                            class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3">
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-12 text-center">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-lg font-semibold text-slate-900 mb-1">No services found</p>
                    <p class="text-sm text-slate-500">
                        @if($search || $published !== '')
                            Try adjusting your filters
                        @else
                            Get started by adding your first service
                        @endif
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $services->links() }}
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading.delay class="fixed top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-full shadow-lg z-50 flex items-center gap-2">
        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-sm">Loading...</span>
    </div>
</div>
