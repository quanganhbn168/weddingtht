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

<section class="py-16 bg-cream relative overflow-hidden bg-main-watercolor">
    <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 right-0 -scale-x-100" alt="">
    <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 left-0 rotate-180 -scale-x-100" alt="">

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

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const el = document.querySelector('.gallerySlider');
        if (!el) return;
        if (el.dataset.swiperInited === '1') return;
        el.dataset.swiperInited = '1';

        // eslint-disable-next-line no-undef
        new Swiper('.gallerySlider', {
            spaceBetween: 10,
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            pagination: { el: '.swiper-pagination', clickable: true },
            autoplay: { delay: 3000, disableOnInteraction: false },
        });
    });
    </script>
</section>
