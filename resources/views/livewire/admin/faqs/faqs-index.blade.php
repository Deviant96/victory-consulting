{{-- FAQs Index Component --}}
<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">FAQs Management</h1>
            <p class="text-sm text-slate-600 mt-1">Manage frequently asked questions</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add FAQ
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
                        placeholder="Search FAQs..."
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
            class="mt-4 pt-4 border-t border-slate-200 grid grid-cols-1 md:grid-cols-2 gap-4">
            
            {{-- Category Filter --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                <select wire:model.live="categoryFilter" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Published Filter --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select wire:model.live="publishedFilter" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">All Status</option>
                    <option value="1">Published</option>
                    <option value="0">Draft</option>
                </select>
            </div>
        </div>
    </div>

    {{-- FAQs List --}}
    <div class="admin-card overflow-hidden">
        @if($faqs->count() > 0)
            <div class="divide-y divide-slate-200">
                @foreach($faqs as $faq)
                    <div wire:key="faq-{{ $faq->id }}" class="p-5 hover:bg-slate-50 transition">
                        <div class="flex items-start gap-4">
                            {{-- Order Controls --}}
                            <div class="flex flex-col gap-1 shrink-0">
                                <button 
                                    wire:click="updateOrder({{ $faq->id }}, 'up')"
                                    class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition"
                                    title="Move up">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <span class="text-xs text-slate-500 text-center font-medium">{{ $faq->order }}</span>
                                <button 
                                    wire:click="updateOrder({{ $faq->id }}, 'down')"
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
                                    <h3 class="font-semibold text-slate-900 text-lg">{{ $faq->question }}</h3>
                                    <div class="flex items-center gap-2 shrink-0">
                                        {{-- Status Badge --}}
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $faq->published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                            {{ $faq->published ? 'Published' : 'Draft' }}
                                        </span>

                                        @if($faq->category)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                                {{ $faq->category }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <p class="text-slate-600 text-sm line-clamp-2 mb-3">{{ $faq->answer }}</p>

                                {{-- Actions --}}
                                <div class="flex items-center gap-2">
                                    <button 
                                        wire:click="togglePublished({{ $faq->id }})"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium rounded-lg transition {{ $faq->published ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                        @if($faq->published)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                            </svg>
                                            Unpublish
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Publish
                                        @endif
                                    </button>

                                    <a href="{{ route('admin.faqs.edit', $faq->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>

                                    <button 
                                        wire:click="deleteFaq({{ $faq->id }})"
                                        wire:confirm="Are you sure you want to delete this FAQ?"
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
                {{ $faqs->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <svg class="mx-auto w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-900 mb-1">No FAQs found</h3>
                <p class="text-slate-600 mb-4">
                    @if($search || $categoryFilter || $publishedFilter !== '')
                        No FAQs match your filters. Try adjusting your search criteria.
                    @else
                        Get started by creating your first FAQ.
                    @endif
                </p>
                @if($search || $categoryFilter || $publishedFilter !== '')
                    <button 
                        wire:click="$set('search', ''); $set('categoryFilter', ''); $set('publishedFilter', '')"
                        class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                        Clear Filters
                    </button>
                @else
                    <a href="{{ route('admin.faqs.create') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Your First FAQ
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
