<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Site Settings</h1>
                <p class="text-gray-600 mt-2">Manage your website's configuration and preferences</p>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px flex-wrap" x-data="{ activeTab: @entangle('activeTab') }">
                <button 
                    @click="activeTab = 'contact'"
                    :class="activeTab === 'contact' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="flex-1 min-w-[120px] py-4 px-2 text-center border-b-2 font-medium text-sm transition-colors duration-200"
                >
                    <i class="fas fa-phone mr-1"></i>
                    <span class="hidden sm:inline">Contact</span>
                </button>
                <button 
                    @click="activeTab = 'social'"
                    :class="activeTab === 'social' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="flex-1 min-w-[120px] py-4 px-2 text-center border-b-2 font-medium text-sm transition-colors duration-200"
                >
                    <i class="fas fa-share-alt mr-1"></i>
                    <span class="hidden sm:inline">Social</span>
                </button>
                <button 
                    @click="activeTab = 'branding'"
                    :class="activeTab === 'branding' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="flex-1 min-w-[120px] py-4 px-2 text-center border-b-2 font-medium text-sm transition-colors duration-200"
                >
                    <i class="fas fa-palette mr-1"></i>
                    <span class="hidden sm:inline">Branding</span>
                </button>
                <button 
                    @click="activeTab = 'hero'"
                    :class="activeTab === 'hero' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="flex-1 min-w-[120px] py-4 px-2 text-center border-b-2 font-medium text-sm transition-colors duration-200"
                >
                    <i class="fas fa-home mr-1"></i>
                    <span class="hidden sm:inline">Hero</span>
                </button>
                <button 
                    @click="activeTab = 'notifications'"
                    :class="activeTab === 'notifications' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="flex-1 min-w-[120px] py-4 px-2 text-center border-b-2 font-medium text-sm transition-colors duration-200"
                >
                    <i class="fas fa-bell mr-1"></i>
                    <span class="hidden sm:inline">Booking</span>
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Contact Tab -->
            <div x-show="$wire.activeTab === 'contact'" x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">
                <form wire:submit.prevent="saveContact">
                    <div class="space-y-6">
                        <!-- Email -->
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>Email Address
                            </label>
                            <input 
                                type="email" 
                                id="contact_email"
                                wire:model="contact_email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('contact_email') border-red-500 @enderror"
                                placeholder="info@victorygroup.com"
                            >
                            @error('contact_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone text-gray-400 mr-2"></i>Phone Number
                            </label>
                            <input 
                                type="text" 
                                id="contact_phone"
                                wire:model="contact_phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('contact_phone') border-red-500 @enderror"
                                placeholder="+1 234 567 8900"
                            >
                            @error('contact_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>Physical Address
                            </label>
                            <textarea 
                                id="contact_address"
                                wire:model="contact_address"
                                rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('contact_address') border-red-500 @enderror"
                                placeholder="123 Business St, City, State, ZIP"
                            ></textarea>
                            @error('contact_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Working Hours -->
                        <div>
                            <label for="contact_working_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clock text-gray-400 mr-2"></i>Working Hours
                            </label>
                            <input 
                                type="text" 
                                id="contact_working_hours"
                                wire:model="contact_working_hours"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('contact_working_hours') border-red-500 @enderror"
                                placeholder="Mon-Fri 9:00 AM - 6:00 PM"
                            >
                            @error('contact_working_hours')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-8 flex justify-end">
                        <button 
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Save Contact Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Social Tab -->
            <div x-show="$wire.activeTab === 'social'" x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">
                <form wire:submit.prevent="saveSocial">
                    <div class="space-y-6">
                        <!-- Facebook -->
                        <div>
                            <label for="social_facebook" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook URL
                            </label>
                            <input 
                                type="url" 
                                id="social_facebook"
                                wire:model="social_facebook"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('social_facebook') border-red-500 @enderror"
                                placeholder="https://facebook.com/yourpage"
                            >
                            @error('social_facebook')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Twitter -->
                        <div>
                            <label for="social_twitter" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-twitter text-sky-500 mr-2"></i>Twitter URL
                            </label>
                            <input 
                                type="url" 
                                id="social_twitter"
                                wire:model="social_twitter"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('social_twitter') border-red-500 @enderror"
                                placeholder="https://twitter.com/yourhandle"
                            >
                            @error('social_twitter')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Instagram -->
                        <div>
                            <label for="social_instagram" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram URL
                            </label>
                            <input 
                                type="url" 
                                id="social_instagram"
                                wire:model="social_instagram"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('social_instagram') border-red-500 @enderror"
                                placeholder="https://instagram.com/yourprofile"
                            >
                            @error('social_instagram')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- LinkedIn -->
                        <div>
                            <label for="social_linkedin" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-linkedin text-blue-700 mr-2"></i>LinkedIn URL
                            </label>
                            <input 
                                type="url" 
                                id="social_linkedin"
                                wire:model="social_linkedin"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('social_linkedin') border-red-500 @enderror"
                                placeholder="https://linkedin.com/company/yourcompany"
                            >
                            @error('social_linkedin')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- YouTube -->
                        <div>
                            <label for="social_youtube" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-youtube text-red-600 mr-2"></i>YouTube URL
                            </label>
                            <input 
                                type="url" 
                                id="social_youtube"
                                wire:model="social_youtube"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('social_youtube') border-red-500 @enderror"
                                placeholder="https://youtube.com/@yourchannel"
                            >
                            @error('social_youtube')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Save Button -->
                    <div class="mt-8 flex justify-end">
                        <button 
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Save Social Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Branding Tab -->
            <div x-show="$wire.activeTab === 'branding'" x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">
                <form wire:submit.prevent="saveBranding">
                    <div class="space-y-6">
                        <!-- Site Name -->
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-building text-gray-400 mr-2"></i>Site Name
                            </label>
                            <input 
                                type="text" 
                                id="site_name"
                                wire:model="site_name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('site_name') border-red-500 @enderror"
                                placeholder="Victory Consulting Group"
                            >
                            @error('site_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Site Tagline -->
                        <div>
                            <label for="site_tagline" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag text-gray-400 mr-2"></i>Site Tagline
                            </label>
                            <input 
                                type="text" 
                                id="site_tagline"
                                wire:model="site_tagline"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('site_tagline') border-red-500 @enderror"
                                placeholder="Your trusted partner in business transformation"
                            >
                            @error('site_tagline')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Logo Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-image text-gray-400 mr-2"></i>Site Logo
                            </label>
                            
                            @if ($site_logo)
                                <div class="mb-4 relative inline-block">
                                    <img src="{{ $site_logo->temporaryUrl() }}" class="h-24 rounded-lg border-2 border-gray-300">
                                    <button 
                                        type="button"
                                        wire:click="removeLogo"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                    >
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                            @elseif ($existing_logo)
                                <div class="mb-4 relative inline-block">
                                    <img src="{{ asset('storage/' . $existing_logo) }}" class="h-24 rounded-lg border-2 border-gray-300">
                                    <button 
                                        type="button"
                                        wire:click="removeLogo"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                    >
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                            @endif

                            <input 
                                type="file" 
                                wire:model="site_logo"
                                accept="image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('site_logo') border-red-500 @enderror"
                            >
                            <p class="text-sm text-gray-500 mt-1">Maximum file size: 2MB. Recommended: PNG with transparent background.</p>
                            @error('site_logo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Favicon Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-icons text-gray-400 mr-2"></i>Site Favicon
                            </label>
                            
                            @if ($site_favicon)
                                <div class="mb-4 relative inline-block">
                                    <img src="{{ $site_favicon->temporaryUrl() }}" class="h-16 w-16 rounded-lg border-2 border-gray-300">
                                    <button 
                                        type="button"
                                        wire:click="removeFavicon"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                    >
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                            @elseif ($existing_favicon)
                                <div class="mb-4 relative inline-block">
                                    <img src="{{ asset('storage/' . $existing_favicon) }}" class="h-16 w-16 rounded-lg border-2 border-gray-300">
                                    <button 
                                        type="button"
                                        wire:click="removeFavicon"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                    >
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                            @endif

                            <input 
                                type="file" 
                                wire:model="site_favicon"
                                accept="image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('site_favicon') border-red-500 @enderror"
                            >
                            <p class="text-sm text-gray-500 mt-1">Maximum file size: 512KB. Recommended: 32x32px or 64x64px ICO/PNG.</p>
                            @error('site_favicon')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-8 flex justify-end">
                        <button 
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Save Branding Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Hero Section Tab -->
            <div x-show="$wire.activeTab === 'hero'" x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">
                <form wire:submit.prevent="saveHero">
                    <!-- Homepage Hero Section -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Homepage Hero
                        </h2>

                        <div class="space-y-6">
                            <!-- Background Image -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-image text-gray-400 mr-2"></i>Background Image
                                </label>
                                @if ($existing_background_image)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $existing_background_image) }}" alt="Current Hero Background" class="w-full max-w-2xl h-56 object-cover rounded-lg shadow-md">
                                        <p class="text-sm text-gray-500 mt-1">Current homepage background image</p>
                                    </div>
                                @endif
                                <input 
                                    type="file" 
                                    wire:model="background_image"
                                    accept="image/*"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('background_image') border-red-500 @enderror"
                                >
                                @error('background_image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-500 text-sm mt-1">Recommended: 1920x600px or larger, max 4MB. Leave empty to use gradient background only.</p>
                            </div>

                            <!-- Text Alignment -->
                            <div>
                                <label for="text_alignment" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-align-center text-gray-400 mr-2"></i>Text Alignment
                                </label>
                                <select 
                                    id="text_alignment"
                                    wire:model="text_alignment"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('text_alignment') border-red-500 @enderror"
                                >
                                    <option value="left">Left</option>
                                    <option value="center">Center</option>
                                    <option value="right">Right</option>
                                </select>
                                @error('text_alignment')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-500 text-sm mt-1">Choose how to align the hero section text content</p>
                            </div>
                        </div>
                    </div>

                    <!-- Industry Page Full-Width Image -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Industry Page Full-Width Image
                        </h2>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-industry text-gray-400 mr-2"></i>Industry Hero Image
                            </label>
                            @if ($existing_industry_image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $existing_industry_image) }}" alt="Current Industry Hero" class="w-full max-w-2xl h-48 object-cover rounded-lg shadow-md">
                                    <p class="text-sm text-gray-500 mt-1">Current industry page hero image</p>
                                </div>
                            @endif
                            <input 
                                type="file" 
                                wire:model="industry_image"
                                accept="image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('industry_image') border-red-500 @enderror"
                            >
                            @error('industry_image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Recommended: 1920x400px or larger, max 4MB. Displays as full-width banner below the industry page hero section.</p>
                        </div>
                    </div>

                    <!-- Image Guidelines -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Image Guidelines
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold text-blue-800 mb-2">Homepage Hero</h4>
                                <ul class="list-disc list-inside text-blue-800 space-y-1 text-sm">
                                    <li>Use high-quality images that represent your business</li>
                                    <li>Ensure good contrast with white text overlay</li>
                                    <li>Image displays with 30% opacity over gradient</li>
                                    <li>Test different text alignments with your image</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-semibold text-blue-800 mb-2">Industry Page Image</h4>
                                <ul class="list-disc list-inside text-blue-800 space-y-1 text-sm">
                                    <li>Displays as full-width banner below hero section</li>
                                    <li>Should represent industry expertise visually</li>
                                    <li>Use professional, high-resolution images</li>
                                    <li>Works best with wide landscape orientations</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-8 flex justify-end">
                        <button 
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Save Hero Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Booking Notifications Tab -->
            <div x-show="$wire.activeTab === 'notifications'" x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">
                <form wire:submit.prevent="saveBookingNotifications">
                    <div class="space-y-6">
                        <!-- Email Notifications Toggle -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-900">
                                    <i class="fas fa-envelope text-gray-400 mr-2"></i>Email Notifications
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Receive email notifications for new bookings</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="booking_email_notifications" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <!-- SMS Notifications Toggle -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-900">
                                    <i class="fas fa-sms text-gray-400 mr-2"></i>SMS Notifications
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Receive SMS notifications for new bookings</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="booking_sms_notifications" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <!-- Notification Email -->
                        <div>
                            <label for="booking_notification_email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-at text-gray-400 mr-2"></i>Notification Email Address
                            </label>
                            <input 
                                type="email" 
                                id="booking_notification_email"
                                wire:model="booking_notification_email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                placeholder="bookings@victorygroup.com"
                            >
                            <p class="text-xs text-gray-500 mt-1">Leave blank to use default contact email</p>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-8 flex justify-end">
                        <button 
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Save Notification Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
