@extends('layouts.app')
{{-- Template Name: Cherry Blossom (Hoa Anh Đào Lãng Mạn) - PREMIUM --}}

@section('title', 'Wedding | ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@300;400;600&family=Zen+Antique&display=swap');
    
    :root {
        --sakura-pink: #ffd9e8;
        --sakura-deep: #ff85a2;
        --sakura-brown: #5c4033;
        --sakura-cream: #fff8f3;
    }

    body { font-family: 'Noto Serif JP', serif; background: var(--sakura-cream); }
    .font-zen { font-family: 'Zen Antique', serif; }
    
    /* Falling Petals Animation */
    @keyframes fall {
        0% { transform: translateY(-100vh) rotate(0deg); opacity: 1; }
        100% { transform: translateY(100vh) rotate(360deg); opacity: 0.3; }
    }
    @keyframes sway {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(30px); }
    }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes gentleFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes shimmerPink { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    
    .petal {
        position: fixed;
        width: 15px;
        height: 15px;
        background: var(--sakura-pink);
        border-radius: 150% 0 150% 0;
        animation: fall linear infinite, sway ease-in-out infinite;
        pointer-events: none;
        z-index: 100;
        opacity: 0.8;
    }
    
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; }
    .animate-float { animation: gentleFloat 4s ease-in-out infinite; }
    .animate-shimmer { background: linear-gradient(90deg, var(--sakura-deep), var(--sakura-pink), var(--sakura-deep)); background-size: 200% 100%; animation: shimmerPink 3s infinite; -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    
    .delay-200 { animation-delay: 0.2s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-600 { animation-delay: 0.6s; }
    
    /* Watercolor Effect */
    .watercolor-bg {
        background: linear-gradient(135deg, #fff8f3 0%, #ffeef5 50%, #fff8f3 100%);
    }
    
    /* Elegant Card */
    .sakura-card {
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(10px);
        border: 1px solid var(--sakura-pink);
        border-radius: 20px;
    }
</style>

<!-- Falling Petals -->
<div id="petals-container"></div>

<div class="max-w-[480px] mx-auto watercolor-bg min-h-screen shadow-2xl relative overflow-hidden">
    
    {{-- Pro Features: Preload Animation & Demo Watermark --}}
    @include('components.wedding.preload', ['wedding' => $wedding])
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    @include('components.wedding.upgrade-banner', ['wedding' => $wedding, 'showUpgradeBanner' => $showUpgradeBanner ?? false])
    
    {{-- Music Player --}}
    @if($musicUrl)
    <div x-data="{ playing: false, audio: null }" x-init="audio = new Audio('{{ $musicUrl }}'); audio.loop = true;" class="fixed top-6 right-6 z-50">
        <button @click="playing ? audio.pause() : audio.play(); playing = !playing" 
                class="w-12 h-12 rounded-full bg-white/80 backdrop-blur shadow-lg flex items-center justify-center text-[#ff85a2] border border-[#ffd9e8] animate-float">
            <template x-if="!playing"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></template>
            <template x-if="playing"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg></template>
        </button>
    </div>
    @endif

    {{-- HERO SECTION --}}
    <section class="min-h-screen flex flex-col justify-center items-center relative px-6 py-20">
        <!-- Decorative Branch -->
        <div class="absolute top-0 right-0 w-48 h-48 opacity-30">
            <svg viewBox="0 0 200 200" fill="none" class="w-full h-full">
                <path d="M180 20 Q150 80, 100 100 T50 180" stroke="#ff85a2" stroke-width="2" fill="none"/>
                <circle cx="160" cy="40" r="8" fill="#ffd9e8"/>
                <circle cx="140" cy="60" r="6" fill="#ffb6c1"/>
                <circle cx="120" cy="80" r="7" fill="#ffd9e8"/>
            </svg>
        </div>
        
        <div class="text-center relative z-10 animate-fade-up">
            <p class="text-xs uppercase tracking-[0.4em] text-[#ff85a2] mb-8 font-light">Save The Date</p>
            
            <div class="mb-8">
                <h1 class="text-5xl font-zen text-[#5c4033] mb-4 animate-shimmer">{{ $wedding->groom_name }}</h1>
                <div class="flex items-center justify-center gap-4 my-4">
                    <div class="w-16 h-[1px] bg-gradient-to-r from-transparent to-[#ff85a2]"></div>
                    <span class="text-3xl text-[#ff85a2]">❀</span>
                    <div class="w-16 h-[1px] bg-gradient-to-l from-transparent to-[#ff85a2]"></div>
                </div>
                <h1 class="text-5xl font-zen text-[#5c4033] animate-shimmer delay-200">{{ $wedding->bride_name }}</h1>
            </div>
            
            <div class="sakura-card p-6 inline-block mt-8 animate-fade-up delay-400">
                <p class="text-2xl font-zen text-[#5c4033]">{{ $wedding->event_date?->format('d . m . Y') }}</p>
                @if($wedding->event_date_lunar)
                <p class="text-sm text-[#ff85a2] mt-2 italic">({{ $wedding->event_date_lunar }})</p>
                @endif
            </div>
        </div>
        
        <!-- Hero Image with Sakura Frame -->
        <div class="relative mt-12 animate-fade-up delay-600">
            <div class="absolute -inset-4 border-2 border-[#ffd9e8] rounded-[30px] rotate-3"></div>
            <img src="{{ $heroUrl }}" class="w-72 h-96 object-cover rounded-[25px] shadow-xl" alt="Couple Photo">
            <div class="absolute -top-6 -left-6 text-4xl animate-float">🌸</div>
            <div class="absolute -bottom-6 -right-6 text-4xl animate-float delay-200">🌸</div>
        </div>
    </section>

    {{-- COUPLE SECTION --}}
    <section class="py-20 px-6">
        <div class="text-center mb-16">
            <span class="text-3xl">🌸</span>
            <h2 class="font-zen text-3xl text-[#5c4033] mt-4">Cô Dâu & Chú Rể</h2>
        </div>
        
        <div class="space-y-16">
            <!-- Groom -->
            <div class="sakura-card p-8 text-center animate-fade-up">
                <div class="w-40 h-52 mx-auto mb-6 overflow-hidden rounded-[20px] border-2 border-[#ffd9e8]">
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-zen text-2xl text-[#5c4033] mb-2">{{ $wedding->groom_name }}</h3>
                <p class="text-xs uppercase tracking-widest text-[#ff85a2] mb-4">Chú Rể</p>
                <p class="text-sm text-gray-600">Con ông {{ $wedding->groom_father }}<br>và bà {{ $wedding->groom_mother }}</p>
            </div>
            
            <!-- Bride -->
            <div class="sakura-card p-8 text-center animate-fade-up delay-200">
                <div class="w-40 h-52 mx-auto mb-6 overflow-hidden rounded-[20px] border-2 border-[#ffd9e8]">
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-zen text-2xl text-[#5c4033] mb-2">{{ $wedding->bride_name }}</h3>
                <p class="text-xs uppercase tracking-widest text-[#ff85a2] mb-4">Cô Dâu</p>
                <p class="text-sm text-gray-600">Con ông {{ $wedding->bride_father }}<br>và bà {{ $wedding->bride_mother }}</p>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-20 px-6 bg-gradient-to-b from-[#ffeef5] to-[#fff8f3]">
        <div class="text-center">
            <span class="text-3xl">⏰</span>
            <h2 class="font-zen text-2xl text-[#5c4033] mt-4 mb-12">Đếm Ngược</h2>
            
            <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="grid grid-cols-4 gap-4">
                <div class="sakura-card p-4">
                    <span x-text="days" class="block text-3xl font-zen text-[#ff85a2]">00</span>
                    <span class="text-xs text-gray-500">Ngày</span>
                </div>
                <div class="sakura-card p-4">
                    <span x-text="hours" class="block text-3xl font-zen text-[#ff85a2]">00</span>
                    <span class="text-xs text-gray-500">Giờ</span>
                </div>
                <div class="sakura-card p-4">
                    <span x-text="minutes" class="block text-3xl font-zen text-[#ff85a2]">00</span>
                    <span class="text-xs text-gray-500">Phút</span>
                </div>
                <div class="sakura-card p-4">
                    <span x-text="seconds" class="block text-3xl font-zen text-[#ff85a2]">00</span>
                    <span class="text-xs text-gray-500">Giây</span>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- EVENTS --}}
    <section class="py-20 px-6">
        <div class="text-center mb-12">
            <span class="text-3xl">💒</span>
            <h2 class="font-zen text-2xl text-[#5c4033] mt-4">Sự Kiện Cưới</h2>
        </div>
        
        <div class="space-y-8">
            <!-- Nhà Gái -->
            <div class="sakura-card p-8">
                <h3 class="font-zen text-xl text-[#ff85a2] mb-6 text-center border-b border-[#ffd9e8] pb-4">Nhà Gái</h3>
                <div class="text-center space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Lễ Vu Quy</p>
                        <p class="text-2xl font-zen text-[#5c4033]">{{ $wedding->bride_ceremony_time ? \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') : '--' }}</p>
                        <p class="text-sm text-gray-600 mt-2">{{ $wedding->bride_address }}</p>
                    </div>
                    @if($wedding->bride_map_url)
                    <a href="{{ $wedding->bride_map_url }}" target="_blank" class="inline-block px-6 py-2 bg-[#ff85a2] text-white rounded-full text-sm hover:bg-[#ff6b8a] transition">📍 Xem bản đồ</a>
                    @endif
                </div>
            </div>
            
            <!-- Nhà Trai -->
            <div class="sakura-card p-8">
                <h3 class="font-zen text-xl text-[#ff85a2] mb-6 text-center border-b border-[#ffd9e8] pb-4">Nhà Trai</h3>
                <div class="text-center space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Lễ Thành Hôn</p>
                        <p class="text-2xl font-zen text-[#5c4033]">{{ $wedding->groom_ceremony_time ? \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') : '--' }}</p>
                        <p class="text-sm text-gray-600 mt-2">{{ $wedding->groom_address }}</p>
                    </div>
                    @if($wedding->groom_map_url)
                    <a href="{{ $wedding->groom_map_url }}" target="_blank" class="inline-block px-6 py-2 bg-[#ff85a2] text-white rounded-full text-sm hover:bg-[#ff6b8a] transition">📍 Xem bản đồ</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    <section class="py-20 px-4 bg-gradient-to-b from-[#fff8f3] to-[#ffeef5]">
        <div class="text-center mb-12">
            <span class="text-3xl">📸</span>
            <h2 class="font-zen text-2xl text-[#5c4033] mt-4">Khoảnh Khắc Đẹp</h2>
        </div>
        
        <div class="columns-2 gap-3 space-y-3">
            @if($wedding->getMedia('gallery')->isNotEmpty())
                @foreach($wedding->getMedia('gallery') as $media)
                <div class="break-inside-avoid sakura-card p-2">
                    <img src="{{ $media->getUrl() }}" class="w-full rounded-lg">
                </div>
                @endforeach
            @else
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=400', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=400', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=400'] as $placeholder)
                <div class="break-inside-avoid sakura-card p-2">
                    <img src="{{ $placeholder }}" class="w-full rounded-lg">
                </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- RSVP & QR --}}
    <section class="py-20 px-6" x-data="{ showQr: null }">
        <div class="text-center mb-12">
            <span class="text-3xl">💝</span>
            <h2 class="font-zen text-2xl text-[#5c4033] mt-4">Hộp Mừng Cưới</h2>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <button @click="showQr = 'groom'" class="sakura-card p-6 text-center hover:border-[#ff85a2] transition">
                <span class="text-2xl mb-2 block">🤵</span>
                <span class="text-sm text-[#5c4033]">Nhà Trai</span>
            </button>
            <button @click="showQr = 'bride'" class="sakura-card p-6 text-center hover:border-[#ff85a2] transition">
                <span class="text-2xl mb-2 block">👰</span>
                <span class="text-sm text-[#5c4033]">Nhà Gái</span>
            </button>
        </div>
        
        <!-- QR Modal -->
        <div x-show="showQr" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80" style="display: none;">
            <div class="sakura-card p-8 w-full max-w-sm text-center" @click.outside="showQr = null">
                <button @click="showQr = null" class="absolute top-4 right-4 text-gray-400">✕</button>
                <h3 class="font-zen text-xl text-[#5c4033] mb-6" x-text="showQr === 'groom' ? 'Nhà Trai' : 'Nhà Gái'"></h3>
                <template x-if="showQr === 'groom'">
                    <div>
                        @if($wedding->getFirstMediaUrl('groom_qr'))
                        <img src="{{ $wedding->getFirstMediaUrl('groom_qr') }}" class="w-48 h-48 mx-auto mb-4 rounded-lg">
                        @endif
                        <p class="text-sm text-gray-600">{{ $wedding->groom_qr_info }}</p>
                    </div>
                </template>
                <template x-if="showQr === 'bride'">
                    <div>
                        @if($wedding->getFirstMediaUrl('bride_qr'))
                        <img src="{{ $wedding->getFirstMediaUrl('bride_qr') }}" class="w-48 h-48 mx-auto mb-4 rounded-lg">
                        @endif
                        <p class="text-sm text-gray-600">{{ $wedding->bride_qr_info }}</p>
                    </div>
                </template>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-16 text-center bg-gradient-to-b from-[#ffeef5] to-[#ffd9e8]">
        <div class="text-4xl mb-4">🌸</div>
        <h2 class="font-zen text-3xl text-[#5c4033] mb-2">Thank You</h2>
        <p class="text-sm text-[#ff85a2]">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</p>
    </footer>
</div>

{{-- RSVP & Guestbook Components --}}
@include('components.wedding.rsvp-form', ['wedding' => $wedding])
@include('components.wedding.guestbook', ['wedding' => $wedding])

<script>
// Create falling petals
function createPetals() {
    const container = document.getElementById('petals-container');
    for (let i = 0; i < 15; i++) {
        const petal = document.createElement('div');
        petal.className = 'petal';
        petal.style.left = Math.random() * 100 + 'vw';
        petal.style.animationDuration = (Math.random() * 5 + 8) + 's, ' + (Math.random() * 2 + 2) + 's';
        petal.style.animationDelay = Math.random() * 5 + 's';
        container.appendChild(petal);
    }
}
createPetals();

function countdown(targetDate) {
    return {
        days: '00', hours: '00', minutes: '00', seconds: '00',
        init() { this.updateCountdown(); setInterval(() => this.updateCountdown(), 1000); },
        updateCountdown() {
            const diff = new Date(targetDate + 'T00:00:00').getTime() - new Date().getTime();
            if (diff > 0) {
                this.days = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
                this.hours = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                this.minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                this.seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
            }
        }
    }
}
</script>
@endsection
