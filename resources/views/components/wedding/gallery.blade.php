@php
    $t = $theme ?? config('wedding-themes.default');
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
    $layout = $layout ?? 'slider'; // slider | grid | masonry
@endphp

<section class="py-16 relative overflow-hidden" style="background: {{ $t['bg'] }}" data-aos="fade-up">
    {{ $decoration ?? '' }}

    {{-- Title --}}
    <div class="text-center px-6 mb-8">
        <p style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}" class="text-4xl">The Album</p>
        <p style="font-family: {{ $t['font_display'] }}; color: {{ $t['primary'] }}" class="text-xl tracking-[0.3em] uppercase mt-1">OF LOVE</p>
    </div>

    @if($layout === 'grid')
    {{-- Grid Layout --}}
    <div class="grid grid-cols-2 gap-2 px-4">
        @foreach($images as $index => $img)
        <a href="{{ $img }}" class="glightbox block {{ $index === 0 ? 'col-span-2' : '' }}">
            <img src="{{ $img }}" class="w-full {{ $index === 0 ? 'h-56' : 'h-36' }} object-cover rounded-lg shadow-md" alt="Wedding photo" loading="lazy">
        </a>
        @endforeach
    </div>

    @else
    {{-- Default: Swiper Slider --}}
    <div class="px-6">
        <div class="swiper wedding-gallery-slider overflow-hidden aspect-[4/5] shadow-xl" style="border-radius: {{ $t['radius'] }}">
            <div class="swiper-wrapper">
                @foreach($images as $img)
                <div class="swiper-slide">
                    <a href="{{ $img }}" class="glightbox block w-full h-full">
                        <img src="{{ $img }}" class="w-full h-full object-cover object-top" alt="Wedding photo" loading="lazy">
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next" style="color: {{ $t['primary'] }}"></div>
            <div class="swiper-button-prev" style="color: {{ $t['primary'] }}"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    @endif
</section>
