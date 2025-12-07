{{-- Why Choose Item Form Component --}}
<div>
    <div class="admin-card p-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $isEditMode ? 'Edit Why Choose Item' : 'Add Why Choose Item' }}
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                {{ $isEditMode ? 'Update item information' : 'Create a new reason why customers choose your business' }}
            </p>
        </div>

        {{-- Form --}}
        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-1">
                    Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title"
                    wire:model.defer="title"
                    placeholder="e.g., Expert Team, Fast Delivery"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('title') border-red-500 @enderror">
                @error('title')
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
                    rows="3"
                    placeholder="Brief description of this feature (optional)"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y @error('description') border-red-500 @enderror"></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-slate-500">Maximum 500 characters</p>
            </div>

            {{-- Icon Selection --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Icon <span class="text-red-500">*</span>
                </label>
                
                {{-- Current Icon Preview --}}
                <div class="mb-4 p-4 bg-slate-50 rounded-xl flex items-center gap-3">
                    <div class="w-16 h-16 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="{{ $icon }} text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-900">Current Icon</p>
                        <p class="text-xs text-slate-500 font-mono">{{ $icon }}</p>
                    </div>
                </div>

                {{-- Icon Grid --}}
                <div class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 gap-2 p-4 bg-slate-50 rounded-xl max-h-64 overflow-y-auto">
                    @foreach($iconOptions as $iconClass)
                        <button 
                            type="button"
                            wire:click="$set('icon', '{{ $iconClass }}')"
                            class="w-12 h-12 rounded-lg flex items-center justify-center transition {{ $icon === $iconClass ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}"
                            title="{{ $iconClass }}">
                            <i class="{{ $iconClass }}"></i>
                        </button>
                    @endforeach
                </div>

                {{-- Custom Icon Input --}}
                <div class="mt-3">
                    <label for="icon" class="block text-xs font-medium text-slate-700 mb-1">
                        Or enter custom FontAwesome class:
                    </label>
                    <input 
                        type="text" 
                        id="icon"
                        wire:model.defer="icon"
                        placeholder="fa-solid fa-star"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm @error('icon') border-red-500 @enderror">
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">
                        Visit <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-600 hover:underline">FontAwesome</a> for more icons
                    </p>
                </div>
            </div>

            {{-- Order --}}
            <div class="max-w-xs">
                <label for="order" class="block text-sm font-medium text-slate-700 mb-1">
                    Display Order <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="order"
                    wire:model.defer="order"
                    min="0"
                    step="1"
                    placeholder="0"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('order') border-red-500 @enderror">
                @error('order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-slate-500">Lower numbers appear first</p>
            </div>

            {{-- Active Status --}}
            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
                <input 
                    type="checkbox" 
                    id="is_active"
                    wire:model.defer="is_active"
                    class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition">
                <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">
                    Set this item as active
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-6 border-t border-slate-200">
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition font-medium disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">
                        {{ $isEditMode ? 'Update Item' : 'Create Item' }}
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
