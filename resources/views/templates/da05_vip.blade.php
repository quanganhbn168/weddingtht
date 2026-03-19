@extends('layouts.app')
{{-- Template Name: DA05 VIP (MeHappy Clone) --}}
{{-- Type: wedding --}}

@php $side = $side ?? 'both'; @endphp
@section('title', ($side === 'bride' ? $wedding->bride_name . ' & ' . $wedding->groom_name : $wedding->groom_name . ' & ' . $wedding->bride_name))
@section('og_image', $shareUrl)

@section('content')
@php
    $isBride = $side === 'bride';
    $firstName = $isBride ? $wedding->bride_name : $wedding->groom_name;
    $secondName = $isBride ? $wedding->groom_name : $wedding->bride_name;
    $firstPhoto = $isBride ? $bridePhoto : $groomPhoto;
    $secondPhoto = $isBride ? $groomPhoto : $bridePhoto;
@endphp

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Philosopher:ital,wght@0,400;0,700;1,400;1,700&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">

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
        --font-body: 'Be Vietnam Pro', sans-serif;
        --font-vietnam: 'Be Vietnam Pro', sans-serif;
    }

    body { font-family: var(--font-body); background: var(--color-bg-cream); color: var(--color-text-body); }
    .font-display { font-family: var(--font-display); }
    .font-script { font-family: var(--font-script); }
    .font-vietnam { font-family: 'Philosopher', serif; }

    .bg-main-watercolor {
        background-image: url('{{ asset('images/back-ground-1.png') }}');
        background-size: cover; background-position: center; background-attachment: fixed;
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

    @keyframes filmScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    .film-strip { display: flex; animation: filmScroll 20s linear infinite; }
    .film-frame { flex-shrink: 0; width: 120px; height: 80px; margin: 0 4px; border: 3px solid var(--color-primary); border-radius: 4px; overflow: hidden; }
    .film-holes { background: repeating-linear-gradient(to right, transparent 0, transparent 14px, var(--color-primary) 14px, var(--color-primary) 18px, transparent 18px, transparent 32px); height: 14px; }
    .polaroid { background: #fff; padding: 8px 8px 32px; box-shadow: 0 8px 32px rgba(0,0,0,0.12); border: 2px solid var(--color-primary); }
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

    {{-- ═══ INVITATION + FAMILY INFO (da05-specific layout) ═══ --}}
    <x-wedding.da05-invitation :wedding="$wedding" :side="$side" />

    {{-- ═══ COUNTDOWN (SHARED component) ═══ --}}
    <section class="py-16 px-6 bg-cream relative bg-main-watercolor" data-aos="fade-up">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 right-0 -scale-x-100 opacity-30" alt="">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 left-0 rotate-180 -scale-x-100 opacity-30" alt="">
        <x-wedding.countdown-timer :wedding="$wedding" :side="$side" />
        <div class="w-full max-w-sm mx-auto" data-aos="fade-up">
            <img src="{{ asset('images/save-the-date.png') }}" class="w-full" alt="Save The Date">
        </div>
    </section>

    {{-- ═══ HERO PHOTOS (da05-specific layout) ═══ --}}
    <x-wedding.da05-hero :wedding="$wedding" :heroUrl="$heroUrl" :side="$side" />

    {{-- ═══ COUPLE STORY (da05-specific polaroid layout) ═══ --}}
    <x-wedding.da05-couple :wedding="$wedding" :groomPhoto="$groomPhoto" :bridePhoto="$bridePhoto" />

    {{-- ═══ LOVE STORY (da05-specific timeline) ═══ --}}
    @if($wedding->show_love_story !== false)
    <x-wedding.da05-love-story :wedding="$wedding" />
    @endif

    {{-- ═══ PHOTO ALBUM (da05-specific film strip + polaroid) ═══ --}}
    <x-wedding.da05-album :wedding="$wedding" />

    {{-- ═══ EVENTS (SHARED component) ═══ --}}
    <section class="py-16 px-6 bg-cream relative bg-main-watercolor" data-aos="fade-up">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 left-0" alt="">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 right-0 rotate-180" alt="">
        <x-wedding.event-cards :wedding="$wedding" :side="$side" :groomPhoto="$groomPhoto" :bridePhoto="$bridePhoto" />
    </section>

    {{-- ═══ QR PAYMENT (SHARED component) ═══ --}}
    <section class="py-16 px-6 bg-white relative watercolor-overlay" data-aos="fade-up">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 right-0 -scale-x-100" alt="">
        <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 left-0 rotate-180 -scale-x-100" alt="">
        <x-wedding.qr-payment :wedding="$wedding" :groomPhoto="$groomPhoto" :bridePhoto="$bridePhoto" />
    </section>

    {{-- ═══ GUESTBOOK (SHARED component) ═══ --}}
    <section id="guestbook" class="py-16 px-6 bg-white relative" data-aos="fade-up">
        <x-wedding.guestbook :wedding="$wedding" />
    </section>

    {{-- ═══ RSVP (SHARED component) ═══ --}}
    <section id="rsvp" class="py-16 px-6 bg-cream relative bg-main-watercolor" data-aos="fade-up">
        <x-wedding.rsvp-form :wedding="$wedding" />
    </section>

    {{-- ═══ FOOTER (da05 with gallery background) ═══ --}}
    @php
        $footerImages = $wedding->gallery_images;
        $footerBg = $footerImages->isNotEmpty()
            ? ($footerImages->last()->getUrl('gallery_web') ?: $footerImages->last()->getUrl())
            : null;
    @endphp
    <footer class="relative py-20 text-center overflow-hidden" data-aos="fade-up">
        {{-- Background ảnh gallery --}}
        @if($footerBg)
        <img src="{{ $footerBg }}" class="absolute inset-0 w-full h-full object-cover object-top" alt="">
        <div class="absolute inset-0 bg-black/55"></div>
        @else
        <div class="absolute inset-0 bg-main-watercolor bg-cream"></div>
        @endif

        {{-- Content --}}
        <div class="relative z-10 {{ $footerBg ? 'text-white' : '' }}">
            <p class="font-script text-6xl {{ $footerBg ? 'text-white' : 'text-gold' }} mb-6 drop-shadow-lg">Thank You!</p>
            @php
                $isBride = $side === 'bride';
                $firstName = $isBride ? $wedding->bride_name : $wedding->groom_name;
                $secondName = $isBride ? $wedding->groom_name : $wedding->bride_name;
            @endphp
            <div class="font-display text-2xl {{ $footerBg ? 'text-white/80' : 'text-gold/80' }} mb-2 italic">{{ $firstName }} & {{ $secondName }}</div>
            <p class="{{ $footerBg ? 'text-white/60' : 'text-gold/60' }} font-bold tracking-[0.3em] text-sm mb-10">{{ $wedding->event_date?->format('d.m.Y') }}</p>
            <div class="separator mb-10">
                <svg class="w-6 h-6 {{ $footerBg ? 'text-white' : 'text-gold' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </div>
            <p class="text-[10px] {{ $footerBg ? 'text-white/40' : 'text-gray-400' }} uppercase tracking-widest">Designed with ❤️ by THT Media</p>
        </div>
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
