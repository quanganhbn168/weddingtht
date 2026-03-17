@extends('layouts.app')
{{-- Template Name: DA05 VIP (MeHappy Clone) --}}
{{-- Type: wedding --}}

@php $side = $side ?? 'both'; @endphp
@section('title', ($side === 'bride' ? $wedding->bride_name . ' & ' . $wedding->groom_name : $wedding->groom_name . ' & ' . $wedding->bride_name))
@section('og_image', $shareUrl)

@section('content')
@php
    // Side-based logic: ?side=groom or ?side=bride
    $side = $side ?? 'both';
    $isGroom = $side === 'groom';
    $isBride = $side === 'bride';
    
    // Name order: bride side -> bride first, groom side -> groom first
    $firstName = $isBride ? $wedding->bride_name : $wedding->groom_name;
    $secondName = $isBride ? $wedding->groom_name : $wedding->bride_name;
    $firstPhoto = $isBride ? $bridePhoto : $groomPhoto;
    $secondPhoto = $isBride ? $groomPhoto : $bridePhoto;
@endphp

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Philosopher:ital,wght@0,400;0,700;1,400;1,700&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

    :root {
        --color-primary: #A67C52;
        --color-primary-dark: #8B6539;
        --color-rose: #C4967A;
        --color-rose-light: #E8C4B0;
        --color-bg-cream: #FDF8F4;
        --color-bg-white: #FFFFFF;
        --color-text-dark: #3D3329;
        --color-text-body: #6B6055;
        --font-display: 'Playfair Display', serif;
        --font-script: 'Great Vibes', cursive;
        --font-body: 'Quicksand', sans-serif;
        --font-vietnam: 'Be Vietnam Pro', sans-serif;
    }

    body { font-family: var(--font-body); background: var(--color-bg-cream); color: var(--color-text-body); }
    .font-display { font-family: var(--font-display); }
    .font-script { font-family: var(--font-script); }
    .font-vietnam { font-family: 'Philosopher', serif; }

    .bg-main-watercolor {
        background-image: url('{{ asset('images/back-ground-1.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    .watercolor-overlay { position: relative; }
    .watercolor-overlay::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background-image: url('{{ asset('images/back-ground-1.png') }}');
        background-size: cover; opacity: 0.08; pointer-events: none;
    }
    .text-gold { color: var(--color-primary); }
    .text-rose { color: var(--color-rose); }
    .bg-cream { background-color: var(--color-bg-cream); }

    .separator { display: flex; align-items: center; justify-content: center; gap: 12px; }
    .separator::before, .separator::after { content: ''; width: 60px; height: 1px; background: linear-gradient(to right, transparent, var(--color-primary), transparent); }

    .btn-gold { background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); color: #fff; box-shadow: 0 8px 20px -5px rgba(166,124,82,0.4); transition: all .3s; border: none; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 12px 28px -5px rgba(166,124,82,0.5); }

    .card-glass { background: rgba(255,255,255,0.92); backdrop-filter: blur(12px); border: 1px solid rgba(166,124,82,0.1); border-radius: 24px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }

    /* Film Strip */
    @keyframes filmScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    .film-strip { display: flex; animation: filmScroll 20s linear infinite; }
    .film-frame { flex-shrink: 0; width: 120px; height: 80px; margin: 0 4px; border: 3px solid var(--color-primary); border-radius: 4px; overflow: hidden; }
    .film-holes { background: repeating-linear-gradient(to right, transparent 0, transparent 14px, var(--color-primary) 14px, var(--color-primary) 18px, transparent 18px, transparent 32px); height: 14px; }

    /* Polaroid */
    .polaroid { background: #fff; padding: 8px 8px 32px; box-shadow: 0 8px 32px rgba(0,0,0,0.12); border: 2px solid var(--color-primary); }

    /* Floral corner deco */
    .floral-corner { position: absolute; width: 140px; opacity: 0.15; pointer-events: none; }

    @keyframes fadeInUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
    @keyframes float { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-8px); } }
    .animate-float { animation: float 4s ease-in-out infinite; }

    .swiper-button-next, .swiper-button-prev { color: var(--color-primary); background: rgba(255,255,255,.8); width: 36px; height: 36px; border-radius: 50%; }
    .swiper-button-next:after, .swiper-button-prev:after { font-size: 16px; font-weight: bold; }
    .swiper-pagination-bullet-active { background: var(--color-primary) !important; }

    @keyframes spin-slow { from { transform: rotate(0); } to { transform: rotate(360deg); } }
    .animate-spin-slow { animation: spin-slow 8s linear infinite; }
</style>

