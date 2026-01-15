@extends('layouts.app')
{{-- Template Name: MeWedding Watercolor (Clone of mewedding.online style) --}}

@section('title', 'The Wedding of ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Quicksand:wght@300;400;500;600;700&family=Noto+Serif:ital,wght@0,400;0,700;1,400&display=swap');
    
    :root {
        --color-primary: #C5A25D;
        --color-primary-dark: #A88B4A;
        --color-primary-light: #E8D5B5;
        --color-bg-main: #FFFFFF;
        --color-bg-cream: #FDF9F3;
        --color-text-dark: #545353;
        --color-text-body: #6B7280;
        
        --font-script: 'Dancing Script', cursive;
        --font-body: 'Quicksand', sans-serif;
        --font-serif: 'Noto Serif', serif;
        
        --radius-box: 16px;
    }

    body { 
        font-family: var(--font-body); 
        background-color: var(--color-bg-main); 
        color: var(--color-text-dark); 
    }
    
    .font-script { font-family: var(--font-script); }
    .font-serif { font-family: var(--font-serif); }
    
    .text-gold { color: var(--color-primary); }
    .bg-cream { background-color: var(--color-bg-cream); }
    
    /* Watercolor floral overlay */
    .watercolor-overlay {
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400"><circle cx="50" cy="50" r="40" fill="%23fce7f3" opacity="0.3"/><circle cx="350" cy="80" r="50" fill="%23fdf2f8" opacity="0.4"/><circle cx="380" cy="350" r="45" fill="%23fce7f3" opacity="0.3"/><circle cx="30" cy="380" r="35" fill="%23fdf2f8" opacity="0.4"/></svg>');
        background-size: cover;
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
    
    .animate-fade-in-up { animation: fadeInUp 1s ease-out forwards; }
    .animate-fade-in { animation: fadeIn 1.2s ease-out forwards; }
    .animate-float { animation: float 4s ease-in-out infinite; }
    
    /* Scroll reveal */
    .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s ease-out; }
    .reveal.active { opacity: 1; transform: translateY(0); }
    
    /* Card shadow */
    .card-shadow {
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    /* Decorative separator */
    .separator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
    .separator::before, .separator::after {
        content: '';
        width: 60px;
        height: 1px;
        background: linear-gradient(to right, transparent, var(--color-primary), transparent);
    }
    
    /* Timeline dot */
    .timeline-dot {
        width: 12px;
        height: 12px;
        background: var(--color-primary);
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 2px var(--color-primary);
    }
    
    /* Button style matching mewedding */
    .btn-mewedding {
        background: #9CA3AF;
        color: white;
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
    }
    .btn-mewedding:hover {
        background: var(--color-primary);
    }
    
    .btn-primary-mewedding {
        background: linear-gradient(135deg, #8B5CF6, #EC4899);
        color: white;
        padding: 14px 32px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
    }
</style>

<div class="max-w-[480px] mx-auto bg-white min-h-screen shadow-2xl relative overflow-hidden">
    
    {{-- Pro Features --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'heartbeat'])
    
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" style="envelope" />
    @endif
    
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    
    <x-wedding.music-player :wedding="$wedding" />

    {{-- SECTION 1: HERO / INTRO --}}
    <section class="min-h-screen relative flex flex-col justify-center items-center px-6 py-12 bg-cream watercolor-overlay">
        <div class="text-center animate-fade-in-up">
            <p class="text-sm tracking-[0.3em] uppercase text-gray-500 mb-6">Thân Mời Tới Dự Bữa Tiệc</p>
            
            <div class="mb-8">
                <h1 class="font-script text-5xl text-gold leading-tight mb-2">{{ $wedding->groom_name }}</h1>
                <p class="font-script text-3xl text-gold">&</p>
                <h1 class="font-script text-5xl text-gold leading-tight mt-2">{{ $wedding->bride_name }}</h1>
            </div>
            
            {{-- Couple Hero Image --}}
            <div class="relative mx-auto mb-8 max-w-[280px]">
                <div class="aspect-[3/4] rounded-t-full overflow-hidden border-4 border-white shadow-xl">
                    <img src="{{ $heroUrl }}" class="w-full h-full object-cover" alt="Couple Photo">
                </div>
            </div>
            
            <div class="separator">
                <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
        </div>
        
        <div class="absolute bottom-8 animate-bounce text-gold opacity-60">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    {{-- SECTION 2: SAVE THE DATE --}}
    <section class="py-16 px-6 text-center bg-white watercolor-overlay reveal">
        <p class="text-sm text-gray-500 uppercase tracking-widest mb-4">Xin Hãy Lưu Ngày</p>
        <div class="font-serif text-6xl font-bold text-gold mb-2">
            {{ $wedding->event_date?->format('d.m') }}
        </div>
        <p class="text-gray-600 text-lg">{{ $wedding->event_date?->format('Y') }}</p>
        @if($wedding->event_date_lunar)
            <p class="text-sm text-gray-500 mt-2">({{ $wedding->event_date_lunar }} Âm Lịch)</p>
        @endif
    </section>

    {{-- SECTION 3: GROOM & BRIDE INFO --}}
    <section class="py-16 px-6 bg-cream reveal">
        <div class="text-center mb-10">
            <h2 class="font-script text-4xl text-gold mb-2">Chú Rể & Cô Dâu</h2>
            <div class="separator">
                <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-6">
            {{-- Groom --}}
            <div class="text-center">
                <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover" alt="{{ $wedding->groom_name }}">
                </div>
                <h3 class="font-script text-2xl text-gold mb-1">{{ $wedding->groom_name }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Con Ông: {{ $wedding->groom_father }}<br>
                    Con Bà: {{ $wedding->groom_mother }}
                </p>
            </div>
            
            {{-- Bride --}}
            <div class="text-center">
                <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover" alt="{{ $wedding->bride_name }}">
                </div>
                <h3 class="font-script text-2xl text-gold mb-1">{{ $wedding->bride_name }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Con Ông: {{ $wedding->bride_father }}<br>
                    Con Bà: {{ $wedding->bride_mother }}
                </p>
            </div>
        </div>
    </section>

    {{-- SECTION 4: GALLERY --}}
    <section class="py-16 px-6 bg-white reveal">
        <h2 class="font-script text-4xl text-gold text-center mb-8">Kỷ Niệm Của Chúng Tôi</h2>
        
        <div class="grid grid-cols-3 gap-2 mb-4">
            @php
                $galleryImages = $wedding->gallery_images->take(6);
                $placeholders = [
                    'https://images.unsplash.com/photo-1519741497674-611481863552?w=400',
                    'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400',
                    'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=400',
                    'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=400',
                    'https://images.unsplash.com/photo-1519741497674-611481863552?w=400',
                    'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400'
                ];
            @endphp
            
            @if($galleryImages->isNotEmpty())
                @foreach($galleryImages as $media)
                    <div class="aspect-square rounded-lg overflow-hidden">
                        <img src="{{ $media->getUrl() }}" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                    </div>
                @endforeach
            @else
                @foreach($placeholders as $placeholder)
                    <div class="aspect-square rounded-lg overflow-hidden">
                        <img src="{{ $placeholder }}" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                    </div>
                @endforeach
            @endif
        </div>
        
        {{-- Main slider image --}}
        <div class="relative rounded-2xl overflow-hidden aspect-[4/3]" x-data="{ current: 0, images: {{ json_encode($galleryImages->isNotEmpty() ? $galleryImages->map->getUrl()->toArray() : $placeholders) }} }">
            <template x-for="(img, index) in images" :key="index">
                <img :src="img" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500" 
                     :class="current === index ? 'opacity-100' : 'opacity-0'">
            </template>
            
            <button @click="current = (current - 1 + images.length) % images.length" 
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 rounded-full flex items-center justify-center hover:bg-white transition">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button @click="current = (current + 1) % images.length" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 rounded-full flex items-center justify-center hover:bg-white transition">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </section>

    {{-- SECTION 5: CALENDAR & COUNTDOWN --}}
    @if($wedding->event_date)
    <section class="py-16 px-6 bg-cream watercolor-overlay reveal">
        <h2 class="font-script text-4xl text-gold text-center mb-8">Lịch Cưới</h2>
        
        {{-- Calendar Grid --}}
        <div class="bg-white rounded-2xl p-6 card-shadow max-w-xs mx-auto mb-8">
            <div class="text-center mb-4">
                <p class="font-serif text-lg font-bold text-gray-800">Tháng {{ $wedding->event_date->format('m') }}</p>
                <p class="text-sm text-gray-500">{{ $wedding->event_date->format('Y') }}</p>
            </div>
            
            <div class="grid grid-cols-7 gap-1 text-center text-sm">
                @foreach(['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'] as $day)
                    <div class="text-gray-400 font-medium py-1">{{ $day }}</div>
                @endforeach
                
                @php
                    $eventDay = $wedding->event_date->day;
                    $firstDayOfMonth = $wedding->event_date->copy()->startOfMonth();
                    $daysInMonth = $wedding->event_date->daysInMonth;
                    $startDayOfWeek = $firstDayOfMonth->dayOfWeek;
                @endphp
                
                @for($i = 0; $i < $startDayOfWeek; $i++)
                    <div></div>
                @endfor
                
                @for($d = 1; $d <= $daysInMonth; $d++)
                    <div class="py-2 {{ $d == $eventDay ? 'bg-red-500 text-white rounded-full font-bold relative' : 'text-gray-600' }}">
                        {{ $d }}
                        @if($d == $eventDay)
                            <svg class="w-3 h-3 absolute -top-1 -right-1 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
        
        {{-- Countdown --}}
        @if($wedding->event_date->isFuture())
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="grid grid-cols-4 gap-3 max-w-xs mx-auto">
            <div class="bg-white rounded-xl p-4 text-center card-shadow">
                <div class="text-3xl font-bold text-gray-800" x-text="days">00</div>
                <div class="text-xs text-gray-500 uppercase">Ngày</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center card-shadow">
                <div class="text-3xl font-bold text-gray-800" x-text="hours">00</div>
                <div class="text-xs text-gray-500 uppercase">Giờ</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center card-shadow">
                <div class="text-3xl font-bold text-gray-800" x-text="minutes">00</div>
                <div class="text-xs text-gray-500 uppercase">Phút</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center card-shadow">
                <div class="text-3xl font-bold text-gray-800" x-text="seconds">00</div>
                <div class="text-xs text-gray-500 uppercase">Giây</div>
            </div>
        </div>
        @endif
    </section>
    @endif

    {{-- SECTION 6: STORY / LỜI NGỎ --}}
    <section class="relative py-20 px-6 reveal">
        <div class="absolute inset-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
        
        <div class="relative z-10 text-center text-white">
            <h2 class="font-script text-4xl mb-6">Lời Ngỏ</h2>
            <p class="text-sm leading-relaxed max-w-sm mx-auto opacity-90">
                {{ $wedding->invitation_message ?? 'Ngày ấy, chúng tôi đã gặp nhau và yêu thương nhau. Giờ đây, chúng tôi mong muốn được chia sẻ niềm hạnh phúc này với bạn bè và người thân. Xin mời bạn đến chung vui cùng chúng tôi trong ngày trọng đại này.' }}
            </p>
            
            <div class="mt-8 font-script text-2xl text-gold">
                {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
            </div>
        </div>
    </section>

    {{-- SECTION 7: WEDDING EVENTS / TIMELINE --}}
    <section class="py-16 px-6 bg-white reveal">
        <h2 class="font-script text-4xl text-gold text-center mb-10">Sự Kiện Cưới</h2>
        
        <div class="space-y-6">
            {{-- Groom Event Card --}}
            <div class="bg-cream rounded-2xl p-6 card-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-gold">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-serif font-bold text-gray-800 border-b border-gold pb-1">Tiệc Cưới Nhà Trai</h3>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                    <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }} - {{ $wedding->event_date?->format('d/m/Y') }}
                </div>
                
                <div class="flex items-start gap-2 text-sm text-gray-600 mb-4">
                    <svg class="w-4 h-4 text-gold mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $wedding->groom_reception_venue }}<br>{{ $wedding->groom_address }}</span>
                </div>
                
                <div class="flex gap-3">
                    <a href="#rsvp-section" class="btn-mewedding flex-1 text-center">Xác nhận tham dự</a>
                    @if($wedding->groom_map_url)
                    <a href="{{ $wedding->groom_map_url }}" target="_blank" class="btn-mewedding flex-1 text-center">Xem bản đồ</a>
                    @endif
                </div>
            </div>
            
            {{-- Bride Event Card --}}
            <div class="bg-cream rounded-2xl p-6 card-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-gold">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-serif font-bold text-gray-800 border-b border-gold pb-1">Tiệc Cưới Nhà Gái</h3>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                    <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }} - {{ $wedding->event_date?->format('d/m/Y') }}
                </div>
                
                <div class="flex items-start gap-2 text-sm text-gray-600 mb-4">
                    <svg class="w-4 h-4 text-gold mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $wedding->bride_reception_venue }}<br>{{ $wedding->bride_address }}</span>
                </div>
                
                <div class="flex gap-3">
                    <a href="#rsvp-section" class="btn-mewedding flex-1 text-center">Xác nhận tham dự</a>
                    @if($wedding->bride_map_url)
                    <a href="{{ $wedding->bride_map_url }}" target="_blank" class="btn-mewedding flex-1 text-center">Xem bản đồ</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 8: RSVP / WISHES --}}
    <section id="rsvp-section" class="relative py-16 reveal">
        <div class="absolute inset-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/70"></div>
        </div>
        
        <div class="relative z-10 px-6">
            <h2 class="font-script text-4xl text-white text-center mb-8">Gửi Lời Chúc</h2>
            
            @include('components.wedding.guestbook', ['wedding' => $wedding])
        </div>
    </section>

    {{-- SECTION 9: GIFT / MỪNG CƯỚI --}}
    <section class="py-16 px-6 bg-cream watercolor-overlay reveal">
        <h2 class="font-script text-4xl text-gold text-center mb-8">Mừng Cưới</h2>
        
        <x-wedding.gift-box :wedding="$wedding">
            <div class="space-y-4">
                <button @click="showQr = 'groom'" 
                        class="w-full bg-white rounded-2xl p-4 card-shadow flex items-center gap-4 hover:bg-pink-50 transition">
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-bold text-gray-800">Mừng cưới Chú Rể</p>
                        <p class="text-sm text-gray-500">{{ $wedding->groom_name }}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <button @click="showQr = 'bride'" 
                        class="w-full bg-white rounded-2xl p-4 card-shadow flex items-center gap-4 hover:bg-pink-50 transition">
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-bold text-gray-800">Mừng cưới Cô Dâu</p>
                        <p class="text-sm text-gray-500">{{ $wedding->bride_name }}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </x-wedding.gift-box>
    </section>

    {{-- RSVP FORM --}}
    <section class="py-16 px-6 bg-white reveal">
        @include('components.wedding.rsvp-form', ['wedding' => $wedding])
    </section>

    {{-- FOOTER --}}
    <footer class="py-12 bg-cream text-center watercolor-overlay">
        <div class="font-script text-3xl text-gold mb-2">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</div>
        <p class="text-sm text-gray-500">{{ $wedding->event_date?->format('d.m.Y') }}</p>
        <p class="text-xs text-gray-400 mt-4">Made with ❤️ by THT Media</p>
    </footer>
</div>

<script>
    // Scroll reveal
    document.addEventListener('DOMContentLoaded', () => {
        const reveals = document.querySelectorAll('.reveal');
        
        const revealOnScroll = () => {
            reveals.forEach(el => {
                const top = el.getBoundingClientRect().top;
                if (top < window.innerHeight - 100) {
                    el.classList.add('active');
                }
            });
        };
        
        window.addEventListener('scroll', revealOnScroll);
        revealOnScroll();
    });
</script>

@push('scripts')
    <x-wedding.countdown-script />
@endpush
@endsection
