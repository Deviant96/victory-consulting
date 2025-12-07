{{-- Business Solution Form Component --}}
<div>
    <div class="admin-card p-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $isEditMode ? 'Edit Business Solution' : 'Add Business Solution' }}
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                {{ $isEditMode ? 'Update business solution information' : 'Create a new business solution with sub-solutions' }}
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
                    placeholder="e.g., Strategy & Planning"
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
                    placeholder="Brief description of this business solution (optional)"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y @error('description') border-red-500 @enderror"></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-slate-500">Maximum 1000 characters</p>
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

            {{-- Sub-Solutions --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">
                            Sub-Solutions
                        </label>
                        <p class="text-xs text-slate-500 mt-0.5">Add specific services or features under this solution</p>
                    </div>
                    <button 
                        type="button"
                        wire:click="addSubSolution"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Sub-Solution
                    </button>
                </div>
                
                <div class="space-y-3">
                    @foreach($subSolutions as $index => $subSolution)
                        <div wire:key="sub-{{ $index }}" class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                {{-- Order Controls --}}
                                <div class="flex flex-col gap-1 shrink-0 pt-1">
                                    <button 
                                        type="button"
                                        wire:click="moveSubSolutionUp({{ $index }})"
                                        @if($index === 0) disabled @endif
                                        class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition disabled:opacity-30 disabled:cursor-not-allowed"
                                        title="Move up">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    </button>
                                    <span class="text-xs text-slate-500 text-center font-medium">{{ $index + 1 }}</span>
                                    <button 
                                        type="button"
                                        wire:click="moveSubSolutionDown({{ $index }})"
                                        @if($index === count($subSolutions) - 1) disabled @endif
                                        class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition disabled:opacity-30 disabled:cursor-not-allowed"
                                        title="Move down">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Sub-Solution Input --}}
                                <div class="flex-1 space-y-3">
                                    <input 
                                        type="text" 
                                        wire:model.defer="subSolutions.{{ $index }}.title"
                                        placeholder="Sub-solution title"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm @error('subSolutions.'.$index.'.title') border-red-500 @enderror">
                                    
                                    @error('subSolutions.'.$index.'.title')
                                        <p class="text-xs text-red-600">{{ $message }}</p>
                                    @enderror

                                    <div class="flex items-center gap-2">
                                        <input 
                                            type="checkbox" 
                                            id="sub-active-{{ $index }}"
                                            wire:model.defer="subSolutions.{{ $index }}.is_active"
                                            class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition">
                                        <label for="sub-active-{{ $index }}" class="text-sm text-slate-700 cursor-pointer">
                                            Active
                                        </label>
                                    </div>
                                </div>
                                
                                {{-- Remove Button --}}
                                <button 
                                    type="button"
                                    wire:click="removeSubSolution({{ $index }})"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                    
                    @if(empty($subSolutions))
                        <div class="text-sm text-slate-500 py-6 text-center border-2 border-dashed border-slate-200 rounded-xl">
                            No sub-solutions added yet. Click "Add Sub-Solution" to get started.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Active Status --}}
            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
                <input 
                    type="checkbox" 
                    id="is_active"
                    wire:model.defer="is_active"
                    class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition">
                <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">
                    Set this solution as active
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-6 border-t border-slate-200">
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition font-medium disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">
                        {{ $isEditMode ? 'Update Solution' : 'Create Solution' }}
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
