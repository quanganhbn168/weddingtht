<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <title>@yield('title', config('app.name', 'E-Wedding'))</title>
    <meta name="description" content="@yield('description', 'Thiệp cưới online')">

    {{-- OG Tags for Social Sharing --}}
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('description', 'Thiệp cưới online')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
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
