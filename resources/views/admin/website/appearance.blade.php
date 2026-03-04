@extends('admin.layouts.app')

@section('title', 'Appearance Settings')
@section('page-title', 'Appearance Settings')

@section('content')
    @php
        $currentLogo = $settings['appearance.logo'] ?? settings('branding.logo');
        $currentFavicon = $settings['appearance.favicon'] ?? settings('branding.favicon');
        $currentPrimary = old('appearance.primary_color', $settings['appearance.primary_color'] ?? '#0481AE');
        $currentSecondary = old('appearance.secondary_color', $settings['appearance.secondary_color'] ?? '#035f7f');
        $currentCtaCustom = old('appearance.cta_background_custom', $settings['appearance.cta_background_custom'] ?? '#0481AE');
    @endphp

<div
    class="space-y-6 max-w-6xl"
    x-data="{
        usePrimary: {{ old('appearance.primary_button_use_theme', $settings['appearance.primary_button_use_theme'] ?? '1') == '1' ? 'true' : 'false' }},
        useSecondary: {{ old('appearance.secondary_button_use_theme', $settings['appearance.secondary_button_use_theme'] ?? '1') == '1' ? 'true' : 'false' }},
        useCtaButtonTheme: {{ old('appearance.cta_button_use_theme', $settings['appearance.cta_button_use_theme'] ?? '1') == '1' ? 'true' : 'false' }},
        ctaBackgroundMode: '{{ old('appearance.cta_background_mode', $settings['appearance.cta_background_mode'] ?? 'primary') }}',
        primaryColor: '{{ $currentPrimary }}',
        secondaryColor: '{{ $currentSecondary }}',
        ctaCustomColor: '{{ $currentCtaCustom }}',
        primaryButtonStyle: '{{ old('appearance.primary_button_style', $settings['appearance.primary_button_style'] ?? 'solid') }}',
        secondaryButtonStyle: '{{ old('appearance.secondary_button_style', $settings['appearance.secondary_button_style'] ?? 'outline') }}',
        primaryButtonBg: '{{ old('appearance.primary_button_bg', $settings['appearance.primary_button_bg'] ?? '#0481AE') }}',
        primaryButtonText: '{{ old('appearance.primary_button_text', $settings['appearance.primary_button_text'] ?? '#ffffff') }}',
        secondaryButtonBg: '{{ old('appearance.secondary_button_bg', $settings['appearance.secondary_button_bg'] ?? '#035f7f') }}',
        secondaryButtonText: '{{ old('appearance.secondary_button_text', $settings['appearance.secondary_button_text'] ?? '#ffffff') }}',
        headerSticky: {{ old('appearance.header_sticky', $settings['appearance.header_sticky'] ?? '1') == '1' ? 'true' : 'false' }},
    }"
