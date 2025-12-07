<!-- Global Search Modal -->
<div x-data="searchModal()" 
     x-show="open" 
     @open-search.window="openSearch()"
     @keydown.escape.window="closeSearch()"
     @keydown.ctrl.k.window.prevent="toggleSearch()"
     @keydown.cmd.k.window.prevent="toggleSearch()"
     @keydown.arrow-down.window.prevent="navigateDown()"
     @keydown.arrow-up.window.prevent="navigateUp()"
     @keydown.enter.window.prevent="selectItem()"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="closeSearch()"></div>
    
    <!-- Modal Content -->
    <div class="flex min-h-screen items-start justify-center p-4 pt-20">
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl" 
             @click.away="closeSearch()"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <!-- Search Input -->
            <div class="flex items-center border-b border-gray-200 px-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0011.15 11.15z" />
                </svg>
                <input 
                    x-ref="searchInput"
                    x-model="query"
                    @input.debounce.300ms="search()"
                    type="text" 
                    placeholder="Search across all modules..." 
                    class="w-full px-4 py-4 text-base border-0 focus:outline-none focus:ring-0"
                    autocomplete="off">
                <button @click="closeSearch()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Search Results -->
            <div class="max-h-[60vh] overflow-y-auto">
                <!-- Loading State -->
                <div x-show="loading" class="p-8 text-center">
                    <svg class="animate-spin h-8 w-8 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Searching...</p>
                </div>

                <!-- Empty State -->
                <div x-show="!loading && query.length === 0" class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0011.15 11.15z" />
                    </svg>
                    <h3 class="mt-4 text-sm font-medium text-gray-900">Quick Search</h3>
                    <p class="mt-1 text-sm text-gray-500">Search across services, team, FAQs, articles, solutions, translations, and more</p>
                </div>

                <!-- No Results -->
                <div x-show="!loading && query.length > 0 && hasNoResults()" class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-sm font-medium text-gray-900">No results found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try searching with different keywords</p>
                </div>

                <!-- Results by Category -->
                <div x-show="!loading && !hasNoResults() && results.length > 0" class="divide-y divide-gray-100">
                    <template x-for="category in results" :key="category.type">
                        <div x-show="category.items.length > 0" class="p-4">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2" x-text="category.label"></h3>
                            <div class="space-y-1">
                                <template x-for="(item, index) in category.items" :key="item.id">
                                    <a :href="item.url" 
                                       :data-index="getGlobalIndex(category.type, index)"
                                       class="block px-3 py-2 rounded-lg transition group"
                                       :class="selectedIndex === getGlobalIndex(category.type, index) ? 'bg-blue-50 ring-2 ring-blue-500' : 'hover:bg-gray-50'"
                                       @click="closeSearch()"
                                       @mouseenter="selectedIndex = getGlobalIndex(category.type, index)">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium truncate" 
                                                   :class="selectedIndex === getGlobalIndex(category.type, index) ? 'text-blue-600' : 'text-gray-900 group-hover:text-blue-600'"
                                                   x-text="item.title"></p>
                                                <p class="text-xs text-gray-500 truncate" x-text="item.subtitle"></p>
                                            </div>
                                            <svg class="w-4 h-4 ml-2 flex-shrink-0" 
                                                 :class="selectedIndex === getGlobalIndex(category.type, index) ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600'"
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Footer Hint -->
            <div class="border-t border-gray-200 px-4 py-3 bg-gray-50 rounded-b-2xl">
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <div class="flex items-center space-x-3">
                        <span class="flex items-center">
                            <kbd class="px-1.5 py-0.5 bg-white border border-gray-300 rounded mr-1">↑</kbd>
                            <kbd class="px-1.5 py-0.5 bg-white border border-gray-300 rounded mr-1">↓</kbd>
                            to navigate
                        </span>
                        <span class="flex items-center">
                            <kbd class="px-1.5 py-0.5 bg-white border border-gray-300 rounded mr-1">Enter</kbd>
                            to select
                        </span>
                    </div>
                    <span class="flex items-center">
                        <kbd class="px-1.5 py-0.5 bg-white border border-gray-300 rounded mr-1">ESC</kbd>
                        to close
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function searchModal() {
        return {
            open: false,
            query: '',
            results: [],
            loading: false,
            selectedIndex: 0,

            openSearch() {
                this.open = true;
                this.selectedIndex = 0;
                this.$nextTick(() => {
                    this.$refs.searchInput.focus();
                });
            },

            closeSearch() {
                this.open = false;
                this.query = '';
                this.results = [];
                this.selectedIndex = 0;
            },

            toggleSearch() {
                if (this.open) {
                    this.closeSearch();
                } else {
                    this.openSearch();
                }
            },

            async search() {
                if (this.query.length === 0) {
                    this.results = [];
                    this.selectedIndex = 0;
                    return;
                }

                this.loading = true;

                try {
                    const response = await fetch(`/admin/search?q=${encodeURIComponent(this.query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        this.results = data;
                        this.selectedIndex = 0;
                    }
                } catch (error) {
                    console.error('Search error:', error);
                } finally {
                    this.loading = false;
                }
            },

            getAllItems() {
                const items = [];
                this.results.forEach(category => {
                    if (category.items && category.items.length > 0) {
                        category.items.forEach(item => {
                            items.push(item);
                        });
                    }
                });
                return items;
            },

            getGlobalIndex(categoryType, itemIndex) {
                let globalIndex = 0;
                for (const category of this.results) {
                    if (category.type === categoryType) {
                        return globalIndex + itemIndex;
                    }
                    globalIndex += category.items.length;
                }
                return 0;
            },

            navigateDown() {
                if (!this.open || this.loading) return;
                
                const allItems = this.getAllItems();
                if (allItems.length === 0) return;

                this.selectedIndex = (this.selectedIndex + 1) % allItems.length;
                this.scrollToSelected();
            },

            navigateUp() {
                if (!this.open || this.loading) return;
                
                const allItems = this.getAllItems();
                if (allItems.length === 0) return;

                this.selectedIndex = this.selectedIndex === 0 ? allItems.length - 1 : this.selectedIndex - 1;
                this.scrollToSelected();
            },

            selectItem() {
                if (!this.open || this.loading) return;
                
                const allItems = this.getAllItems();
                if (allItems.length === 0 || !allItems[this.selectedIndex]) return;

                const selectedItem = allItems[this.selectedIndex];
                if (selectedItem && selectedItem.url) {
                    window.location.href = selectedItem.url;
                }
            },

            scrollToSelected() {
                this.$nextTick(() => {
                    const selectedElement = document.querySelector(`[data-index="${this.selectedIndex}"]`);
                    if (selectedElement) {
                        selectedElement.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                    }
                });
            },

            hasNoResults() {
                if (!this.results || this.results.length === 0) return true;
                return this.results.every(category => !category.items || category.items.length === 0);
            }
        };
    }
</script>
