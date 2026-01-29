@extends('layouts.app')
{{-- Template Name: Spring Blossom (Hương Sắc Mùa Xuân) --}}
{{-- Tier: pro --}}

@section('title', 'Happy Wedding - ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

@php
    $galleryImages = $wedding->gallery_images;
    $imagesToDisplay = $galleryImages->isNotEmpty() ? $galleryImages->map->getUrl() : [
        'https://images.unsplash.com/photo-1519741497674-611481863552?w=800',
        'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800'
    ];
@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --color-primary: #FFB7C5;
        --color-gold: #D4AF37;
        --color-dark: #1a1a1a;
        --color-text: #2d2d2d;
        
        --font-heading: 'Playfair Display', serif;
        --font-body: 'Montserrat', sans-serif;
        --font-script: 'Montserrat', sans-serif; /* Disable script font by mapping it to body */
        
        --radius-box: 24px;
    }

    body {
        background-color: #FFF;
        color: var(--color-text);
        font-family: var(--font-body);
        line-height: 1.8;
        font-size: 18px; /* Increased for readability */
    }

    .font-heading { font-family: var(--font-heading); font-weight: 700; }
    .font-script { font-family: var(--font-body); font-style: italic; }
    .font-viceroy { font-family: var(--font-heading); }

    .bg-main-watercolor {
        background-image: url('{{ asset('images/back-ground-1.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    /* Watercolor floral overlay */
    .watercolor-overlay {
        position: relative;
    }
    
    .watercolor-overlay::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: url('{{ asset('images/back-ground-1.png') }}');
        background-size: cover;
        opacity: 0.15;
        pointer-events: none;
    }

    .shimmer-text {
        background: linear-gradient(90deg, #FFB7C5, #90BE6D, #FFB7C5);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 3s linear infinite;
    }

    @keyframes shimmer {
        to { background-position: 200% center; }
    }

    .btn-spring {
        background: linear-gradient(135deg, #FFB7C5 0%, #FF8FA3 100%);
        color: white !important;
        border: none;
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 20px rgba(255, 183, 197, 0.4);
    }

    .btn-spring:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
        box-shadow: 0 15px 30px rgba(255, 183, 197, 0.5);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 183, 197, 0.3);
    }
    
    .text-glow-pink {
        text-shadow: 0 0 15px rgba(255, 143, 163, 0.3);
    }
</style>
@endpush

<div class="max-w-[480px] mx-auto bg-white min-h-screen shadow-2xl relative overflow-hidden">
    
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'heartbeat'])
    
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    <x-wedding.music-player :wedding="$wedding" />

    {{-- HERO --}}
    <section class="min-h-screen relative flex flex-col items-center justify-end pb-32 text-center watercolor-overlay">
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/30 to-transparent"></div>
        </div>

        <div class="relative z-10 px-6">
            <p class="text-xs tracking-[0.4em] uppercase text-gray-500 mb-6 font-bold" data-aos="fade-up">A Wedding Celebration</p>
            <h1 class="font-heading text-6xl text-gray-950 mb-6" data-aos="zoom-in" style="line-height: 1.2;">{{ $wedding->groom_name }}</h1>
            <p class="font-script text-4xl text-gray-400 my-4">&</p>
            <h1 class="font-heading text-6xl text-gray-950 mb-12" data-aos="zoom-in" data-aos-delay="200" style="line-height: 1.2;">{{ $wedding->bride_name }}</h1>
            
            <div class="glass-card py-5 px-12 rounded-full shadow-2xl inline-block transition-all hover:scale-105 duration-500 border-pink-100" data-aos="fade-up" data-aos-delay="400">
                <p class="text-xl font-bold tracking-[0.3em] text-gray-600 font-serif">{{ $wedding->event_date?->format('d . m . Y') }}</p>
            </div>
        </div>
    </section>

    {{-- INTRO --}}
    <section class="py-24 px-8 text-center bg-main-watercolor" data-aos="fade-up">
        <div class="glass-card p-12 rounded-[40px] shadow-lg max-w-sm mx-auto">
            <img src="https://cdn-icons-png.flaticon.com/512/2926/2926331.png" class="w-12 h-12 mx-auto mb-8 opacity-40 animate-float">
            <h2 class="font-heading text-4xl text-gray-900 mb-8 uppercase tracking-widest">Hành Trình Hạnh Phúc</h2>
            <p class="text-gray-500 leading-relaxed italic text-lg">
                "Hạnh phúc không phải là điểm đến, mà là hành trình chúng ta cùng đi bên nhau."
            </p>
        </div>
    </section>

    {{-- STORY / LỜI NGỎ --}}
    <section class="relative py-32 px-6 overflow-hidden" data-aos="fade-up">
        <div class="absolute inset-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-white/75 backdrop-blur-[3px]"></div>
        </div>
        
        <div class="relative z-10 text-center px-10" data-aos="fade-up">
            <h2 class="font-heading text-6xl font-black mb-12 text-gray-900 tracking-tighter">Lời Ngỏ</h2>

            <div class="space-y-10 text-xl text-gray-600 leading-relaxed max-w-lg mx-auto font-medium">
                @if($prologue_content = $wedding->getContentValue('prologue_desc'))
                    @foreach(explode("\n", $prologue_content) as $line)
                        @if(trim($line)) <p>{{ $line }}</p> @endif
                    @endforeach
                @else
                    <p>Mọi người nói rằng tình yêu là một món quà, và chúng tôi cảm thấy mình là những người may mắn nhất khi tìm thấy nhau.</p>
                    <p>Sự hiện diện và lời chúc phúc của bạn chính là món quà ý nghĩa nhất trong ngày trọng đại này của chúng tôi.</p>
                @endif
                <div class="pt-20">
                    <p class="font-heading text-3xl text-gray-900 italic">Trân trọng cảm ơn</p>
                    <div class="w-12 h-px bg-gray-100 mx-auto mt-10"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- COUPLE --}}
    <section class="py-24 px-6 bg-white watercolor-overlay">
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center" data-aos="fade-right">
                <div class="aspect-square rounded-full overflow-hidden border-8 border-white mb-6 shadow-2xl transition-transform hover:scale-105 duration-500">
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-heading text-4xl text-gray-900 mb-2 whitespace-nowrap">{{ $wedding->groom_name }}</h3>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-500 font-bold mb-4">The Groom</p>
                <div class="text-xs text-gray-400 space-y-1 italic">
                    @if($wedding->groom_father)<p>Con ông: {{ $wedding->groom_father }}</p>@endif
                    @if($wedding->groom_mother)<p>Con bà: {{ $wedding->groom_mother }}</p>@endif
                </div>
            </div>

            <div class="text-center" data-aos="fade-left">
                <div class="aspect-square rounded-full overflow-hidden border-8 border-white mb-6 shadow-2xl transition-transform hover:scale-105 duration-500">
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-heading text-4xl text-gray-900 mb-2 whitespace-nowrap">{{ $wedding->bride_name }}</h3>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-500 font-bold mb-4">The Bride</p>
                <div class="text-xs text-gray-400 space-y-1 italic">
                    @if($wedding->bride_father)<p>Con ông: {{ $wedding->bride_father }}</p>@endif
                    @if($wedding->bride_mother)<p>Con bà: {{ $wedding->bride_mother }}</p>@endif
                </div>
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section class="py-32 px-8 bg-main-watercolor" data-aos="fade-up">
        <div class="text-center mb-16">
            <h2 class="font-serif text-5xl font-bold text-[#FF8FA3] pt-12 uppercase tracking-widest" style="line-height: 1.3;">Trân Trọng Kính Mời</h2>
            <div class="w-12 h-1 bg-[#FFB7C5]/30 mx-auto mt-6 rounded-full"></div>
        </div>
        
        <div class="space-y-10">
            {{-- Bride Event --}}
            <div class="glass-card p-10 rounded-[40px] shadow-2xl relative overflow-hidden border-pink-50" data-aos="fade-up">
                <div class="absolute top-0 left-0 w-2 h-full bg-[#FFB7C5]"></div>
                <div class="relative">
                    <h4 class="font-viceroy text-4xl text-gray-800 mb-4">Lễ Vu Quy</h4>
                    <div class="flex items-center gap-2 text-gray-700 font-bold text-lg mb-4">
                        <svg class="w-5 h-5 text-[#FFB7C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') }}</span>
                        @if($wedding->bride_ceremony_date)
                            <span class="text-gray-300 mx-1">|</span>
                            <span>{{ $wedding->bride_ceremony_date->format('d/m/Y') }}</span>
                        @endif
                    </div>
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-[#FFB7C5] mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <p class="text-sm text-gray-500 italic leading-relaxed">{{ $wedding->bride_address }}</p>
                    </div>
                </div>
            </div>

            {{-- Groom Event --}}
            <div class="glass-card p-10 rounded-[40px] shadow-2xl relative overflow-hidden border-pink-50" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute top-0 left-0 w-2 h-full bg-[#90BE6D]"></div>
                <div class="relative">
                    <h4 class="font-viceroy text-4xl text-gray-800 mb-4">Lễ Thành Hôn</h4>
                    <div class="flex items-center gap-2 text-gray-700 font-bold text-lg mb-4">
                        <svg class="w-5 h-5 text-[#90BE6D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') }}</span>
                        @if($wedding->groom_ceremony_date)
                            <span class="text-gray-300 mx-1">|</span>
                            <span>{{ $wedding->groom_ceremony_date->format('d/m/Y') }}</span>
                        @endif
                    </div>
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-[#90BE6D] mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <p class="text-sm text-gray-500 italic leading-relaxed">{{ $wedding->groom_address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    <section class="py-24 px-4 bg-white">
        <h2 class="font-heading text-5xl text-center text-gray-900 mb-16 uppercase tracking-widest">Khoảnh Khắc</h2>
        <div class="columns-2 gap-4 space-y-4">
            @foreach($imagesToDisplay as $img)
            <div class="break-inside-avoid rounded-[30px] overflow-hidden shadow-lg border-4 border-white transition-all hover:scale-[1.03] duration-500" data-aos="zoom-in">
                <img src="{{ $img }}" class="w-full h-auto object-cover">
            </div>
            @endforeach
        </div>
    </section>

    {{-- RSVP --}}
    <div class="bg-main-watercolor py-12">
        @include('components.wedding.rsvp-form', ['wedding' => $wedding])
    </div>

    {{-- GIFT BOX --}}
    <x-wedding.gift-box :wedding="$wedding" class="py-32 px-8 text-center bg-white watercolor-overlay">
        <h2 class="font-heading text-5xl font-bold text-gray-900 mb-16 uppercase tracking-widest">Mừng Cưới</h2>
        <div class="grid grid-cols-2 gap-8">
            <button @click="showQr = 'groom'" class="glass-card p-8 rounded-[30px] shadow-2xl border-pink-50 transition-all hover:scale-105 hover:-translate-y-2 duration-500 group">
                <p class="text-[10px] uppercase tracking-[0.4em] font-bold text-gray-400 mb-4 group-hover:text-[#FF8FA3] transition-colors">Nhà Trai</p>
                <span class="font-serif text-2xl font-bold text-gray-700">CHÚ RỂ</span>
            </button>
            <button @click="showQr = 'bride'" class="glass-card p-8 rounded-[30px] shadow-2xl border-pink-50 transition-all hover:scale-105 hover:-translate-y-2 duration-500 group">
                <p class="text-[10px] uppercase tracking-[0.4em] font-bold text-gray-400 mb-4 group-hover:text-[#FF8FA3] transition-colors">Nhà Gái</p>
                <span class="font-serif text-2xl font-bold text-gray-700">CÔ DÂU</span>
            </button>
        </div>
    </x-wedding.gift-box>

    {{-- GUESTBOOK --}}
    <div class="bg-cream">
        @include('components.wedding.guestbook', ['wedding' => $wedding])
    </div>

    {{-- FOOTER --}}
    <footer class="py-32 bg-white text-center px-10 relative overflow-hidden">
        <div class="w-24 h-px bg-pink-100 mx-auto mb-16 opacity-50"></div>
        <h2 class="font-heading text-5xl font-bold mb-8 text-gray-900 uppercase tracking-widest">Cảm Ơn</h2>
        <p class="text-gray-400 italic mb-16 text-lg font-serif">Hẹn gặp lại bạn tại buổi tiệc!</p>
        <div class="font-bold text-gray-800 uppercase tracking-[0.5em] text-xs opacity-60 font-serif">
            {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
        </div>
    </footer>
</div>

@endsection