>

    <form action="{{ route('admin.website.appearance.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        @csrf

        <div class="xl:col-span-8 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-5">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Brand Colors</h2>
                    <p class="text-sm text-gray-500 mt-1">Main colors used across your website.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Primary Color</label>
                        <div class="flex items-center gap-3">
                            <div class="relative flex-none">
                                <input type="color" name="appearance[primary_color]" x-model="primaryColor" value="{{ $currentPrimary }}" class="h-10 w-10 rounded-lg border-0 p-0 overflow-hidden cursor-pointer shadow-sm">
                                <div class="absolute inset-0 rounded-lg border border-black/10 pointer-events-none"></div>
                            </div>
                            <input type="text" x-model="primaryColor" class="flex-1 text-sm font-mono border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 uppercase" maxlength="7">
                        </div>
                    </div>
                    <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Color</label>
                        <div class="flex items-center gap-3">
                            <div class="relative flex-none">
                                <input type="color" name="appearance[secondary_color]" x-model="secondaryColor" value="{{ $currentSecondary }}" class="h-10 w-10 rounded-lg border-0 p-0 overflow-hidden cursor-pointer shadow-sm">
                                <div class="absolute inset-0 rounded-lg border border-black/10 pointer-events-none"></div>
                            </div>
                            <input type="text" x-model="secondaryColor" class="flex-1 text-sm font-mono border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 uppercase" maxlength="7">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Buttons</h2>
                    <p class="text-sm text-gray-500 mt-1">Hero and CTA button styles.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4 rounded-xl border border-gray-200 p-4 bg-gray-50/70">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900">Primary Button</h3>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="appearance[primary_button_use_theme]" value="1" x-model="usePrimary" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ml-2 text-xs text-gray-500">Use theme</span>
                            </label>
                            <input type="hidden" name="appearance[primary_button_use_theme]" value="0" x-if="!usePrimary">
                        </div>

                        <select name="appearance[primary_button_style]" x-model="primaryButtonStyle" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="solid" {{ old('appearance.primary_button_style', $settings['appearance.primary_button_style'] ?? 'solid') === 'solid' ? 'selected' : '' }}>Solid</option>
                            <option value="outline" {{ old('appearance.primary_button_style', $settings['appearance.primary_button_style'] ?? 'solid') === 'outline' ? 'selected' : '' }}>Outline</option>
                        </select>
                        <div class="grid grid-cols-2 gap-3" x-show="!usePrimary" x-transition>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Background</label>
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-none">
                                        <input type="color" name="appearance[primary_button_bg]" x-model="primaryButtonBg" value="{{ old('appearance.primary_button_bg', $settings['appearance.primary_button_bg'] ?? '#0481AE') }}" class="h-8 w-8 rounded border-0 p-0 overflow-hidden cursor-pointer">
                                        <div class="absolute inset-0 rounded border border-black/10 pointer-events-none"></div>
                                    </div>
                                    <input type="text" x-model="primaryButtonBg" class="w-full text-xs font-mono border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500 p-1 uppercase" maxlength="7">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Text</label>
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-none">
                                        <input type="color" name="appearance[primary_button_text]" x-model="primaryButtonText" value="{{ old('appearance.primary_button_text', $settings['appearance.primary_button_text'] ?? '#ffffff') }}" class="h-8 w-8 rounded border-0 p-0 overflow-hidden cursor-pointer">
                                        <div class="absolute inset-0 rounded border border-black/10 pointer-events-none"></div>
                                    </div>
                                    <input type="text" x-model="primaryButtonText" class="w-full text-xs font-mono border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500 p-1 uppercase" maxlength="7">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 rounded-xl border border-gray-200 p-4 bg-gray-50/70">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900">Secondary Button</h3>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="appearance[secondary_button_use_theme]" value="1" x-model="useSecondary" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ml-2 text-xs text-gray-500">Use theme</span>
                            </label>
                            <input type="hidden" name="appearance[secondary_button_use_theme]" value="0" x-if="!useSecondary">
                        </div>

                        <select name="appearance[secondary_button_style]" x-model="secondaryButtonStyle" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="solid" {{ old('appearance.secondary_button_style', $settings['appearance.secondary_button_style'] ?? 'outline') === 'solid' ? 'selected' : '' }}>Solid</option>
                            <option value="outline" {{ old('appearance.secondary_button_style', $settings['appearance.secondary_button_style'] ?? 'outline') === 'outline' ? 'selected' : '' }}>Outline</option>
                        </select>
                        <div class="grid grid-cols-2 gap-3" x-show="!useSecondary" x-transition>
                             <div>
                                <label class="block text-xs text-gray-500 mb-1">Background</label>
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-none">
                                        <input type="color" name="appearance[secondary_button_bg]" x-model="secondaryButtonBg" value="{{ old('appearance.secondary_button_bg', $settings['appearance.secondary_button_bg'] ?? '#035f7f') }}" class="h-8 w-8 rounded border-0 p-0 overflow-hidden cursor-pointer">
                                        <div class="absolute inset-0 rounded border border-black/10 pointer-events-none"></div>
                                    </div>
                                    <input type="text" x-model="secondaryButtonBg" class="w-full text-xs font-mono border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500 p-1 uppercase" maxlength="7">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Text</label>
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-none">
                                        <input type="color" name="appearance[secondary_button_text]" x-model="secondaryButtonText" value="{{ old('appearance.secondary_button_text', $settings['appearance.secondary_button_text'] ?? '#ffffff') }}" class="h-8 w-8 rounded border-0 p-0 overflow-hidden cursor-pointer">
                                        <div class="absolute inset-0 rounded border border-black/10 pointer-events-none"></div>
                                    </div>
                                    <input type="text" x-model="secondaryButtonText" class="w-full text-xs font-mono border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500 p-1 uppercase" maxlength="7">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 rounded-xl border border-gray-200 p-4 bg-gray-50/70">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900">CTA Button</h3>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="appearance[cta_button_use_theme]" value="1" x-model="useCtaButtonTheme" class="sr-only peer">
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                            <span class="ml-2 text-xs text-gray-500">Use theme</span>
                        </label>
                        <input type="hidden" name="appearance[cta_button_use_theme]" value="0" x-if="!useCtaButtonTheme">
                    </div>

                    <div class="grid md:grid-cols-2 gap-3">
                         <div x-show="useCtaButtonTheme" x-transition>
                             <label class="block text-xs text-gray-500 mb-1">Theme Source</label>
                            <select name="appearance[cta_button_theme_source]" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="primary" {{ old('appearance.cta_button_theme_source', $settings['appearance.cta_button_theme_source'] ?? 'primary') === 'primary' ? 'selected' : '' }}>Primary</option>
                                <option value="secondary" {{ old('appearance.cta_button_theme_source', $settings['appearance.cta_button_theme_source'] ?? 'primary') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                            </select>
                        </div>
                        <div x-show="!useCtaButtonTheme" x-transition x-data="{ ctaBg: '{{ old('appearance.cta_button_bg', $settings['appearance.cta_button_bg'] ?? '#ffffff') }}' }">
                             <label class="block text-xs text-gray-500 mb-1">Custom Background</label>
                             <div class="flex items-center gap-2">
                                <div class="relative flex-none">
                                    <input type="color" name="appearance[cta_button_bg]" x-model="ctaBg" class="h-8 w-8 rounded border-0 p-0 overflow-hidden cursor-pointer">
                                    <div class="absolute inset-0 rounded border border-black/10 pointer-events-none"></div>
                                </div>
                                <input type="text" x-model="ctaBg" class="w-full text-xs font-mono border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500 p-1 uppercase" maxlength="7">
                             </div>
                        </div>

                         <div>
                             <label class="block text-xs text-gray-500 mb-1">Style</label>
                            <select name="appearance[cta_button_style]" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="solid" {{ old('appearance.cta_button_style', $settings['appearance.cta_button_style'] ?? 'solid') === 'solid' ? 'selected' : '' }}>Solid</option>
                                <option value="outline" {{ old('appearance.cta_button_style', $settings['appearance.cta_button_style'] ?? 'solid') === 'outline' ? 'selected' : '' }}>Outline</option>
                            </select>
                         </div>
                    </div>
                    <div class="max-w-xs">
                        <label class="block text-xs text-gray-500 mb-1">Text</label>
                        <div class="flex items-center gap-2" x-data="{ ctaText: '{{ old('appearance.cta_button_text', $settings['appearance.cta_button_text'] ?? '#0481AE') }}' }">
                             <div class="relative flex-none">
                                <input type="color" name="appearance[cta_button_text]" x-model="ctaText" class="h-8 w-8 rounded border-0 p-0 overflow-hidden cursor-pointer">
                                <div class="absolute inset-0 rounded border border-black/10 pointer-events-none"></div>
                            </div>
                            <input type="text" x-model="ctaText" class="w-full text-xs font-mono border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500 p-1 uppercase" maxlength="7">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Header, Logo & Favicon</h2>
                    <p class="text-sm text-gray-500 mt-1">Brand assets and navigation behavior.</p>
                </div>

                <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium text-gray-700">Sticky Header</label>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="appearance[header_sticky]" value="0">
                        <input type="checkbox" name="appearance[header_sticky]" value="1" x-model="headerSticky" class="sr-only peer">
                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Logo Upload -->
                    <div x-data="{
                        preview: '{{ $currentLogo ? asset('storage/' . $currentLogo) : '' }}',
                        fileName: null,
                        handleFileChange(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.fileName = file.name;
                                const reader = new FileReader();
                                reader.onload = (e) => { this.preview = e.target.result; };
                                reader.readAsDataURL(file);
                            }
                        }
                    }">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                        <div class="relative group">
                            <label for="appearance_logo" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <template x-if="preview">
                                        <div class="relative">
                                            <img :src="preview" class="h-20 object-contain mb-2">
                                            <p class="text-xs text-gray-500" x-text="fileName ? 'New: ' + fileName : 'Current Logo'"></p>
                                        </div>
                                    </template>
                                    <template x-if="!preview">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 mb-3 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span></p>
                                            <p class="text-xs text-gray-500">SVG, PNG, JPG (MAX. 2MB)</p>
                                        </div>
                                    </template>
                                </div>
                                <input type="file" name="logo" id="appearance_logo" accept="image/*" class="hidden" @change="handleFileChange">
                            </label>
                        </div>
                    </div>

                    <!-- Favicon Upload -->
                    <div x-data="{
                        preview: '{{ $currentFavicon ? asset('storage/' . $currentFavicon) : '' }}',
                        fileName: null,
                        handleFileChange(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.fileName = file.name;
                                const reader = new FileReader();
                                reader.onload = (e) => { this.preview = e.target.result; };
                                reader.readAsDataURL(file);
                            }
                        }
                    }">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                        <div class="relative group">
                             <label for="appearance_favicon" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                     <template x-if="preview">
                                        <div class="relative">
                                            <img :src="preview" class="h-10 w-10 object-contain mb-2 mx-auto">
                                            <p class="text-xs text-center text-gray-500" x-text="fileName ? 'New: ' + fileName : 'Current'"></p>
                                        </div>
                                    </template>
                                    <template x-if="!preview">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 mb-3 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span></p>
                                            <p class="text-xs text-gray-500">ICO, PNG (32x32)</p>
                                        </div>
                                    </template>
                                </div>
                                <input type="file" name="favicon" id="appearance_favicon" accept="image/*" class="hidden" @change="handleFileChange">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">CTA Section Background</h2>
                    <p class="text-sm text-gray-500 mt-1">Set the background style for the homepage CTA section.</p>
                </div>
                <select name="appearance[cta_background_mode]" x-model="ctaBackgroundMode" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                    <option value="primary">Use primary color</option>
                    <option value="secondary">Use secondary color</option>
                    <option value="custom">Use custom color</option>
                </select>
                <div class="max-w-xs transition-opacity duration-200" :class="ctaBackgroundMode === 'custom' ? 'opacity-100' : 'opacity-50'">
                    <label class="block text-xs text-gray-500 mb-1">Custom color</label>
                    <div class="flex items-center gap-2">
                        <div class="relative flex-none">
                            <input type="color" name="appearance[cta_background_custom]" x-model="ctaCustomColor" value="{{ $currentCtaCustom }}" class="h-8 w-8 rounded border-0 p-0 overflow-hidden cursor-pointer disabled:cursor-not-allowed" :disabled="ctaBackgroundMode !== 'custom'">
                            <div class="absolute inset-0 rounded border border-black/10 pointer-events-none"></div>
                        </div>
                        <input type="text" x-model="ctaCustomColor" class="w-full text-xs font-mono border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500 p-1 uppercase disabled:bg-gray-100" maxlength="7" :disabled="ctaBackgroundMode !== 'custom'">
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-4 space-y-6">
            <div class="xl:sticky xl:top-24 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Live Preview</h3>
                    <div class="rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-4 py-3" :style="`background:${primaryColor}; color:#fff;`">
                            <p class="text-xs uppercase tracking-wide opacity-90">Header</p>
                            <p class="text-sm font-semibold">Brand Navigation <span class="text-[11px] font-normal opacity-90" x-text="headerSticky ? '(Sticky)' : '(Not sticky)'"></span></p>
                        </div>
                        <div class="p-4 space-y-3 bg-white">
                            <p class="text-sm font-medium text-gray-800">Buttons</p>
                            <div class="flex flex-wrap gap-2">
                                <button
                                    type="button"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold border"
                                    :style="`background:${primaryButtonStyle === 'outline' ? 'transparent' : (usePrimary ? primaryColor : primaryButtonBg)}; color:${primaryButtonStyle === 'outline' ? (usePrimary ? primaryColor : primaryButtonBg) : primaryButtonText}; border-color:${usePrimary ? primaryColor : primaryButtonBg};`"
                                >Primary</button>
                                <button
                                    type="button"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold border"
                                    :style="`background:${secondaryButtonStyle === 'outline' ? 'transparent' : (useSecondary ? secondaryColor : secondaryButtonBg)}; color:${secondaryButtonStyle === 'outline' ? (useSecondary ? secondaryColor : secondaryButtonBg) : secondaryButtonText}; border-color:${useSecondary ? secondaryColor : secondaryButtonBg};`"
                                >Secondary</button>
                            </div>
                        </div>
                        <div class="px-4 py-4" :style="`background:${ctaBackgroundMode === 'primary' ? primaryColor : (ctaBackgroundMode === 'secondary' ? secondaryColor : ctaCustomColor)}; color:#fff;`">
                            <p class="text-xs uppercase tracking-wide opacity-90">CTA Section</p>
                            <p class="text-sm font-semibold">Ready to get started?</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 text-xs text-gray-500">
                    Tip: Keep strong contrast between background and text colors for readability.
                </div>
            </div>
        </div>

        <div class="xl:col-span-12 flex items-center justify-end">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition">Save Appearance Settings</button>
        </div>
    </form>
</div>
@endsection
