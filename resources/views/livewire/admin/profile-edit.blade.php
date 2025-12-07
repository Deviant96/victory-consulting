<div class="max-w-4xl mx-auto">
    @if (session()->has('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tab Navigation -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="flex border-b border-gray-200">
            <button
                wire:click="$set('activeTab', 'profile')"
                class="px-6 py-4 text-sm font-medium {{ $activeTab === 'profile' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }}"
            >
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile Information
            </button>
            <button
                wire:click="$set('activeTab', 'password')"
                class="px-6 py-4 text-sm font-medium {{ $activeTab === 'password' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }}"
            >
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Password
            </button>
            <button
                wire:click="$set('activeTab', 'security')"
                class="px-6 py-4 text-sm font-medium {{ $activeTab === 'security' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }}"
            >
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Security
            </button>
        </div>
    </div>

    <!-- Profile Information Tab -->
    <div class="bg-white rounded-xl shadow-sm p-6" x-show="$wire.activeTab === 'profile'">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Profile Information</h2>
        
        <form wire:submit.prevent="updateProfile">
            <!-- Avatar Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover ring-2 ring-indigo-500">
                        @elseif ($currentAvatarPath)
                            <img src="{{ Storage::url($currentAvatarPath) }}" class="w-20 h-20 rounded-full object-cover ring-2 ring-gray-300">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-semibold ring-2 ring-gray-300">
                                {{ substr($name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <label class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 cursor-pointer">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Upload New
                            <input type="file" wire:model="avatar" class="hidden" accept="image/*">
                        </label>
                        @if ($currentAvatarPath)
                            <button 
                                type="button" 
                                wire:click="removeAvatar" 
                                class="px-4 py-2 bg-red-50 border border-red-200 rounded-xl text-sm font-medium text-red-600 hover:bg-red-100"
                            >
                                Remove
                            </button>
                        @endif
                    </div>
                </div>
                @error('avatar') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                <p class="text-gray-500 text-xs mt-2">JPG, PNG or GIF. Max 2MB.</p>
                
                <div wire:loading wire:target="avatar" class="text-sm text-gray-600 mt-2">
                    Uploading...
                </div>
            </div>

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input 
                    type="text" 
                    id="name" 
                    wire:model="name" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                >
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    wire:model="email" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                >
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button 
                type="submit" 
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition font-semibold"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Save Profile
            </button>
        </form>
    </div>

    <!-- Password Tab -->
    <div class="bg-white rounded-xl shadow-sm p-6" x-show="$wire.activeTab === 'password'" style="display: none;">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Change Password</h2>
        
        <form wire:submit.prevent="updatePassword">
            <!-- Current Password -->
            <div class="mb-6">
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                <input 
                    type="password" 
                    id="current_password" 
                    wire:model="current_password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 @error('current_password') border-red-500 @enderror"
                    autocomplete="current-password"
                >
                @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- New Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input 
                    type="password" 
                    id="password" 
                    wire:model="password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror"
                    autocomplete="new-password"
                >
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                <p class="text-gray-500 text-xs mt-1">Minimum 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    wire:model="password_confirmation" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500"
                    autocomplete="new-password"
                >
            </div>

            <button 
                type="submit" 
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition font-semibold"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Update Password
            </button>
        </form>
    </div>

    <!-- Security Tab -->
    <div class="bg-white rounded-xl shadow-sm p-6" x-show="$wire.activeTab === 'security'" style="display: none;">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Security Settings</h2>
        
        <!-- Two-Factor Authentication -->
        <div class="border border-gray-200 rounded-xl p-6">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Two-Factor Authentication</h3>
                    <p class="text-sm text-gray-600 mb-4">Add an extra layer of security to your account by requiring a verification code in addition to your password.</p>
                    
                    @if ($two_factor_enabled)
                        <div class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Enabled
                        </div>
                    @else
                        <div class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            Disabled
                        </div>
                    @endif
                </div>
                
                <div>
                    @if ($two_factor_enabled)
                        <button 
                            wire:click="disableTwoFactor" 
                            class="px-4 py-2 bg-red-50 border border-red-200 rounded-xl text-sm font-medium text-red-600 hover:bg-red-100"
                        >
                            Disable
                        </button>
                    @else
                        <button 
                            wire:click="enableTwoFactor" 
                            class="px-4 py-2 bg-green-50 border border-green-200 rounded-xl text-sm font-medium text-green-600 hover:bg-green-100"
                        >
                            Enable
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
