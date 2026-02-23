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
                        <input type="color" name="appearance[primary_color]" x-model="primaryColor" value="{{ $currentPrimary }}" class="h-12 w-full rounded-lg border border-gray-300">
                    </div>
                    <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Color</label>
                        <input type="color" name="appearance[secondary_color]" x-model="secondaryColor" value="{{ $currentSecondary }}" class="h-12 w-full rounded-lg border border-gray-300">
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
                        <h3 class="text-sm font-semibold text-gray-900">Primary Button</h3>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="hidden" name="appearance[primary_button_use_theme]" value="0">
                            <input type="checkbox" name="appearance[primary_button_use_theme]" value="1" x-model="usePrimary">
                            Use primary color
                        </label>
                        <select name="appearance[primary_button_style]" x-model="primaryButtonStyle" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                            <option value="solid" {{ old('appearance.primary_button_style', $settings['appearance.primary_button_style'] ?? 'solid') === 'solid' ? 'selected' : '' }}>Solid</option>
                            <option value="outline" {{ old('appearance.primary_button_style', $settings['appearance.primary_button_style'] ?? 'solid') === 'outline' ? 'selected' : '' }}>Outline</option>
                        </select>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Background</label>
                                <input type="color" name="appearance[primary_button_bg]" x-model="primaryButtonBg" value="{{ old('appearance.primary_button_bg', $settings['appearance.primary_button_bg'] ?? '#0481AE') }}" class="h-10 w-full rounded-lg border border-gray-300 disabled:opacity-50" :disabled="usePrimary">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Text</label>
                                <input type="color" name="appearance[primary_button_text]" x-model="primaryButtonText" value="{{ old('appearance.primary_button_text', $settings['appearance.primary_button_text'] ?? '#ffffff') }}" class="h-10 w-full rounded-lg border border-gray-300">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 rounded-xl border border-gray-200 p-4 bg-gray-50/70">
                        <h3 class="text-sm font-semibold text-gray-900">Secondary Button</h3>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="hidden" name="appearance[secondary_button_use_theme]" value="0">
                            <input type="checkbox" name="appearance[secondary_button_use_theme]" value="1" x-model="useSecondary">
                            Use secondary color
                        </label>
                        <select name="appearance[secondary_button_style]" x-model="secondaryButtonStyle" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                            <option value="solid" {{ old('appearance.secondary_button_style', $settings['appearance.secondary_button_style'] ?? 'outline') === 'solid' ? 'selected' : '' }}>Solid</option>
                            <option value="outline" {{ old('appearance.secondary_button_style', $settings['appearance.secondary_button_style'] ?? 'outline') === 'outline' ? 'selected' : '' }}>Outline</option>
                        </select>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Background</label>
                                <input type="color" name="appearance[secondary_button_bg]" x-model="secondaryButtonBg" value="{{ old('appearance.secondary_button_bg', $settings['appearance.secondary_button_bg'] ?? '#035f7f') }}" class="h-10 w-full rounded-lg border border-gray-300 disabled:opacity-50" :disabled="useSecondary">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Text</label>
                                <input type="color" name="appearance[secondary_button_text]" x-model="secondaryButtonText" value="{{ old('appearance.secondary_button_text', $settings['appearance.secondary_button_text'] ?? '#ffffff') }}" class="h-10 w-full rounded-lg border border-gray-300">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 rounded-xl border border-gray-200 p-4 bg-gray-50/70">
                    <h3 class="text-sm font-semibold text-gray-900">CTA Button</h3>
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="hidden" name="appearance[cta_button_use_theme]" value="0">
                        <input type="checkbox" name="appearance[cta_button_use_theme]" value="1" x-model="useCtaButtonTheme">
                        Use theme color
                    </label>
                    <div class="grid md:grid-cols-3 gap-3">
                        <select name="appearance[cta_button_theme_source]" class="w-full px-4 py-2 border border-gray-300 rounded-xl" :disabled="!useCtaButtonTheme">
                            <option value="primary" {{ old('appearance.cta_button_theme_source', $settings['appearance.cta_button_theme_source'] ?? 'primary') === 'primary' ? 'selected' : '' }}>Primary</option>
                            <option value="secondary" {{ old('appearance.cta_button_theme_source', $settings['appearance.cta_button_theme_source'] ?? 'primary') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                        </select>
                        <select name="appearance[cta_button_style]" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                            <option value="solid" {{ old('appearance.cta_button_style', $settings['appearance.cta_button_style'] ?? 'solid') === 'solid' ? 'selected' : '' }}>Solid</option>
                            <option value="outline" {{ old('appearance.cta_button_style', $settings['appearance.cta_button_style'] ?? 'solid') === 'outline' ? 'selected' : '' }}>Outline</option>
                        </select>
                        <input type="color" name="appearance[cta_button_bg]" value="{{ old('appearance.cta_button_bg', $settings['appearance.cta_button_bg'] ?? '#ffffff') }}" class="h-10 w-full rounded-lg border border-gray-300 disabled:opacity-50" :disabled="useCtaButtonTheme">
                    </div>
                    <div class="max-w-xs">
                        <label class="block text-xs text-gray-500 mb-1">Text</label>
                        <input type="color" name="appearance[cta_button_text]" value="{{ old('appearance.cta_button_text', $settings['appearance.cta_button_text'] ?? '#0481AE') }}" class="h-10 w-full rounded-lg border border-gray-300">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Header, Logo & Favicon</h2>
                    <p class="text-sm text-gray-500 mt-1">Brand assets and navigation behavior.</p>
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="hidden" name="appearance[header_sticky]" value="0">
                    <input type="checkbox" name="appearance[header_sticky]" value="1" x-model="headerSticky" {{ old('appearance.header_sticky', $settings['appearance.header_sticky'] ?? '1') == '1' ? 'checked' : '' }}>
                    Keep header sticky on scroll
                </label>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="appearance_logo" class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                        @if($currentLogo)
                            <img src="{{ asset('storage/' . $currentLogo) }}" alt="Current Logo" class="h-14 object-contain mb-2 rounded bg-gray-50 border border-gray-200 p-1">
                        @endif
                        <input type="file" name="logo" id="appearance_logo" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                    </div>

                    <div>
                        <label for="appearance_favicon" class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                        @if($currentFavicon)
                            <img src="{{ asset('storage/' . $currentFavicon) }}" alt="Current Favicon" class="h-8 w-8 object-contain mb-2 rounded bg-gray-50 border border-gray-200 p-1">
                        @endif
                        <input type="file" name="favicon" id="appearance_favicon" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
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
                <div class="max-w-xs">
                    <label class="block text-xs text-gray-500 mb-1">Custom color</label>
                    <input type="color" name="appearance[cta_background_custom]" x-model="ctaCustomColor" value="{{ $currentCtaCustom }}" class="h-10 w-full rounded-lg border border-gray-300 disabled:opacity-50" :disabled="ctaBackgroundMode !== 'custom'">
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
