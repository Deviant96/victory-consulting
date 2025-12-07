{{-- Team Member Form Component --}}
<div>
    <div class="admin-card p-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $isEditMode ? 'Edit Team Member' : 'Add Team Member' }}
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                {{ $isEditMode ? 'Update team member information' : 'Add a new member to your team' }}
            </p>
        </div>

        {{-- Form --}}
        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Photo Upload --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Photo <span class="text-red-500">*</span>
                </label>
                
                <div class="flex items-start gap-6">
                    {{-- Preview --}}
                    <div class="shrink-0">
                        @if ($photo)
                            <img 
                                src="{{ $photo->temporaryUrl() }}" 
                                alt="Preview"
                                class="w-32 h-32 rounded-xl object-cover border-2 border-slate-200">
                        @elseif ($existingPhoto)
                            <img 
                                src="{{ asset('storage/' . $existingPhoto) }}" 
                                alt="Current photo"
                                class="w-32 h-32 rounded-xl object-cover border-2 border-slate-200">
                        @else
                            <div class="w-32 h-32 rounded-xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Upload Button --}}
                    <div class="flex-1">
                        <label class="block">
                            <span class="sr-only">Choose photo</span>
                            <input 
                                type="file" 
                                wire:model="photo"
                                accept="image/*"
                                class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-xl file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100
                                    file:cursor-pointer cursor-pointer">
                        </label>
                        
                        <p class="mt-2 text-xs text-slate-500">
                            JPG, PNG, or GIF. Maximum file size 2MB.
                        </p>
                        
                        @if($existingPhoto || $photo)
                            <button 
                                type="button"
                                wire:click="removePhoto"
                                class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium">
                                Remove photo
                            </button>
                        @endif
                        
                        {{-- Upload Progress --}}
                        <div wire:loading wire:target="photo" class="mt-2">
                            <div class="flex items-center gap-2 text-sm text-blue-600">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Uploading...</span>
                            </div>
                        </div>
                        
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Name and Position --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name"
                        wire:model.defer="name"
                        placeholder="John Doe"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="position" class="block text-sm font-medium text-slate-700 mb-1">
                        Position <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="position"
                        wire:model.defer="position"
                        placeholder="Senior Consultant"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('position') border-red-500 @enderror">
                    @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Bio --}}
            <div>
                <label for="bio" class="block text-sm font-medium text-slate-700 mb-1">
                    Bio
                </label>
                <textarea 
                    id="bio"
                    wire:model.defer="bio"
                    rows="4"
                    placeholder="Brief biography of the team member..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y @error('bio') border-red-500 @enderror"></textarea>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Expertise --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-medium text-slate-700">
                        Expertise / Skills
                    </label>
                    <button 
                        type="button"
                        wire:click="addExpertise"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Skill
                    </button>
                </div>
                
                <div class="space-y-2">
                    @foreach($expertise as $index => $skill)
                        <div wire:key="expertise-{{ $index }}" class="flex items-center gap-2">
                            <input 
                                type="text" 
                                wire:model.defer="expertise.{{ $index }}"
                                placeholder="e.g., Strategic Planning"
                                class="flex-1 px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <button 
                                type="button"
                                wire:click="removeExpertise({{ $index }})"
                                class="p-2.5 text-red-600 hover:bg-red-50 rounded-xl transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                    
                    @if(empty($expertise))
                        <p class="text-sm text-slate-500 py-4 text-center border-2 border-dashed border-slate-200 rounded-xl">
                            No expertise added yet. Click "Add Skill" to get started.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-6 border-t border-slate-200">
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition font-medium disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">
                        {{ $isEditMode ? 'Update Team Member' : 'Create Team Member' }}
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
