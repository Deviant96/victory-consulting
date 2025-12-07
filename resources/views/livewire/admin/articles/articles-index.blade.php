{{-- Articles Index Component --}}
<div>
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Articles Management</h1>
            <p class="text-sm text-slate-600 mt-1">Manage blog posts and articles</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Article
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
                        placeholder="Search articles..."
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

    {{-- Articles Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($articles as $article)
            <div wire:key="article-{{ $article->id }}" class="admin-card overflow-hidden hover:shadow-lg transition group">
                {{-- Featured Image --}}
                <div class="aspect-video bg-slate-100 overflow-hidden">
                    @if($article->featured_image)
                        <img 
                            src="{{ asset('storage/' . $article->featured_image) }}" 
                            alt="{{ $article->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-5">
                    {{-- Header --}}
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <h3 class="font-semibold text-slate-900 line-clamp-2 flex-1">{{ $article->title }}</h3>
                        <span class="shrink-0 px-2 py-1 text-xs font-medium rounded-full {{ $article->published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $article->published ? 'Published' : 'Draft' }}
                        </span>
                    </div>

                    {{-- Metadata --}}
                    <div class="flex items-center gap-2 mb-3 text-xs text-slate-500">
                        @if($article->category)
                            <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-full font-medium">
                                {{ $article->category }}
                            </span>
                        @endif
                        @if($article->author)
                            <span>by {{ $article->author }}</span>
                        @endif
                    </div>

                    {{-- Excerpt --}}
                    @if($article->excerpt)
                        <p class="text-sm text-slate-600 line-clamp-2 mb-4">{{ $article->excerpt }}</p>
                    @endif

                    {{-- Tags --}}
                    @if($article->tags && count($article->tags) > 0)
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(array_slice($article->tags, 0, 3) as $tag)
                                <span class="px-2 py-0.5 text-xs bg-slate-100 text-slate-600 rounded">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                            @if(count($article->tags) > 3)
                                <span class="px-2 py-0.5 text-xs bg-slate-100 text-slate-600 rounded">
                                    +{{ count($article->tags) - 3 }}
                                </span>
                            @endif
                        </div>
                    @endif

                    {{-- Date --}}
                    <p class="text-xs text-slate-500 mb-4">
                        {{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}
                    </p>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-4 border-t border-slate-200">
                        <button 
                            wire:click="togglePublished({{ $article->id }})"
                            class="flex-1 px-3 py-2 text-sm font-medium rounded-lg transition {{ $article->published ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                            {{ $article->published ? 'Unpublish' : 'Publish' }}
                        </button>

                        <a href="{{ route('admin.articles.edit', $article->id) }}" 
                           class="p-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>

                        <button 
                            wire:click="deleteArticle({{ $article->id }})"
                            wire:confirm="Are you sure you want to delete this article? This action cannot be undone."
                            class="p-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="col-span-full admin-card p-12 text-center">
                <svg class="mx-auto w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-900 mb-1">No articles found</h3>
                <p class="text-slate-600 mb-4">
                    @if($search || $categoryFilter || $publishedFilter !== '')
                        No articles match your filters. Try adjusting your search criteria.
                    @else
                        Get started by creating your first article.
                    @endif
                </p>
                @if($search || $categoryFilter || $publishedFilter !== '')
                    <button 
                        wire:click="$set('search', ''); $set('categoryFilter', ''); $set('publishedFilter', '')"
                        class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                        Clear Filters
                    </button>
                @else
                    <a href="{{ route('admin.articles.create') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Your First Article
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($articles->hasPages())
        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    @endif
</div>
