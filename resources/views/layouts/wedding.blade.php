<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    @php
        $pageTitle = html_entity_decode(trim($__env->yieldContent('title', config('app.name', 'E-Wedding'))), ENT_QUOTES, 'UTF-8');
        $pageDescription = html_entity_decode(trim($__env->yieldContent('description', 'Thiệp cưới online')), ENT_QUOTES, 'UTF-8');
        $pageOgImage = html_entity_decode(trim($__env->yieldContent('og_image', asset('images/og-default.jpg'))), ENT_QUOTES, 'UTF-8');

        if (! empty($guestName)) {
            $pageTitle = "Trân trọng kính mời {$guestName} | {$pageTitle}";
            $pageDescription = "Trân trọng kính mời {$guestName} đến chung vui cùng {$sideData->firstName} và {$sideData->secondName}.";
        }
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">

    {{-- OG Tags for Social Sharing --}}
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:image" content="{{ $pageOgImage }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Google Fonts: auto-loaded from theme config --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if(isset($theme['font_url']))
    <link href="{{ $theme['font_url'] }}" rel="stylesheet">
    @endif

    {{-- Shared application styles + wedding bundle: AOS, Swiper, GLightbox, FontAwesome --}}
    @vite(['resources/css/app.css', 'resources/css/wedding.css'])

    {{-- Shared animations & CSS variables --}}
    <link href="{{ asset('css/wedding-animations.css') }}" rel="stylesheet">

    {{-- Template-specific overrides --}}
    @stack('fonts')
    @stack('styles')

    {{-- Alpine.js x-cloak: hide elements until Alpine processes them --}}
    <style>[x-cloak] { display: none !important; }</style>

    {{-- Alpine.js: load BEFORE defer to ensure alpine:init works --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="font-sans antialiased bg-gray-100">

    @yield('content')

    {{-- Shared application JS + wedding bundle --}}
    @vite(['resources/js/app.js', 'resources/js/wedding.js'])

    @stack('scripts')
</body>
</html>
