<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Welcome') - {{ settings('site.name', 'Victory Business Consulting') }}</title>
    <meta name="description" content="@yield('description', settings('site.description', 'Professional business consulting services'))">

    @php
        $resolvedFavicon = settings('appearance.favicon') ?: settings('branding.favicon');
    @endphp

    <!-- Favicon -->
    @if($resolvedFavicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $resolvedFavicon) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">

    @stack('styles')
</head>
@php
    $primaryColor = settings('appearance.primary_color', '#0481AE');
    $secondaryColor = settings('appearance.secondary_color', '#035f7f');
    $stickyHeaderRaw = settings('appearance.header_sticky', '1');
    $stickyHeader = in_array(strtolower((string) $stickyHeaderRaw), ['1', 'true', 'on', 'yes'], true);

    $primaryButtonUseTheme = filter_var(settings('appearance.primary_button_use_theme', true), FILTER_VALIDATE_BOOL);
    $secondaryButtonUseTheme = filter_var(settings('appearance.secondary_button_use_theme', true), FILTER_VALIDATE_BOOL);

    $primaryButtonStyle = settings('appearance.primary_button_style', 'solid');
    $secondaryButtonStyle = settings('appearance.secondary_button_style', 'outline');
    $ctaButtonStyle = settings('appearance.cta_button_style', 'solid');
    $ctaButtonUseTheme = filter_var(settings('appearance.cta_button_use_theme', true), FILTER_VALIDATE_BOOL);
    $ctaButtonThemeSource = settings('appearance.cta_button_theme_source', 'primary');

    $primaryButtonBg = $primaryButtonUseTheme ? $primaryColor : settings('appearance.primary_button_bg', '#0481AE');
    $primaryButtonText = settings('appearance.primary_button_text', '#ffffff');
    $secondaryButtonBg = $secondaryButtonUseTheme ? $secondaryColor : settings('appearance.secondary_button_bg', '#035f7f');
    $secondaryButtonText = settings('appearance.secondary_button_text', '#ffffff');

    $ctaButtonBg = $ctaButtonUseTheme
        ? ($ctaButtonThemeSource === 'secondary' ? $secondaryColor : $primaryColor)
        : settings('appearance.cta_button_bg', '#ffffff');
    $ctaButtonText = settings('appearance.cta_button_text', '#0481AE');

    $ctaBackgroundMode = settings('appearance.cta_background_mode', 'primary');
    $ctaBackground = match ($ctaBackgroundMode) {
        'secondary' => $secondaryColor,
        'custom' => settings('appearance.cta_background_custom', '#0481AE'),
        default => $primaryColor,
    };
@endphp
<body class="font-sans antialiased bg-white">
    <style>
        :root {
            --vc-primary: {{ $primaryColor }};
            --vc-secondary: {{ $secondaryColor }};
            --vc-cta-bg: {{ $ctaBackground }};
            --vc-btn-primary-bg: {{ $primaryButtonBg }};
            --vc-btn-primary-text: {{ $primaryButtonText }};
            --vc-btn-secondary-bg: {{ $secondaryButtonBg }};
            --vc-btn-secondary-text: {{ $secondaryButtonText }};
            --vc-btn-cta-bg: {{ $ctaButtonBg }};
            --vc-btn-cta-text: {{ $ctaButtonText }};
        }

        .vc-btn-primary {
            background: {{ $primaryButtonStyle === 'outline' ? 'transparent' : 'var(--vc-btn-primary-bg)' }};
            color: var(--vc-btn-primary-text);
            border: 2px solid var(--vc-btn-primary-bg);
        }

        .vc-btn-primary:hover {
            filter: brightness(0.95);
        }

        .vc-btn-secondary {
            background: {{ $secondaryButtonStyle === 'outline' ? 'transparent' : 'var(--vc-btn-secondary-bg)' }};
            color: var(--vc-btn-secondary-text);
            border: 2px solid var(--vc-btn-secondary-bg);
        }

        .vc-btn-secondary:hover {
            filter: brightness(0.95);
        }

        .vc-btn-cta {
            background: {{ $ctaButtonStyle === 'outline' ? 'transparent' : 'var(--vc-btn-cta-bg)' }};
            color: var(--vc-btn-cta-text);
            border: 2px solid var(--vc-btn-cta-bg);
        }

        .vc-btn-cta:hover {
            filter: brightness(0.95);
        }
    </style>

    <!-- Navigation -->
    @include('frontend.partials.navigation', [
        'stickyHeader' => $stickyHeader ?? true, 
        'forceSolid' => View::hasSection('force-solid')
    ])

    <!-- Main Content -->
    <main @if(View::hasSection('force-solid')) class="pt-20" @endif>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.partials.footer')

    <!-- WhatsApp Floating Button -->
    @include('frontend.partials.whatsapp-float')

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                allowInput: true,
                minDate: "today" // Usually good for booking forms
            });
            
            flatpickr(".datetimepicker", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                allowInput: true,
            });
        });
    </script>
</body>
</html>
