{{-- Team Members Index Component --}}
<div>
    {{-- Header Section --}}
    <div class="admin-card p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Team Members</h1>
                <p class="text-sm text-slate-600 mt-1">Manage your team roster and profiles</p>
            </div>
            <div class="flex items-center gap-3">
                <button 
                    wire:click="toggleFilters" 
                    class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filters
                </button>
                <a href="{{ route('admin.team.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Team Member
                </a>
            </div>
        </div>

        {{-- Filters Section --}}
        <div 
            x-data="{ show: @entangle('showFilters') }"
            x-show="show"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            class="mt-6 pt-6 border-t border-slate-200"
            style="display: none;"
        >
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Search Input --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium uppercase tracking-wide text-slate-500 mb-1">Search</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0011.15 11.15z" />
                        </svg>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by name, position, or bio..."
                            class="w-full pl-9 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        
                        {{-- Clear search button --}}
                        @if($search)
                            <button 
                                wire:click="$set('search', '')"
                                class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
                
                {{-- Clear Filters Button --}}
                <div class="flex items-end">
                    <button 
                        wire:click="clearFilters"
                        class="w-full px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Team Members Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($members as $member)
            <div 
                wire:key="member-{{ $member->id }}"
                class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition group">
                {{-- Photo --}}
                <div class="aspect-square bg-slate-100 overflow-hidden">
                    @if($member->photo)
                        <img 
                            src="{{ asset('storage/' . $member->photo) }}" 
                            alt="{{ $member->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                {{-- Content --}}
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-900 mb-1">{{ $member->name }}</h3>
                    <p class="text-sm text-blue-600 mb-3">{{ $member->position }}</p>
                    
                    @if($member->bio)
                        <p class="text-sm text-slate-600 line-clamp-2 mb-4">{{ $member->bio }}</p>
                    @endif
                    
                    @if($member->expertise && count($member->expertise) > 0)
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(array_slice($member->expertise, 0, 3) as $skill)
                                <span class="px-2 py-1 text-xs bg-slate-100 text-slate-700 rounded-lg">{{ $skill }}</span>
                            @endforeach
                            @if(count($member->expertise) > 3)
                                <span class="px-2 py-1 text-xs bg-slate-100 text-slate-700 rounded-lg">+{{ count($member->expertise) - 3 }}</span>
                            @endif
                        </div>
                    @endif
                    
                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                        <a 
                            href="{{ route('admin.team.edit', $member->id) }}"
                            class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-center text-sm font-medium">
                            Edit
                        </a>
                        <button 
                            wire:click="delete({{ $member->id }})"
                            wire:loading.attr="disabled"
                            wire:confirm="Are you sure you want to delete {{ $member->name }}?"
                            class="flex-1 px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                            <span wire:loading.remove wire:target="delete({{ $member->id }})">Delete</span>
                            <span wire:loading wire:target="delete({{ $member->id }})">Deleting...</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3">
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-12 text-center">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="text-lg font-semibold text-slate-900 mb-1">No team members found</p>
                    <p class="text-sm text-slate-500">
                        @if($search)
                            Try adjusting your search criteria
                        @else
                            Get started by adding your first team member
                        @endif
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $members->links() }}
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
