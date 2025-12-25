<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Thiệp Cưới Online')</title>
    
    {{-- SEO Meta --}}
    <meta name="description" content="@yield('description', 'Thiệp cưới online đẹp và hiện đại')">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Thiệp Cưới Online')">
    <meta property="og:description" content="@yield('description', 'Thiệp cưới online đẹp và hiện đại')">
    <meta property="og:image" content="@yield('og_image', asset('images/default-og.jpg'))">
    
    {{-- Prevent indexing edit pages --}}
    @if(request()->has('key'))
        <meta name="robots" content="noindex, nofollow">
    @endif
    
    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    {{-- TailwindCSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Cropper.js CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    
    {{-- Livewire Styles --}}
    @livewireStyles
    
    {{-- Custom Styles --}}
    <style>
        [x-cloak] { display: none !important; }
        .font-script { font-family: 'Great Vibes', cursive; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Montserrat', sans-serif; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                        script: ['Great Vibes', 'cursive'],
                    },
                    colors: {
                        rose: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899', // Giữ màu hồng nhưng dùng ít
                            900: '#831843',
                        },
                        stone: {
                            50: '#fafaf9',
                            900: '#1c1917',
                        }
                    }
                }
            }
        }
    </script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    @yield('content')
    
    {{-- Cropper.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    
    {{-- Livewire Scripts --}}
    @livewireScripts
    
    @stack('scripts')
</body>
</html>
