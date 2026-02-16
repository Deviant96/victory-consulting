@extends('admin.layouts.app')
    
@section('title', 'About Us Page')
@section('page-title', 'About Us Page')
@section('page-description', 'Manage your About Us page content')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">{{ t('About Us Page', 'About Us Page') }}</h1>
    <p class="text-gray-600 mt-2">{{ t('Edit all content for the About Us page in one place', 'Edit all content for the About Us page in one place') }}</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow">
    <form action="{{ route('admin.settings.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ t('Page Header', 'Page Header') }}</h2>

            <div class="mb-6">
                <label for="hero_tagline" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Hero Tagline', 'Hero Tagline') }}</label>
                <input type="text" name="about[hero_tagline]" id="hero_tagline"
                       value="{{ old('about.hero_tagline', optional($settings->get('about.hero_tagline'))->value ?? 'Trusted Finance & Business Advisory') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                @error('about.hero_tagline')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">{{ t('Small label shown above the main About heading', 'Small label shown above the main About heading') }}</p>
            </div>
            
            <div class="mb-6">
                <label for="header_title" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Header Title', 'Header Title') }} *</label>
                <input type="text" name="about[header_title]" id="header_title" 
                       value="{{ old('about.header_title', optional($settings->get('about.header_title'))->value ?? 'About Us') }}" 
                       required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                @error('about.header_title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="header_description" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Header Description', 'Header Description') }}</label>
                <textarea name="about[header_description]" id="header_description" rows="2" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">{{ old('about.header_description', optional($settings->get('about.header_description'))->value ?? '') }}</textarea>
                @error('about.header_description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">{{ t('Brief introduction shown in the header', 'Brief introduction shown in the header') }}</p>
            </div>

            <div class="mb-1">
                <label for="hero_image" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Hero Image', 'Hero Image') }}</label>
                @if(optional($settings->get('about.hero_image'))->value)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings->get('about.hero_image')->value) }}"
                         alt="Hero Image"
                         class="w-72 h-40 object-cover rounded-lg border border-gray-200">
                </div>
                @endif
                <input type="file" name="hero_image" id="hero_image" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                @error('hero_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">{{ t('Recommended: executive consultation meeting in a modern office boardroom', 'Recommended: executive consultation meeting in a modern office boardroom') }}</p>
            </div>
        </div>

        <!-- Founder's Wisdom Section -->
        <div class="p-6 border-b border-gray-200 bg-orange-50">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                {{ t('Founders Wisdom', "Founder's Wisdom") }}
            </h2>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="principles_heading" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Principles Section Heading', 'Principles Section Heading') }}</label>
                    <input type="text" name="about[principles_heading]" id="principles_heading"
                           value="{{ old('about.principles_heading', optional($settings->get('about.principles_heading'))->value ?? "Founder's Principles") }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                    @error('about.principles_heading')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="principles_subheading" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Principles Section Subheading', 'Principles Section Subheading') }}</label>
                    <textarea name="about[principles_subheading]" id="principles_subheading" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">{{ old('about.principles_subheading', optional($settings->get('about.principles_subheading'))->value ?? 'The values that shape our consulting quality and long-term client partnerships.') }}</textarea>
                    @error('about.principles_subheading')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Wisdom 1 (Map of Indonesia) -->
                <div class="bg-white rounded-lg p-6 border-2 border-orange-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        {{ t('Wisdom 1 - Indonesia Map', 'Wisdom 1 - Indonesia Map') }}
                    </h3>
                    
                    <div class="mb-4">
                        <label for="wisdom1_title" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Title', 'Title') }}</label>
                        <input type="text" name="about[wisdom1_title]" id="wisdom1_title" 
                               value="{{ old('about.wisdom1_title', optional($settings->get('about.wisdom1_title'))->value ?? 'Melayani Sepenuh Hati') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        @error('about.wisdom1_title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="wisdom1_description" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Description', 'Description') }}</label>
                        <textarea name="about[wisdom1_description]" id="wisdom1_description" rows="2" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">{{ old('about.wisdom1_description', optional($settings->get('about.wisdom1_description'))->value ?? 'Klien dari Seluruh Indonesia') }}</textarea>
                        @error('about.wisdom1_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="wisdom1_image" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Icon/Image', 'Icon/Image') }}</label>
                        @if(optional($settings->get('about.wisdom1_image'))->value)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $settings->get('about.wisdom1_image')->value) }}" 
                                 alt="Wisdom 1 Image" 
                                 class="w-32 h-32 object-contain rounded-lg border border-gray-200 bg-white p-2">
                        </div>
                        @endif
                        <input type="file" name="wisdom1_image" id="wisdom1_image" accept="image/*" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        @error('wisdom1_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">{{ t('Upload an icon or image for this wisdom card', 'Upload an icon or image for this wisdom card') }}</p>
                    </div>
                </div>

                <!-- Wisdom 2 (Growth Arrows) -->
                <div class="bg-white rounded-lg p-6 border-2 border-orange-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        {{ t('Wisdom 2 - Growth Arrows', 'Wisdom 2 - Growth Arrows') }}
                    </h3>
                    
                    <div class="mb-4">
                        <label for="wisdom2_title" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Title', 'Title') }}</label>
                        <input type="text" name="about[wisdom2_title]" id="wisdom2_title" 
                               value="{{ old('about.wisdom2_title', optional($settings->get('about.wisdom2_title'))->value ?? 'Membantu Bisnis Tumbuh') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        @error('about.wisdom2_title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="wisdom2_description" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Description', 'Description') }}</label>
                        <textarea name="about[wisdom2_description]" id="wisdom2_description" rows="2" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">{{ old('about.wisdom2_description', optional($settings->get('about.wisdom2_description'))->value ?? 'dan UMKM Berkembang') }}</textarea>
                        @error('about.wisdom2_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="wisdom2_image" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Icon/Image', 'Icon/Image') }}</label>
                        @if(optional($settings->get('about.wisdom2_image'))->value)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $settings->get('about.wisdom2_image')->value) }}" 
                                 alt="Wisdom 2 Image" 
                                 class="w-32 h-32 object-contain rounded-lg border border-gray-200 bg-white p-2">
                        </div>
                        @endif
                        <input type="file" name="wisdom2_image" id="wisdom2_image" accept="image/*" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        @error('wisdom2_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">{{ t('Upload an icon or image for this wisdom card', 'Upload an icon or image for this wisdom card') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main About Content -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ t('Main About Content', 'Main About Content') }}</h2>

            <div class="mb-6">
                <label for="story_heading" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Story Heading', 'Story Heading') }}</label>
                <input type="text" name="about[story_heading]" id="story_heading"
                       value="{{ old('about.story_heading', optional($settings->get('about.story_heading'))->value ?? 'Our Story') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                @error('about.story_heading')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="about_content" class="block text-sm font-medium text-gray-700 mb-2">{{ t('About Us Content', 'About Us Content') }} *</label>
                <textarea name="about[content]" id="about_content" rows="15" 
                          required
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 font-mono text-sm">{{ old('about.content', optional($settings->get('about.content'))->value ?? '') }}</textarea>
                @error('about.content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">
                    {{ t('Write your complete About Us content here', 'Write your complete About Us content here. Use line breaks to separate paragraphs. This will be displayed as the main content on your About Us page.') }}
                </p>
            </div>

            <div class="mb-1">
                <label for="story_image" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Story Image', 'Story Image') }}</label>
                @if(optional($settings->get('about.story_image'))->value)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings->get('about.story_image')->value) }}"
                         alt="Story Image"
                         class="w-72 h-40 object-cover rounded-lg border border-gray-200">
                </div>
                @endif
                <input type="file" name="story_image" id="story_image" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                @error('story_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">{{ t('Recommended: team reviewing financial reports, dashboards, or strategic planning documents', 'Recommended: team reviewing financial reports, dashboards, or strategic planning documents') }}</p>
            </div>
        </div>

        <!-- Vision Section -->
        <div class="p-6 border-b border-gray-200 bg-blue-50">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                {{ t('Vision', 'Vision') }}
            </h2>
            
            <div class="mb-6">
                <label for="vision_title" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Vision Title', 'Vision Title') }}</label>
                <input type="text" name="about[vision_title]" id="vision_title" 
                       value="{{ old('about.vision_title', optional($settings->get('about.vision_title'))->value ?? 'Our Vision') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                @error('about.vision_title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="vision_content" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Vision Content', 'Vision Content') }}</label>
                <textarea name="about[vision_content]" id="vision_content" rows="5" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">{{ old('about.vision_content', optional($settings->get('about.vision_content'))->value ?? '') }}</textarea>
                @error('about.vision_content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="vision_image" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Vision Image', 'Vision Image') }}</label>
                @if(optional($settings->get('about.vision_image'))->value)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings->get('about.vision_image')->value) }}" 
                         alt="Vision Image" 
                         class="w-48 h-24 object-cover rounded-lg">
                </div>
                @endif
                <input type="file" name="vision_image" id="vision_image" accept="image/*" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                @error('vision_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">{{ t('Recommended: Image of a woman offering handshake', 'Recommended: Image of a woman offering handshake') }}</p>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="p-6 border-b border-gray-200 bg-green-50">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                {{ t('Mission', 'Mission') }}
            </h2>
            
            <div class="mb-6">
                <label for="mission_title" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Mission Title', 'Mission Title') }}</label>
                <input type="text" name="about[mission_title]" id="mission_title" 
                       value="{{ old('about.mission_title', optional($settings->get('about.mission_title'))->value ?? 'Our Mission') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                @error('about.mission_title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="mission_content" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Mission Content', 'Mission Content') }}</label>
                <textarea name="about[mission_content]" id="mission_content" rows="5" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">{{ old('about.mission_content', optional($settings->get('about.mission_content'))->value ?? '') }}</textarea>
                @error('about.mission_content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="mission_image" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Mission Image', 'Mission Image') }}</label>
                @if(optional($settings->get('about.mission_image'))->value)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings->get('about.mission_image')->value) }}" 
                         alt="Mission Image" 
                         class="w-48 h-24 object-cover rounded-lg">
                </div>
                @endif
                <input type="file" name="mission_image" id="mission_image" accept="image/*" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                @error('mission_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">{{ t('Recommended: Image of a man offering handshake', 'Recommended: Image of a man offering handshake') }}</p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="p-6 border-b border-gray-200 bg-orange-50">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
                {{ t('Call to Action Section', 'Call to Action Section') }}
            </h2>
            
            <div class="mb-6">
                <label for="cta_heading" class="block text-sm font-medium text-gray-700 mb-2">{{ t('CTA Heading', 'CTA Heading') }}</label>
                <input type="text" name="about[cta_heading]" id="cta_heading" 
                       value="{{ old('about.cta_heading', optional($settings->get('about.cta_heading'))->value ?? 'Ready to Transform Your Business?') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                @error('about.cta_heading')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="cta_description" class="block text-sm font-medium text-gray-700 mb-2">{{ t('CTA Description', 'CTA Description') }}</label>
                <textarea name="about[cta_description]" id="cta_description" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">{{ old('about.cta_description', optional($settings->get('about.cta_description'))->value ?? optional($settings->get('about.cta_subheading'))->value ?? 'Contact us today for a free consultation and discover how we can help your business thrive.') }}</textarea>
                @error('about.cta_description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="cta_primary_button" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Primary Button Text', 'Primary Button Text') }}</label>
                    <input type="text" name="about[cta_primary_button]" id="cta_primary_button" 
                           value="{{ old('about.cta_primary_button', optional($settings->get('about.cta_primary_button'))->value ?? 'Get in Touch') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                    @error('about.cta_primary_button')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cta_secondary_button" class="block text-sm font-medium text-gray-700 mb-2">{{ t('Secondary Button Text', 'Secondary Button Text') }}</label>
                    <input type="text" name="about[cta_secondary_button]" id="cta_secondary_button" 
                           value="{{ old('about.cta_secondary_button', optional($settings->get('about.cta_secondary_button'))->value ?? 'Explore Services') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                    @error('about.cta_secondary_button')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        @include('admin.components.settings-translation-tabs', [
            'languages' => $languages,
            'settings' => $settings,
            'fields' => [
                'header_title' => 'Header Title',
                'header_description' => 'Header Description',
                'hero_tagline' => 'Hero Tagline',
                'principles_heading' => 'Principles Section Heading',
                'principles_subheading' => 'Principles Section Subheading',
                'story_heading' => 'Story Heading',
                'content' => 'About Us Content',
                'wisdom1_title' => 'Wisdom 1 Title',
                'wisdom1_description' => 'Wisdom 1 Description',
                'wisdom2_title' => 'Wisdom 2 Title',
                'wisdom2_description' => 'Wisdom 2 Description',
                'vision_title' => 'Vision Title',
                'vision_content' => 'Vision Content',
                'mission_title' => 'Mission Title',
                'mission_content' => 'Mission Content',
                'cta_heading' => 'CTA Heading',
                'cta_description' => 'CTA Description',
                'cta_primary_button' => 'Primary Button Text',
                'cta_secondary_button' => 'Secondary Button Text',
            ],
        ])

        <!-- Submit Button -->
        <div class="p-6 bg-gray-50">
            <div class="flex gap-4">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ t('Save About Us Page', 'Save About Us Page') }}
                </button>
                <a href="{{ route('about') }}" target="_blank"
                   class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    {{ t('Preview Page', 'Preview Page') }}
                </a>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textareas as user types
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Trigger on page load
        textarea.dispatchEvent(new Event('input'));
    });
});
</script>
@endpush
@endsection
