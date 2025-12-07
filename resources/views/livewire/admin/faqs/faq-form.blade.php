{{-- FAQ Form Component --}}
<div>
    <div class="admin-card p-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $isEditMode ? 'Edit FAQ' : 'Add FAQ' }}
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                {{ $isEditMode ? 'Update FAQ information' : 'Create a new frequently asked question' }}
            </p>
        </div>

        {{-- Form --}}
        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Question --}}
            <div>
                <label for="question" class="block text-sm font-medium text-slate-700 mb-1">
                    Question <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="question"
                    wire:model.defer="question"
                    rows="2"
                    placeholder="Enter the question..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y @error('question') border-red-500 @enderror"></textarea>
                @error('question')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-slate-500">Maximum 500 characters</p>
            </div>

            {{-- Answer --}}
            <div>
                <label for="answer" class="block text-sm font-medium text-slate-700 mb-1">
                    Answer <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="answer"
                    wire:model.defer="answer"
                    rows="6"
                    placeholder="Enter the answer..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y @error('answer') border-red-500 @enderror"></textarea>
                @error('answer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-slate-500">Maximum 2000 characters</p>
            </div>

            {{-- Category and Order --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Category --}}
                <div>
                    <label for="category" class="block text-sm font-medium text-slate-700 mb-1">
                        Category
                    </label>
                    <input 
                        type="text" 
                        id="category"
                        wire:model.defer="category"
                        list="category-suggestions"
                        placeholder="e.g., General, Services, Pricing"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('category') border-red-500 @enderror">
                    
                    {{-- Category Suggestions --}}
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
                    <p class="mt-1 text-xs text-slate-500">Optional - helps group related FAQs</p>
                </div>

                {{-- Order --}}
                <div>
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
            </div>

            {{-- Published Status --}}
            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
                <input 
                    type="checkbox" 
                    id="published"
                    wire:model.defer="published"
                    class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition">
                <label for="published" class="text-sm font-medium text-slate-700 cursor-pointer">
                    Publish this FAQ immediately
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-6 border-t border-slate-200">
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition font-medium disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">
                        {{ $isEditMode ? 'Update FAQ' : 'Create FAQ' }}
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
