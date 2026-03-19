{{-- DA05 VIP: Photo Album --}}
@props(['wedding'])
@php
    $galleryImages = $wedding->gallery_images;
    $placeholders = [
        'https://images.unsplash.com/photo-1519741497674-611481863552?w=800',
        'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800',
        'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=800',
        'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800',
    ];
    $images = $galleryImages->isNotEmpty()
        ? $galleryImages->map(fn($m) => $m->getUrl('gallery_web') ?: $m->getUrl())
        : collect($placeholders);
    $heroImg = $images->first();
@endphp

<style>
    /* Pagination dots override */
    .gallerySlider .swiper-pagination {
        bottom: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }
    .gallerySlider .swiper-pagination-bullet {
        width: 6px;
        height: 6px;
        background: rgba(255,255,255,0.5);
        border-radius: 99px;
        opacity: 1;
        transition: all 0.3s ease;
        margin: 0 !important;
    }
    .gallerySlider .swiper-pagination-bullet-active {
        width: 22px;
        background: #A67C52 !important;
        border-radius: 99px;
    }
</style>

<section class="py-16 bg-cream relative overflow-hidden bg-main-watercolor" data-aos="fade-up">
    <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 right-0 -scale-x-100" alt="">
    <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 left-0 rotate-180 -scale-x-100" alt="">

@php
    $filmDir = public_path('images/film_gallery');
    $filmFiles = file_exists($filmDir)
        ? collect(glob($filmDir . '/*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE))
            ->map(fn($f) => asset('images/film_gallery/' . basename($f)))
        : collect();
@endphp

@if($filmFiles->isNotEmpty())
    {{-- Marquee Film Strip --}}
    <div class="overflow-hidden mb-8">
        <style>
            @keyframes marquee-left  { from { transform: translateX(0); } to { transform: translateX(-50%); } }
            @keyframes marquee-right { from { transform: translateX(-50%); } to { transform: translateX(0); } }
            .marquee-left  { display: flex; animation: marquee-left  25s linear infinite; }
            .marquee-right { display: flex; animation: marquee-right 25s linear infinite; }
            .marquee-frame { flex-shrink: 0; width: 120px; height: 120px; margin: 0 3px; overflow: hidden; }
        </style>
        {{-- Row 1: cuộn trái --}}
        <div class="marquee-left mb-2">
            @foreach($filmFiles->merge($filmFiles) as $filmUrl)
            <div class="marquee-frame">
                <img src="{{ $filmUrl }}" class="w-full h-full object-cover" alt="">
            </div>
            @endforeach
        </div>
        {{-- Row 2: cuộn phải --}}
        <div class="marquee-right">
            @foreach($filmFiles->reverse()->merge($filmFiles->reverse()) as $filmUrl)
            <div class="marquee-frame">
                <img src="{{ $filmUrl }}" class="w-full h-full object-cover" alt="">
            </div>
            @endforeach
        </div>
    </div>
@endif

    {{-- Title --}}
    <div class="text-center px-6 mb-8">
        <p class="font-script text-4xl text-gold">The Album</p>
        <p class="font-display text-xl text-gold tracking-[0.3em] uppercase mt-1">OF LOVE</p>
    </div>

    {{-- Polaroid Photos --}}
    <div class="relative h-[360px] mx-6">
        @if($images->count() >= 2)
        <div class="polaroid absolute top-0 right-4 w-[55%] transform rotate-3 z-10 hover:z-30 hover:scale-105 transition-all duration-500">
            <img src="{{ $images[0] }}" class="w-full aspect-[4/5] object-cover object-top">
        </div>
        <div class="polaroid absolute bottom-0 left-4 w-[55%] transform -rotate-6 z-20 hover:z-30 hover:scale-105 transition-all duration-500">
            <img src="{{ $images[1] }}" class="w-full aspect-[4/5] object-cover object-top">
        </div>
        @endif
    </div>

    {{-- Gallery Slider --}}
    <div class="px-6 mt-8">
        <div class="swiper gallerySlider rounded-2xl overflow-hidden aspect-[4/5] shadow-xl">
            <div class="swiper-wrapper">
                @foreach($images as $img)
                <div class="swiper-slide"><img src="{{ $img }}" class="w-full h-full object-cover object-top"></div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