<div class="max-w-[480px] mx-auto bg-white min-h-screen shadow-2xl relative overflow-hidden">

    {{-- Pro Features --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'rings'])

    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" style="envelope" />
    @endif

    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    <x-wedding.music-player :wedding="$wedding" />


    {{-- ============================================ --}}
    {{-- SECTION 2: INVITATION INFO (Matching DA05 Reference) --}}
    {{-- ============================================ --}}
    <section class="py-12 px-6 bg-cream text-center relative watercolor-overlay bg-main-watercolor" data-aos="fade-up">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 left-0" alt="">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 right-0 rotate-180" alt="">

        {{-- Family Info Grid: Nhà Trai | Nhà Gái --}}
        <div class="grid grid-cols-2 gap-4 mb-10 max-w-sm mx-auto" data-aos="fade-up">
            {{-- Nhà Trai --}}
            <div class="text-center">
                <p class="font-display text-sm font-bold text-gold tracking-wider mb-2">Nhà Trai</p>
                <p class="text-xs text-gray-600 font-semibold">{{ $wedding->groom_father }}</p>
                <p class="text-xs text-gray-600 font-semibold mb-2">{{ $wedding->groom_mother }}</p>
                <p class="text-[10px] text-gray-400 italic leading-tight mb-3">{{ $wedding->groom_address }}</p>
                @if($wedding->groom_map_url)
                <a href="{{ $wedding->groom_map_url }}" target="_blank" class="inline-block border border-gold/40 rounded-full px-4 py-1.5 text-[10px] font-bold text-gold tracking-wider hover:bg-gold/10 transition uppercase">Xem chỉ đường</a>
                @endif
            </div>
            {{-- Nhà Gái --}}
            <div class="text-center">
                <p class="font-display text-sm font-bold text-gold tracking-wider mb-2">Nhà Gái</p>
                <p class="text-xs text-gray-600 font-semibold">{{ $wedding->bride_father }}</p>
                <p class="text-xs text-gray-600 font-semibold mb-2">{{ $wedding->bride_mother }}</p>
                <p class="text-[10px] text-gray-400 italic leading-tight mb-3">{{ $wedding->bride_address }}</p>
                @if($wedding->bride_map_url)
                <a href="{{ $wedding->bride_map_url }}" target="_blank" class="inline-block border border-gold/40 rounded-full px-4 py-1.5 text-[10px] font-bold text-gold tracking-wider hover:bg-gold/10 transition uppercase">Xem chỉ đường</a>
                @endif
            </div>
        </div>

        {{-- Separator --}}
        <div class="separator mb-8"></div>

        {{-- Formal Invitation Text --}}
        <p class="font-display text-base tracking-[0.15em] uppercase text-gray-600 font-bold mb-2" data-aos="fade-up">Trân Trọng Kính Mời</p>
        <p class="font-script text-xl text-gold mb-1" data-aos="fade-up" data-aos-delay="100">Bạn và người thương</p>
        <p class="text-xs tracking-[0.1em] text-gray-400 mb-8 font-medium">Đến dự buổi tiệc chung vui cùng gia đình chúng tôi</p>

        {{-- Couple Names --}}
        <div class="mb-8">
            <h2 class="font-script text-5xl text-gold mb-2" data-aos="fade-down">{{ $firstName }}</h2>
            <p class="font-display text-2xl text-rose italic">and</p>
            <h2 class="font-script text-5xl text-gold mt-2" data-aos="fade-up">{{ $secondName }}</h2>
        </div>

        {{-- Ceremony Time --}}
        <p class="text-xs italic text-gray-400 mb-4">Hôn lễ được tổ chức vào lúc</p>
        @php
            if ($isBride) {
                $mainTime = $wedding->bride_ceremony_time ?? $wedding->bride_reception_time;
                $mainDate = $wedding->bride_ceremony_date ?? $wedding->bride_reception_date ?? $wedding->event_date;
            } else {
                $mainTime = $wedding->groom_ceremony_time ?? $wedding->groom_reception_time;
                $mainDate = $wedding->groom_ceremony_date ?? $wedding->groom_reception_date ?? $wedding->event_date;
            }
        @endphp
        <div class="border-y border-gold/20 py-5 max-w-xs mx-auto mb-8">
            <p class="font-display text-3xl tracking-widest text-gold font-bold">
                {{ $mainTime ? \Carbon\Carbon::parse($mainTime)->format('H:i') : '' }}
                – {{ $mainDate ? mb_strtoupper(\Carbon\Carbon::parse($mainDate)->translatedFormat('l')) : '' }}
            </p>
            <p class="font-display text-4xl text-gold font-bold mt-2">{{ $mainDate?->format('d.m.Y') }}</p>
        </div>

        {{-- Venue Info --}}
        @php
            if ($isBride) {
                $mainVenue = $wedding->bride_reception_venue ?? $wedding->bride_address;
                $mainAddress = $wedding->bride_address;
                $mainMapUrl = $wedding->bride_map_url;
            } else {
                $mainVenue = $wedding->groom_reception_venue ?? $wedding->groom_address;
                $mainAddress = $wedding->groom_reception_address ?? $wedding->groom_address;
                $mainMapUrl = $wedding->groom_map_url;
            }
        @endphp
        @if($mainVenue)
        <div class="border-t border-gold/20 pt-6">
            <p class="text-xs italic text-gray-400 mb-3">Địa điểm:</p>
            <p class="font-display text-xl font-bold text-gray-700 leading-snug">{{ $mainVenue }}</p>
            <p class="text-sm italic text-gray-500 mt-2">{{ $mainAddress }}</p>
        </div>
        @endif

        {{-- Map Link --}}
        @if($mainMapUrl)
        <a href="{{ $mainMapUrl }}" target="_blank" class="inline-flex items-center gap-2 mt-8 text-gold hover:scale-105 transition group">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            <span class="font-display text-sm font-bold tracking-[0.15em] uppercase group-hover:underline">Chỉ Đường</span>
        </a>
        @endif
    </section>

    {{-- ============================================ --}}
    {{-- SECTION 2.5: MONOGRAM + COUNTDOWN + SAVE THE DATE --}}
    {{-- ============================================ --}}
    @if($wedding->event_date)
    <section class="py-16 px-6 bg-cream relative bg-main-watercolor text-center" data-aos="fade-up">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 right-0 -scale-x-100 opacity-30" alt="">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 left-0 rotate-180 -scale-x-100 opacity-30" alt="">

        {{-- Couple Monogram --}}
        <div class="mb-8" data-aos="zoom-in">
            <div class="relative inline-block">
                <span class="font-display text-8xl font-bold text-gold tracking-tight">{{ mb_substr($firstName, 0, 1) }}</span>
                <span class="font-display text-8xl font-bold text-gold tracking-tight">{{ mb_substr($secondName, 0, 1) }}</span>
            </div>
            <p class="font-script text-lg text-gold/80 -mt-2">{{ $firstName }} & {{ $secondName }}</p>
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 mt-1 font-bold">Happy Wedding</p>
        </div>

        {{-- Countdown Heading --}}
        <p class="font-display text-sm tracking-[0.2em] uppercase text-gray-500 mb-1 font-bold" data-aos="fade-up">We will come</p>
        <p class="font-display text-base tracking-[0.15em] uppercase text-gray-600 mb-8 font-bold" data-aos="fade-up">Husband and Wife in</p>

        {{-- Countdown Timer --}}
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d H:i:s') }}')" class="grid grid-cols-4 gap-4 max-w-sm mx-auto mb-12" data-aos="fade-up">
            @foreach([['days','Ngày'],['hours','Giờ'],['minutes','Phút'],['seconds','Giây']] as $c)
            <div class="text-center">
                <div class="font-display text-5xl font-bold text-gold" x-text="{{ $c[0] }}">00</div>
                <div class="text-xs text-gray-400 uppercase font-bold tracking-widest mt-1">{{ $c[1] }}</div>
            </div>
            @endforeach
        </div>

        {{-- Save The Date Image --}}
        <div class="w-full max-w-sm mx-auto" data-aos="fade-up">
            <img src="{{ asset('images/save-the-date.png') }}" class="w-full" alt="Save The Date">
        </div>
    </section>
    @endif

    {{-- ============================================ --}}
    {{-- SECTION: PHOTO HERO (We get married + Save the Date) --}}
    {{-- ============================================ --}}
    <section class="relative" data-aos="fade-up">
        {{-- Photo 1: We get married --}}
        <div class="relative w-full aspect-[3/4] overflow-hidden">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover" alt="We get married">
            <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/60"></div>
            <div class="absolute inset-0 flex flex-col justify-between items-center py-12 px-6 text-white text-center">
                <p class="font-script text-5xl drop-shadow-lg" data-aos="fade-down">We get married</p>
                <div>
                    <p style="font-family: 'Philosopher', serif;" class="text-2xl font-medium tracking-wide drop-shadow-lg">{{ $firstName }} <span class="text-gold">&</span> {{ $secondName }}</p>
                    <p style="font-family: 'Philosopher', serif;" class="text-xl font-light tracking-[0.2em] mt-2 drop-shadow-lg">{{ $wedding->event_date?->format('d.m.Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Photo 2: Save the Date (xe-giay.png) --}}
        <div class="relative w-full aspect-[3/4] overflow-hidden">
            <img src="{{ asset('images/xe-giay.png') }}" class="w-full h-full object-cover" alt="Save the Date">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="absolute inset-0 flex items-center justify-center text-white text-center">
                <div>
                    <p style="font-family: 'Philosopher', serif;" class="text-5xl font-bold tracking-[0.15em] uppercase drop-shadow-lg">SAVE</p>
                    <p class="font-script text-5xl drop-shadow-lg -mt-2">the <span style="font-family: 'Philosopher', serif;" class="font-bold tracking-[0.15em] uppercase text-5xl">DATE</span></p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- SECTION 3: THE STORY OF LOVE (Couple Info) --}}
    {{-- ============================================ --}}
    <section class="py-16 px-4 bg-cream relative overflow-hidden bg-main-watercolor" data-aos="fade-up">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 left-0 opacity-30" alt="">

        {{-- Heading: THE STORY of LOVE --}}
        <h2 class="text-center mb-10" data-aos="fade-down">
            <span class="font-display text-2xl tracking-[0.3em] uppercase text-gray-700">The Story</span>
            <span class="font-script text-4xl text-gold mx-2">of</span>
            <span class="font-display text-2xl tracking-[0.3em] uppercase text-gray-700">Love</span>
        </h2>

        {{-- Stacked overlapping photos --}}
        <div class="relative mx-auto" style="max-width: 340px; height: 480px;">
            {{-- Groom photo: top-left, tilted --}}
            <div class="absolute" style="top: 0; left: 0; z-index: 2;" data-aos="fade-right">
                <div style="width: 200px; height: 250px; padding: 8px; background: white; border: 3px solid #A67C52; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: rotate(-5deg);">
                    <img src="{{ $groomPhoto }}" style="width: 100%; height: 100%; object-fit: cover; object-position: top;" alt="{{ $wedding->groom_name }}">
                </div>
            </div>
            {{-- Groom text --}}
            <div class="absolute" style="top: 60px; right: 0; text-align: right; z-index: 3;" data-aos="fade-left">
                <p class="font-script text-3xl text-gold mb-1">Chú rể</p>
                <h3 style="font-family: 'Philosopher', serif;" class="text-2xl font-bold text-gray-700">{{ $wedding->groom_name }}</h3>
            </div>

            {{-- Bride photo: bottom-right, overlapping groom --}}
            <div class="absolute" style="bottom: 20px; right: 0; z-index: 4;" data-aos="fade-left">
                <div style="width: 200px; height: 250px; padding: 8px; background: white; border: 3px solid #A67C52; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: rotate(5deg);">
                    <img src="{{ $bridePhoto }}" style="width: 100%; height: 100%; object-fit: cover; object-position: top;" alt="{{ $wedding->bride_name }}">
                </div>
            </div>
            {{-- Bride text --}}
            <div class="absolute" style="bottom: 80px; left: 0; text-align: left; z-index: 5;" data-aos="fade-right">
                <p class="font-script text-3xl text-gold mb-1">Cô dâu</p>
                <h3 style="font-family: 'Philosopher', serif;" class="text-2xl font-bold text-gray-700">{{ $wedding->bride_name }}</h3>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- SECTION 4: LOVE STORY TIMELINE --}}
    {{-- ============================================ --}}
    @php
        $loveStoryRaw = $wedding->content['love_story'] ?? [];
        $loveStory = is_array($loveStoryRaw) ? $loveStoryRaw : [];
    @endphp
    @if(count($loveStory) > 0)
    <section class="py-16 px-6 bg-cream relative bg-main-watercolor" data-aos="fade-up">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 left-0 opacity-30" alt="">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 right-0 rotate-180 opacity-30" alt="">

        <div class="relative max-w-sm mx-auto pl-10">
            {{-- Vertical line --}}
            <div class="absolute left-3 top-0 bottom-0 w-px bg-gold/30"></div>

            @foreach($loveStory as $item)
            <div class="relative mb-12" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                {{-- Dot --}}
                <div class="absolute" style="left: -34px; top: 8px; width: 14px; height: 14px; background: #A67C52; border-radius: 50%; border: 3px solid #FDF8F4; box-shadow: 0 0 0 2px #A67C52;"></div>
                {{-- Year + Title --}}
                <h3 class="font-script text-3xl text-gold mb-3" style="font-style: italic;">{{ $item['year'] ?? '' }} - {{ $item['title'] ?? '' }}</h3>
                {{-- Description --}}
                <p class="text-sm text-gray-600 leading-relaxed italic">{{ $item['description'] ?? '' }}</p>
            </div>
            @endforeach
        </div>
    </section>
    @endif


    {{-- ============================================ --}}
    {{-- SECTION 5: PHOTO ALBUM --}}
    {{-- ============================================ --}}
    <section class="py-16 bg-cream relative overflow-hidden bg-main-watercolor" data-aos="fade-up">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 right-0 -scale-x-100" alt="">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 left-0 rotate-180 -scale-x-100" alt="">
        @php
            $galleryImages = $wedding->gallery_images;
            $placeholders = [
                'https://images.unsplash.com/photo-1519741497674-611481863552?w=800',
                'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800',
                'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=800',
                'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800',
            ];
            $images = $galleryImages->isNotEmpty() ? $galleryImages->map->getUrl() : collect($placeholders);
        @endphp

        {{-- Film Strip --}}
        <div class="overflow-hidden mb-6">
            <div class="film-holes"></div>
            <div class="film-strip">
                @foreach($images->merge($images) as $img)
                <div class="film-frame"><img src="{{ $img }}" class="w-full h-full object-cover"></div>
                @endforeach
            </div>
            <div class="film-holes"></div>
        </div>

        {{-- Save The Date Image --}}
        <div class="relative px-6 mb-8" data-aos="fade-up">
            <div class="relative group max-w-xs mx-auto">
                <img src="{{ asset('images/save-the-date.png') }}" class="w-full h-auto rounded-[40px] border-8 border-white shadow-2xl relative z-10 hover:scale-[1.02] transition duration-500" style="max-height: 70vh; object-fit: contain;" alt="Save the Date">
            </div>
        </div>

        {{-- Title --}}
        <div class="text-center px-6 mb-8">
            <p class="font-script text-4xl text-gold">The Album</p>
            <p class="font-display text-xl text-gold tracking-[0.3em] uppercase mt-1">OF LOVE</p>
        </div>

        {{-- Polaroid Photos --}}
        <div class="relative h-[360px] mx-6">
            @if($images->count() >= 2)
            <div class="polaroid absolute top-0 right-4 w-[55%] transform rotate-3 z-10 hover:z-30 hover:scale-105 transition-all duration-500">
                <img src="{{ $images[0] }}" class="w-full aspect-[4/5] object-cover">
            </div>
            <div class="polaroid absolute bottom-0 left-4 w-[55%] transform -rotate-6 z-20 hover:z-30 hover:scale-105 transition-all duration-500">
                <img src="{{ $images[1] }}" class="w-full aspect-[4/5] object-cover">
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



    {{-- ============================================ --}}
    {{-- SECTION 7: SỰ KIỆN CƯỚI --}}
    {{-- ============================================ --}}
    <section class="py-16 px-6 bg-cream relative bg-main-watercolor" data-aos="fade-up">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 left-0" alt="">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 right-0 rotate-180" alt="">
        <h2 class="font-script text-5xl text-gold text-center mb-12">Sự Kiện Cưới</h2>
        <div class="space-y-6 max-w-sm mx-auto">
            {{-- Tiệc nhà trai --}}
            @if($wedding->groom_reception_time && $side !== 'bride')
            <div class="card-glass p-6" data-aos="fade-right">
                <div class="text-center mb-4">
                    <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-gold/40 shadow-md">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover object-top">
                    </div>
                    <h3 class="font-display text-xl text-gold font-bold">Tiệc Mừng Nhà Trai</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <div><p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p><p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }} - {{ ($wedding->groom_reception_date ?? $wedding->event_date)?->format('d/m/Y') }}</p></div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                        <div><p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p><p class="font-bold text-gray-700">{{ $wedding->groom_reception_venue }}</p><p class="text-xs italic text-gray-500">{{ $wedding->groom_reception_address }}</p></div>
                    </div>
                </div>
                @if($wedding->groom_map_url)
                <a href="{{ $wedding->groom_map_url }}" target="_blank" class="block w-full mt-4 py-3 btn-gold rounded-xl text-center text-sm font-bold uppercase tracking-wider">Xem Bản Đồ</a>
                @endif
            </div>
            @endif

            {{-- Tiệc nhà gái --}}
            @if($wedding->bride_reception_time && $side !== 'groom')
            <div class="card-glass p-6" data-aos="fade-left">
                <div class="text-center mb-4">
                    <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-rose/40 shadow-md">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover object-top">
                    </div>
                    <h3 class="font-display text-xl text-rose font-bold">Tiệc Cưới Nhà Gái</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-rose/10 rounded-full flex items-center justify-center text-rose shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <div><p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p><p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }} - {{ ($wedding->bride_reception_date ?? $wedding->event_date)?->format('d/m/Y') }}</p></div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-rose/10 rounded-full flex items-center justify-center text-rose shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                        <div><p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p><p class="font-bold text-gray-700">{{ $wedding->bride_reception_venue }}</p><p class="text-xs italic text-gray-500">{{ $wedding->bride_address }}</p></div>
                    </div>
                </div>
                @if($wedding->bride_map_url)
                <a href="{{ $wedding->bride_map_url }}" target="_blank" class="block w-full mt-4 py-3 btn-gold rounded-xl text-center text-sm font-bold uppercase tracking-wider">Xem Bản Đồ</a>
                @endif
            </div>
            @endif

            {{-- Lễ Vu Quy --}}
            @if($wedding->bride_ceremony_date && $side !== 'groom')
            <div class="card-glass p-6" data-aos="fade-left">
                <div class="text-center mb-4">
                    <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-rose/40 shadow-md">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover object-top rounded-full">
                    </div>
                    <h3 class="font-display text-xl text-rose font-bold">Lễ Vu Quy</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-rose/10 rounded-full flex items-center justify-center text-rose shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <div><p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p><p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($wedding->bride_ceremony_date)->format('d/m/Y') }}</p></div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-rose/10 rounded-full flex items-center justify-center text-rose shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                        <div><p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p><p class="font-bold text-gray-700">{{ $wedding->bride_address }}</p></div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Lễ Thành Hôn --}}
            @if($wedding->groom_ceremony_date && $side !== 'bride')
            <div class="card-glass p-6" data-aos="fade-right">
                <div class="text-center mb-4">
                    <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-gold/40 shadow-md">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover object-top rounded-full">
                    </div>
                    <h3 class="font-display text-xl text-gold font-bold">Lễ Thành Hôn</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <div><p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p><p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($wedding->groom_ceremony_date)->format('d/m/Y') }}</p></div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                        <div><p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p><p class="font-bold text-gray-700">{{ $wedding->groom_address }}</p></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- SECTION 8: QR MỪNG CƯỚI --}}
    {{-- ============================================ --}}
    <section class="py-16 px-6 bg-white relative watercolor-overlay" data-aos="fade-up" x-data="{ activeQr: null }">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 right-0 -scale-x-100" alt="">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 left-0 rotate-180 -scale-x-100" alt="">
        <h2 class="font-script text-5xl text-gold text-center mb-4">Mừng Cưới</h2>
        <p class="text-center text-sm text-gray-500 italic mb-10 max-w-xs mx-auto">
            {{ $wedding->getContentValue('blessing_desc', "Sự hiện diện và lời chúc phúc của bạn là niềm hạnh phúc lớn nhất của chúng tôi.") }}
        </p>

        <div class="grid grid-cols-2 gap-6">
            <div class="text-center" data-aos="fade-right">
                <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-gold/30 shadow-md">
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover object-top">
                </div>
                <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Chú Rể</p>
                <h3 class="font-display text-lg text-gold font-bold mb-3">{{ $wedding->groom_name }}</h3>
                <button @click="activeQr = 'groom'" class="btn-gold px-6 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest">Mừng Cưới</button>
            </div>
            <div class="text-center" data-aos="fade-left">
                <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-rose/30 shadow-md">
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover object-top">
                </div>
                <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Cô Dâu</p>
                <h3 class="font-display text-lg text-rose font-bold mb-3">{{ $wedding->bride_name }}</h3>
                <button @click="activeQr = 'bride'" class="btn-gold px-6 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest">Mừng Cưới</button>
            </div>
        </div>

        {{-- QR Modal --}}
        <div x-show="activeQr" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="activeQr = null" class="fixed inset-0 z-[100] bg-black/80 backdrop-blur-md flex items-center justify-center p-6" style="display: none;">
            <div @click.stop class="bg-white rounded-3xl p-8 max-w-xs w-full text-center relative" x-show="activeQr" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="scale-90 translate-y-8" x-transition:enter-end="scale-100 translate-y-0">
                <button @click="activeQr = null" class="absolute top-4 right-4 text-gray-400 hover:text-gold transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>

                <div x-show="activeQr === 'groom'">
                    <p class="font-display text-xl text-gold font-bold mb-1">Mừng Cưới Chú Rể</p>
                    <p class="text-sm text-gray-500 mb-4">{{ $wedding->groom_name }}</p>
                    <div class="bg-gray-50 p-4 rounded-2xl inline-block mb-4"><img src="{{ $wedding->getGroomQrUrl() }}" class="w-48 h-48 object-contain"></div>
                    @if($wedding->groom_qr_info)<p class="text-xs text-gray-500 whitespace-pre-line">{{ $wedding->groom_qr_info }}</p>@endif
                </div>
                <div x-show="activeQr === 'bride'">
                    <p class="font-display text-xl text-rose font-bold mb-1">Mừng Cưới Cô Dâu</p>
                    <p class="text-sm text-gray-500 mb-4">{{ $wedding->bride_name }}</p>
                    <div class="bg-gray-50 p-4 rounded-2xl inline-block mb-4"><img src="{{ $wedding->getBrideQrUrl() }}" class="w-48 h-48 object-contain"></div>
                    @if($wedding->bride_qr_info)<p class="text-xs text-gray-500 whitespace-pre-line">{{ $wedding->bride_qr_info }}</p>@endif
                </div>
            </div>
        </div>
    </section>



    {{-- ============================================ --}}
    {{-- SECTION 10: SỔ LƯU BÚT --}}
    {{-- ============================================ --}}
    <section id="guestbook" class="py-16 px-6 bg-white relative" data-aos="fade-up">
        <div class="card-glass p-6 text-center">
            <h2 class="font-script text-4xl text-gold mb-2">{{ $wedding->getContentValue('guestbook_title', 'Sổ Lưu Bút') }}</h2>
            <div class="w-12 h-px bg-gold mx-auto mb-4"></div>
            <p class="text-sm text-gray-500 italic mb-6">{{ $wedding->getContentValue('guestbook_desc', 'Hãy để lại những lời chúc phúc tốt đẹp nhất cho chúng tôi nhé!') }}</p>

            @php $wishes = $wedding->approvedWishes()->latest()->take(10)->get(); @endphp
            @if($wishes->count() > 0)
            <div class="mb-8 px-4">
                <div class="swiper guestbookSlider pb-8">
                    <div class="swiper-wrapper">
                        @foreach($wishes as $wish)
                        <div class="swiper-slide text-center px-2">
                            <div class="text-4xl font-script text-gold/20 mb-2">"</div>
                            <p class="text-lg text-gray-700 italic font-display leading-relaxed mb-4">{{ $wish->message }}</p>
                            <p class="font-bold text-gold text-sm uppercase tracking-widest">{{ $wish->name }}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            @else
            <p class="text-gray-400 italic mb-6">Chưa có lời chúc nào. Hãy là người đầu tiên!</p>
            @endif

            <div x-data="{ open: false, submitting: false, success: false, error: null, formData: { name: '', message: '' }, async submitWish() { this.submitting = true; this.error = null; try { const r = await fetch('{{ route('wedding.wish.store', $wedding->slug) }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }, body: JSON.stringify(this.formData) }); if (r.ok) { this.success = true; this.formData = { name: '', message: '' }; setTimeout(() => { this.success = false; this.open = false; }, 3000); } else { const d = await r.json(); this.error = d.message || 'Có lỗi xảy ra.'; } } catch(e) { this.error = 'Lỗi kết nối.'; } finally { this.submitting = false; } } }">
                <button @click="open = true" class="btn-gold px-8 py-3 rounded-full text-sm font-bold uppercase tracking-widest">Gửi Lời Chúc</button>
                <div x-show="open" style="display:none" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-md" x-transition.opacity>
                    <div class="bg-white rounded-3xl p-6 max-w-md w-full relative shadow-2xl" @click.outside="open = false">
                        <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gold"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        <h3 class="font-display text-2xl text-gold text-center mb-4 font-bold">Viết Lời Chúc</h3>
                        <div x-show="success" class="text-center py-6"><div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div><p class="font-bold text-gray-800">Đã Gửi Thành Công!</p></div>
                        <form @submit.prevent="submitWish" x-show="!success" class="space-y-4 text-left">
                            <div x-show="error" class="p-3 bg-red-50 text-red-600 text-sm rounded-lg text-center" x-text="error"></div>
                            <div><label class="block text-xs font-bold uppercase text-gray-400 mb-1">Tên</label><input type="text" x-model="formData.name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-1 focus:ring-gold outline-none bg-gray-50/50"></div>
                            <div><label class="block text-xs font-bold uppercase text-gray-400 mb-1">Lời chúc</label><textarea x-model="formData.message" required rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-1 focus:ring-gold outline-none bg-gray-50/50 resize-none"></textarea></div>
                            <button type="submit" class="w-full py-3 btn-gold rounded-xl font-bold uppercase text-sm" :disabled="submitting"><span x-show="!submitting">Gửi Ngay</span><span x-show="submitting">Đang Gửi...</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- SECTION 11: RSVP --}}
    {{-- ============================================ --}}
    <section id="rsvp" class="py-16 px-6 bg-cream relative bg-main-watercolor" data-aos="fade-up">
        <div class="card-glass p-6 text-center relative overflow-hidden">
            <h2 class="font-script text-4xl text-gold mb-2">Xác Nhận Tham Dự</h2>
            <div class="w-12 h-px bg-gold mx-auto mb-4"></div>
            <p class="text-sm text-gray-500 italic mb-8">{{ $wedding->getContentValue('rsvp_desc', 'Sự hiện diện của bạn là niềm vinh hạnh của chúng tôi.') }}</p>

            <div x-data="{ submitting: false, success: false, error: null, formData: { name: '{{ $wedding->getGuestName() ? urldecode($wedding->getGuestName()) : '' }}', phone: '', attendance: 'yes', guests: '1', side: 'both', note: '' }, async submitRsvp() { this.submitting = true; this.error = null; try { const r = await fetch('{{ route('wedding.rsvp.store', $wedding->slug) }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }, body: JSON.stringify(this.formData) }); if (r.ok) { this.success = true; } else { const d = await r.json(); this.error = d.message || 'Có lỗi.'; } } catch(e) { this.error = 'Lỗi kết nối.'; } finally { this.submitting = false; } } }">
                <div x-show="success" class="py-6" style="display:none"><div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div><p class="font-bold text-gray-800">Xác nhận thành công!</p></div>
                <form @submit.prevent="submitRsvp" x-show="!success" class="space-y-4 text-left max-w-sm mx-auto">
                    <div x-show="error" class="p-3 bg-red-50 text-red-600 text-sm rounded-lg text-center" x-text="error" style="display:none"></div>
                    <div><label class="block text-xs font-bold uppercase text-gray-400 mb-1">Họ và tên *</label><input type="text" x-model="formData.name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-1 focus:ring-gold outline-none bg-white/50"></div>
                    <div><label class="block text-xs font-bold uppercase text-gray-400 mb-1">Số điện thoại</label><input type="tel" x-model="formData.phone" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-1 focus:ring-gold outline-none bg-white/50"></div>
                    <div class="text-center py-2">
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-3">Bạn sẽ tham dự chứ?</label>
                        <div class="flex justify-center gap-2">
                            <label class="cursor-pointer"><input type="radio" x-model="formData.attendance" value="yes" class="sr-only"><div class="px-5 py-2 border rounded-full text-xs font-bold transition-all" :style="formData.attendance === 'yes' ? 'background: var(--color-primary); color: white; border-color: var(--color-primary);' : ''">Sẽ Tham Dự</div></label>
                            <label class="cursor-pointer"><input type="radio" x-model="formData.attendance" value="maybe" class="sr-only"><div class="px-5 py-2 border rounded-full text-xs font-bold transition-all" :style="formData.attendance === 'maybe' ? 'background: #EAB308; color: white; border-color: #EAB308;' : ''">Chưa Chắc</div></label>
                            <label class="cursor-pointer"><input type="radio" x-model="formData.attendance" value="no" class="sr-only"><div class="px-5 py-2 border rounded-full text-xs font-bold transition-all" :style="formData.attendance === 'no' ? 'background: #57534E; color: white; border-color: #57534E;' : ''">Rất Tiếc</div></label>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="block text-xs font-bold uppercase text-gray-400 mb-1">Số Khách</label><select x-model="formData.guests" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold outline-none bg-white/50"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5+</option></select></div>
                        <div><label class="block text-xs font-bold uppercase text-gray-400 mb-1">Khách Của</label><select x-model="formData.side" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold outline-none bg-white/50"><option value="both">Bạn Chung</option><option value="groom">Nhà Trai</option><option value="bride">Nhà Gái</option></select></div>
                    </div>
                    <button type="submit" class="w-full py-3 btn-gold rounded-xl font-bold uppercase text-sm tracking-widest" :disabled="submitting"><span x-show="!submitting">Gửi Xác Nhận</span><span x-show="submitting">Đang Gửi...</span></button>
                </form>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================ --}}
    <footer class="py-20 bg-cream text-center relative bg-main-watercolor" data-aos="fade-up">
        <p class="font-script text-6xl text-gold mb-6">Thank You!</p>
        <div class="font-display text-2xl text-gold/80 mb-2 italic">{{ $firstName }} & {{ $secondName }}</div>
        <p class="text-gold/60 font-bold tracking-[0.3em] text-sm mb-10">{{ $wedding->event_date?->format('d.m.Y') }}</p>
        <div class="separator mb-10">
            <svg class="w-6 h-6 text-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        </div>
        <p class="text-[10px] text-gray-400 uppercase tracking-widest">Designed with ❤️ by THT Media</p>
    </footer>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.gallerySlider')) {
        new Swiper('.gallerySlider', { spaceBetween: 10, navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }, pagination: { el: '.swiper-pagination', clickable: true }, autoplay: { delay: 3000, disableOnInteraction: false } });
    }
    if (document.querySelector('.guestbookSlider')) {
        new Swiper('.guestbookSlider', { spaceBetween: 20, autoplay: { delay: 4000 }, pagination: { el: '.swiper-pagination', clickable: true } });
    }
});
</script>

@push('scripts')
    <x-wedding.countdown-script />
@endpush
@endsection
