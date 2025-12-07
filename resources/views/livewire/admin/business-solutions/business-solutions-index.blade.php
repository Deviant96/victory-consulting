{{-- Business Solutions Index Component --}}
<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Business Solutions</h1>
            <p class="text-sm text-slate-600 mt-1">Manage your business solutions and sub-solutions</p>
        </div>
        <a href="{{ route('admin.business-solutions.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Solution
        </a>
    </div>

    {{-- Search & Filters --}}
    <div class="admin-card p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            {{-- Search --}}
            <div class="flex-1">
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search solutions..."
                        class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <svg class="absolute left-3 top-3 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Filter Toggle --}}
            <button 
                wire:click="$toggle('showFilters')"
                class="px-4 py-2.5 border border-slate-300 rounded-xl hover:bg-slate-50 transition font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filters
            </button>
        </div>

        {{-- Expanded Filters --}}
        <div 
            x-data="{ show: @entangle('showFilters') }"
            x-show="show"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="mt-4 pt-4 border-t border-slate-200">
            
            {{-- Status Filter --}}
            <div class="max-w-xs">
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select wire:model.live="statusFilter" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Solutions List --}}
    <div class="admin-card overflow-hidden">
        @if($solutions->count() > 0)
            <div class="divide-y divide-slate-200">
                @foreach($solutions as $solution)
                    <div wire:key="solution-{{ $solution->id }}" class="p-5 hover:bg-slate-50 transition">
                        <div class="flex items-start gap-4">
                            {{-- Order Controls --}}
                            <div class="flex flex-col gap-1 shrink-0">
                                <button 
                                    wire:click="updateOrder({{ $solution->id }}, 'up')"
                                    class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition"
                                    title="Move up">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <span class="text-xs text-slate-500 text-center font-medium">{{ $solution->order }}</span>
                                <button 
                                    wire:click="updateOrder({{ $solution->id }}, 'down')"
                                    class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition"
                                    title="Move down">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-slate-900 text-lg">{{ $solution->title }}</h3>
                                        @if($solution->description)
                                            <p class="text-slate-600 text-sm mt-1">{{ $solution->description }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        {{-- Status Badge --}}
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $solution->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                            {{ $solution->is_active ? 'Active' : 'Inactive' }}
                                        </span>

                                        {{-- Sub-solutions Count --}}
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                            {{ $solution->sub_solutions_count }} {{ Str::plural('sub-solution', $solution->sub_solutions_count) }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center gap-2 mt-3">
                                    <button 
                                        wire:click="toggleActive({{ $solution->id }})"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium rounded-lg transition {{ $solution->is_active ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                        @if($solution->is_active)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                            </svg>
                                            Deactivate
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Activate
                                        @endif
                                    </button>

                                    <a href="{{ route('admin.business-solutions.edit', $solution->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>

                                    <button 
                                        wire:click="deleteSolution({{ $solution->id }})"
                                        wire:confirm="Are you sure you want to delete this solution? All associated sub-solutions will also be deleted."
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="p-4 border-t border-slate-200">
                {{ $solutions->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <svg class="mx-auto w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-900 mb-1">No business solutions found</h3>
                <p class="text-slate-600 mb-4">
                    @if($search || $statusFilter !== '')
                        No solutions match your filters. Try adjusting your search criteria.
                    @else
                        Get started by creating your first business solution.
                    @endif
                </p>
                @if($search || $statusFilter !== '')
                    <button 
                        wire:click="$set('search', ''); $set('statusFilter', '')"
                        class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                        Clear Filters
                    </button>
                @else
                    <a href="{{ route('admin.business-solutions.create') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Your First Solution
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
