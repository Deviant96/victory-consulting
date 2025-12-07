{{-- Service Form Component --}}
<div>
    <div class="admin-card p-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $isEditMode ? 'Edit Service' : 'Add Service' }}
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                {{ $isEditMode ? 'Update service information' : 'Create a new service offering' }}
            </p>
        </div>

        {{-- Form --}}
        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Featured Image --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Featured Image <span class="text-red-500">*</span>
                </label>
                
                <div class="flex items-start gap-6">
                    {{-- Preview --}}
                    <div class="shrink-0">
                        @if ($featured_image)
                            <img 
                                src="{{ $featured_image->temporaryUrl() }}" 
                                alt="Preview"
                                class="w-48 h-32 rounded-xl object-cover border-2 border-slate-200">
                        @elseif ($existingImage)
                            <img 
                                src="{{ asset('storage/' . $existingImage) }}" 
                                alt="Current image"
                                class="w-48 h-32 rounded-xl object-cover border-2 border-slate-200">
                        @else
                            <div class="w-48 h-32 rounded-xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center">
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
                        
                        <p class="mt-2 text-xs text-slate-500">JPG, PNG, or GIF. Max 2MB. Recommended: 1200x800px</p>
                        
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
                        placeholder="e.g., Strategic Planning"
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
                        placeholder="strategic-planning"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('slug') border-red-500 @enderror">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Summary --}}
            <div>
                <label for="summary" class="block text-sm font-medium text-slate-700 mb-1">
                    Summary
                </label>
                <textarea 
                    id="summary"
                    wire:model.defer="summary"
                    rows="2"
                    placeholder="Brief summary of the service..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y @error('summary') border-red-500 @enderror"></textarea>
                @error('summary')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1">
                    Description
                </label>
                <textarea 
                    id="description"
                    wire:model.defer="description"
                    rows="6"
                    placeholder="Detailed description of the service..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y @error('description') border-red-500 @enderror"></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Price Note --}}
            <div>
                <label for="price_note" class="block text-sm font-medium text-slate-700 mb-1">
                    Price Note
                </label>
                <input 
                    type="text" 
                    id="price_note"
                    wire:model.defer="price_note"
                    placeholder="e.g., Starting from $5,000"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('price_note') border-red-500 @enderror">
                @error('price_note')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Service Highlights --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-medium text-slate-700">
                        Service Highlights
                    </label>
                    <button 
                        type="button"
                        wire:click="addHighlight"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Highlight
                    </button>
                </div>
                
                <div class="space-y-3">
                    @foreach($highlights as $index => $highlight)
                        <div wire:key="highlight-{{ $index }}" class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-1 space-y-3">
                                    <input 
                                        type="text" 
                                        wire:model.defer="highlights.{{ $index }}.title"
                                        placeholder="Highlight title"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">
                                    
                                    <textarea 
                                        wire:model.defer="highlights.{{ $index }}.description"
                                        rows="2"
                                        placeholder="Highlight description (optional)"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y text-sm"></textarea>
                                </div>
                                
                                <button 
                                    type="button"
                                    wire:click="removeHighlight({{ $index }})"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                    
                    @if(empty($highlights))
                        <p class="text-sm text-slate-500 py-4 text-center border-2 border-dashed border-slate-200 rounded-xl">
                            No highlights added yet. Click "Add Highlight" to get started.
                        </p>
                    @endif
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
                    Publish this service immediately
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-6 border-t border-slate-200">
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition font-medium disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">
                        {{ $isEditMode ? 'Update Service' : 'Create Service' }}
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
