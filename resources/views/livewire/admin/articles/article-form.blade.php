{{-- Article Form Component --}}
<div>
    <div class="admin-card p-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $isEditMode ? 'Edit Article' : 'New Article' }}
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                {{ $isEditMode ? 'Update article information' : 'Create a new blog post or article' }}
            </p>
        </div>

        {{-- Form --}}
        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Featured Image --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Featured Image
                </label>
                
                <div class="flex items-start gap-6">
                    {{-- Preview --}}
                    <div class="shrink-0">
                        @if ($featured_image)
                            <img 
                                src="{{ $featured_image->temporaryUrl() }}" 
                                alt="Preview"
                                class="w-64 h-40 rounded-xl object-cover border-2 border-slate-200">
                        @elseif ($existingImage)
                            <img 
                                src="{{ asset('storage/' . $existingImage) }}" 
                                alt="Current image"
                                class="w-64 h-40 rounded-xl object-cover border-2 border-slate-200">
                        @else
                            <div class="w-64 h-40 rounded-xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Upload --}}
                    <div class="flex-1">
                        <input 
                            type="file" 
                            wire:model="featured_image"
                            accept="image/*"
                            class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-xl file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                                file:cursor-pointer cursor-pointer">
                        
                        <p class="mt-2 text-xs text-slate-500">JPG, PNG, or GIF. Max 2MB. Recommended: 1200x630px</p>
                        
                        @if($existingImage || $featured_image)
                            <button 
                                type="button"
                                wire:click="removeImage"
                                class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium">
                                Remove image
                            </button>
                        @endif
                        
                        <div wire:loading wire:target="featured_image" class="mt-2 text-sm text-blue-600">Uploading...</div>
                        
                        @error('featured_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Title and Slug --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title"
                        wire:model.live="title"
                        placeholder="Enter article title"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-slate-700 mb-1">
                        Slug <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="slug"
                        wire:model.defer="slug"
                        placeholder="article-url-slug"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('slug') border-red-500 @enderror">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Excerpt --}}
            <div>
                <label for="excerpt" class="block text-sm font-medium text-slate-700 mb-1">
                    Excerpt
                </label>
                <textarea 
                    id="excerpt"
                    wire:model.defer="excerpt"
                    rows="2"
                    placeholder="Brief summary of the article (optional)"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y @error('excerpt') border-red-500 @enderror"></textarea>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-slate-500">Maximum 500 characters</p>
            </div>

            {{-- Content --}}
            <div>
                <label for="content" class="block text-sm font-medium text-slate-700 mb-1">
                    Content <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content"
                    wire:model.defer="content"
                    rows="12"
                    placeholder="Write your article content here..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y font-mono text-sm @error('content') border-red-500 @enderror"></textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-slate-500">Supports Markdown formatting</p>
            </div>

            {{-- Category, Author, Published Date --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-slate-700 mb-1">
                        Category
                    </label>
                    <input 
                        type="text" 
                        id="category"
                        wire:model.defer="category"
                        list="category-suggestions"
                        placeholder="e.g., News, Tips, Case Study"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('category') border-red-500 @enderror">
                    
                    @if($existingCategories->count() > 0)
                        <datalist id="category-suggestions">
                            @foreach($existingCategories as $cat)
                                <option value="{{ $cat }}">
                            @endforeach
                        </datalist>
                    @endif
                    
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-slate-700 mb-1">
                        Author
                    </label>
                    <input 
                        type="text" 
                        id="author"
                        wire:model.defer="author"
                        placeholder="Author name"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('author') border-red-500 @enderror">
                    @error('author')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="published_at" class="block text-sm font-medium text-slate-700 mb-1">
                        Publish Date
                    </label>
                    <input 
                        type="datetime-local" 
                        id="published_at"
                        wire:model.defer="published_at"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('published_at') border-red-500 @enderror">
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tags --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Tags
                </label>
                
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach($tags as $index => $tag)
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium">
                            #{{ $tag }}
                            <button 
                                type="button"
                                wire:click="removeTag({{ $index }})"
                                class="text-blue-700 hover:text-blue-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                    @endforeach
                    
                    @if(empty($tags))
                        <span class="text-sm text-slate-500">No tags added yet</span>
                    @endif
                </div>

                <div class="flex gap-2">
                    <input 
                        type="text" 
                        wire:model.defer="tagInput"
                        wire:keydown.enter.prevent="addTag"
                        placeholder="Add a tag"
                        class="flex-1 px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <button 
                        type="button"
                        wire:click="addTag"
                        class="px-4 py-2.5 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition font-medium">
                        Add Tag
                    </button>
                </div>
            </div>

            {{-- Published Status --}}
            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
                <input 
                    type="checkbox" 
                    id="published"
                    wire:model.defer="published"
                    class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition">
                <label for="published" class="text-sm font-medium text-slate-700 cursor-pointer">
                    Publish this article immediately
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-6 border-t border-slate-200">
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition font-medium disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">
                        {{ $isEditMode ? 'Update Article' : 'Create Article' }}
                    </span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Saving...
                    </span>
                </button>
                
                <button 
                    type="button"
                    wire:click="cancel"
                    class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-medium">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
