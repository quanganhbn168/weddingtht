@extends('layouts.app')
{{-- Template Name: Galaxy Dreams (Ngân Hà Lung Linh) - PREMIUM --}}

@section('title', 'Galaxy Wedding | ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Space+Grotesk:wght@300;400;500&display=swap');
    
    :root {
        --galaxy-dark: #0c0c1e;
        --galaxy-purple: #4c1d95;
        --galaxy-pink: #ec4899;
        --galaxy-gold: #fbbf24;
        --galaxy-cyan: #22d3ee;
    }

    body { font-family: 'Space Grotesk', sans-serif; background: var(--galaxy-dark); color: white; }
    .font-orbitron { font-family: 'Orbitron', monospace; }
    
    /* Starfield Background */
    .starfield {
        background: linear-gradient(to bottom, #0c0c1e 0%, #1a1a3e 50%, #0c0c1e 100%);
        position: relative;
    }
    .starfield::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: 
            radial-gradient(2px 2px at 20px 30px, white, transparent),
            radial-gradient(2px 2px at 40px 70px, rgba(255,255,255,0.8), transparent),
            radial-gradient(1px 1px at 90px 40px, white, transparent),
            radial-gradient(2px 2px at 160px 120px, rgba(255,255,255,0.9), transparent),
            radial-gradient(1px 1px at 230px 80px, white, transparent),
            radial-gradient(2px 2px at 300px 150px, rgba(255,255,255,0.7), transparent),
            radial-gradient(1px 1px at 350px 60px, white, transparent),
            radial-gradient(2px 2px at 420px 200px, rgba(255,255,255,0.8), transparent);
        background-size: 480px 300px;
        animation: twinkle 4s ease-in-out infinite alternate;
    }
    
    @keyframes twinkle { 0%, 100% { opacity: 0.5; } 50% { opacity: 1; } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
    @keyframes glow { 0%, 100% { filter: drop-shadow(0 0 5px var(--galaxy-pink)); } 50% { filter: drop-shadow(0 0 20px var(--galaxy-cyan)); } }
    @keyframes aurora { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes shootingStar { 0% { transform: translateX(-100px) translateY(-100px); opacity: 1; } 100% { transform: translateX(100vw) translateY(100vh); opacity: 0; } }
    
    .animate-float { animation: float 4s ease-in-out infinite; }
    .animate-glow { animation: glow 3s ease-in-out infinite; }
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; }
    
    .delay-200 { animation-delay: 0.2s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-600 { animation-delay: 0.6s; }
    
    /* Aurora Effect */
    .aurora-bg {
        background: linear-gradient(-45deg, #4c1d95, #ec4899, #22d3ee, #4c1d95);
        background-size: 400% 400%;
        animation: aurora 10s ease infinite;
    }
    
    /* Galaxy Card */
    .galaxy-card {
        background: linear-gradient(135deg, rgba(76,29,149,0.3), rgba(12,12,30,0.95));
        border: 1px solid rgba(236,72,153,0.3);
        backdrop-filter: blur(10px);
        border-radius: 20px;
    }
    
    /* Neon Text */
    .neon-text {
        text-shadow: 0 0 10px var(--galaxy-pink), 0 0 20px var(--galaxy-purple);
    }
    .neon-gold {
        text-shadow: 0 0 10px var(--galaxy-gold), 0 0 20px var(--galaxy-gold);
    }
    
    /* Shooting Star */
    .shooting-star {
        position: absolute;
        width: 100px;
        height: 2px;
        background: linear-gradient(to right, transparent, white, transparent);
        animation: shootingStar 3s linear infinite;
    }
</style>

<div class="max-w-[480px] mx-auto starfield min-h-screen shadow-2xl relative overflow-hidden">
    
    {{-- Pro Features: Preload Animation & Demo Watermark --}}
    @include('components.wedding.preload', ['wedding' => $wedding])
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    @include('components.wedding.upgrade-banner', ['wedding' => $wedding, 'showUpgradeBanner' => $showUpgradeBanner ?? false])
    
    <!-- Shooting Stars -->
    <div class="shooting-star" style="top: 20%; left: 0; animation-delay: 0s;"></div>
    <div class="shooting-star" style="top: 40%; left: 0; animation-delay: 2s;"></div>
    <div class="shooting-star" style="top: 70%; left: 0; animation-delay: 4s;"></div>
    
    {{-- Music Player --}}
    @if($musicUrl)
    <div x-data="{ playing: false, audio: null }" x-init="audio = new Audio('{{ $musicUrl }}'); audio.loop = true;" class="fixed top-6 right-6 z-50">
        <button @click="playing ? audio.pause() : audio.play(); playing = !playing" 
                class="w-12 h-12 rounded-full bg-[#4c1d95]/80 backdrop-blur border border-[#ec4899] flex items-center justify-center text-[#22d3ee] animate-glow">
            <template x-if="!playing"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></template>
            <template x-if="playing"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg></template>
        </button>
    </div>
    @endif

    {{-- HERO - GALAXY OPENING --}}
    <section class="min-h-screen flex flex-col justify-center items-center relative px-6 py-20">
        <!-- Constellation Lines -->
        <svg class="absolute inset-0 w-full h-full opacity-20" viewBox="0 0 480 800">
            <path d="M100 200 L200 150 L250 250 L150 300 Z" stroke="#ec4899" fill="none" stroke-dasharray="5,5"/>
            <path d="M300 100 L380 180 L350 280" stroke="#22d3ee" fill="none" stroke-dasharray="5,5"/>
            <circle cx="100" cy="200" r="4" fill="#fbbf24"/>
            <circle cx="200" cy="150" r="3" fill="#ec4899"/>
            <circle cx="250" cy="250" r="5" fill="#22d3ee"/>
            <circle cx="300" cy="100" r="4" fill="#fbbf24"/>
            <circle cx="380" cy="180" r="3" fill="#ec4899"/>
        </svg>
        
        <div class="text-center relative z-10">
            <div class="text-6xl mb-6 animate-float">🌙</div>
            
            <p class="font-orbitron text-[#22d3ee] text-xs tracking-[0.4em] mb-6 animate-fade-up">WRITTEN IN THE STARS</p>
            
            <div class="space-y-4 animate-fade-up delay-200">
                <h1 class="font-orbitron text-4xl md:text-5xl text-white neon-text">{{ $wedding->groom_name }}</h1>
                <div class="flex items-center justify-center gap-4">
                    <span class="text-2xl animate-glow">✦</span>
                    <span class="font-orbitron text-[#fbbf24] text-xl">&</span>
                    <span class="text-2xl animate-glow">✦</span>
                </div>
                <h1 class="font-orbitron text-4xl md:text-5xl text-white neon-text">{{ $wedding->bride_name }}</h1>
            </div>
            
            <div class="mt-12 galaxy-card p-6 inline-block animate-fade-up delay-400">
                <p class="font-orbitron text-2xl text-[#fbbf24] neon-gold">{{ $wedding->event_date?->format('d . m . Y') }}</p>
                @if($wedding->event_date_lunar)
                <p class="text-sm text-[#22d3ee] mt-2">({{ $wedding->event_date_lunar }})</p>
                @endif
            </div>
        </div>
        
        <!-- Hero Image with Galaxy Frame -->
        <div class="relative mt-12 animate-fade-up delay-600">
            <div class="absolute -inset-4 aurora-bg rounded-[30px] opacity-50"></div>
            <img src="{{ $heroUrl }}" class="relative w-64 h-80 object-cover rounded-[25px] border-2 border-[#ec4899]" alt="Couple Photo">
            <div class="absolute -top-4 -left-4 text-3xl animate-float">⭐</div>
            <div class="absolute -bottom-4 -right-4 text-3xl animate-float delay-200">🌟</div>
        </div>
    </section>

    {{-- COUPLE - COSMIC PAIR --}}
    <section class="py-20 px-6 relative">
        <div class="text-center mb-16">
            <span class="text-3xl animate-glow">✨</span>
            <h2 class="font-orbitron text-2xl text-white mt-4 neon-text">COSMIC PAIR</h2>
        </div>
        
        <div class="space-y-12">
            <!-- Groom -->
            <div class="galaxy-card p-6 text-center animate-fade-up">
                <div class="w-40 h-52 mx-auto mb-6 overflow-hidden rounded-[20px] border-2 border-[#22d3ee]">
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-orbitron text-xl text-white mb-2">{{ $wedding->groom_name }}</h3>
                <p class="text-xs uppercase tracking-widest text-[#ec4899] mb-4">The Groom</p>
                <p class="text-sm text-gray-400">Con ông {{ $wedding->groom_father }}<br>và bà {{ $wedding->groom_mother }}</p>
            </div>
            
            <div class="text-center text-4xl animate-float">🌌</div>
            
            <!-- Bride -->
            <div class="galaxy-card p-6 text-center animate-fade-up delay-200">
                <div class="w-40 h-52 mx-auto mb-6 overflow-hidden rounded-[20px] border-2 border-[#ec4899]">
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-orbitron text-xl text-white mb-2">{{ $wedding->bride_name }}</h3>
                <p class="text-xs uppercase tracking-widest text-[#22d3ee] mb-4">The Bride</p>
                <p class="text-sm text-gray-400">Con ông {{ $wedding->bride_father }}<br>và bà {{ $wedding->bride_mother }}</p>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN - LAUNCH SEQUENCE --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-20 px-6 aurora-bg">
        <div class="text-center mb-12">
            <p class="font-orbitron text-xs tracking-[0.3em] text-white/80">LAUNCH COUNTDOWN</p>
            <h2 class="font-orbitron text-2xl text-white mt-2 neon-gold">T-MINUS</h2>
        </div>
        
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="grid grid-cols-4 gap-3">
            <div class="galaxy-card p-4 text-center">
                <span x-text="days" class="font-orbitron text-3xl text-[#fbbf24] block">00</span>
                <span class="text-xs text-gray-400">DAYS</span>
            </div>
            <div class="galaxy-card p-4 text-center">
                <span x-text="hours" class="font-orbitron text-3xl text-[#ec4899] block">00</span>
                <span class="text-xs text-gray-400">HRS</span>
            </div>
            <div class="galaxy-card p-4 text-center">
                <span x-text="minutes" class="font-orbitron text-3xl text-[#22d3ee] block">00</span>
                <span class="text-xs text-gray-400">MIN</span>
            </div>
            <div class="galaxy-card p-4 text-center">
                <span x-text="seconds" class="font-orbitron text-3xl text-white block">00</span>
                <span class="text-xs text-gray-400">SEC</span>
            </div>
        </div>
    </section>
    @endif

    {{-- EVENTS - COORDINATES --}}
    <section class="py-20 px-6">
        <div class="text-center mb-12">
            <span class="text-3xl">🚀</span>
            <h2 class="font-orbitron text-2xl text-white mt-4">MISSION LOCATIONS</h2>
        </div>
        
        <div class="space-y-8">
            <!-- Nhà Gái -->
            <div class="galaxy-card p-6">
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-[#ec4899]/30">
                    <span class="text-2xl animate-glow">📍</span>
                    <h3 class="font-orbitron text-lg text-[#ec4899]">NHÀ GÁI - VU QUY</h3>
                </div>
                <div class="space-y-3 text-gray-300">
                    <p class="flex justify-between"><span class="text-gray-500">Time:</span><span class="font-orbitron text-[#fbbf24]">{{ $wedding->bride_ceremony_time ? \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') : '--' }}</span></p>
                    <p class="text-sm text-gray-400">{{ $wedding->bride_address }}</p>
                </div>
                @if($wedding->bride_map_url)
                <a href="{{ $wedding->bride_map_url }}" target="_blank" class="mt-4 inline-flex items-center gap-2 font-orbitron text-sm text-[#22d3ee] border border-[#22d3ee] px-4 py-2 rounded-full hover:bg-[#22d3ee] hover:text-black transition">
                    <span>🗺️</span> NAVIGATE
                </a>
                @endif
            </div>
            
            <!-- Nhà Trai -->
            <div class="galaxy-card p-6">
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-[#22d3ee]/30">
                    <span class="text-2xl animate-glow">📍</span>
                    <h3 class="font-orbitron text-lg text-[#22d3ee]">NHÀ TRAI - THÀNH HÔN</h3>
                </div>
                <div class="space-y-3 text-gray-300">
                    <p class="flex justify-between"><span class="text-gray-500">Time:</span><span class="font-orbitron text-[#fbbf24]">{{ $wedding->groom_ceremony_time ? \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') : '--' }}</span></p>
                    <p class="text-sm text-gray-400">{{ $wedding->groom_address }}</p>
                </div>
                @if($wedding->groom_map_url)
                <a href="{{ $wedding->groom_map_url }}" target="_blank" class="mt-4 inline-flex items-center gap-2 font-orbitron text-sm text-[#ec4899] border border-[#ec4899] px-4 py-2 rounded-full hover:bg-[#ec4899] hover:text-black transition">
                    <span>🗺️</span> NAVIGATE
                </a>
                @endif
            </div>
        </div>
    </section>

    {{-- GALLERY - CAPTURED MEMORIES --}}
    <section class="py-20 px-4 bg-gradient-to-b from-[#0c0c1e] to-[#1a1a3e]">
        <div class="text-center mb-12 px-2">
            <span class="text-3xl">📸</span>
            <h2 class="font-orbitron text-2xl text-white mt-4">CAPTURED MOMENTS</h2>
        </div>
        
        <div class="columns-2 gap-3 space-y-3">
            @if($wedding->getMedia('gallery')->isNotEmpty())
                @foreach($wedding->getMedia('gallery') as $media)
                <div class="break-inside-avoid galaxy-card p-2">
                    <img src="{{ $media->getUrl() }}" class="w-full rounded-lg">
                </div>
                @endforeach
            @else
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=400', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=400', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=400'] as $placeholder)
                <div class="break-inside-avoid galaxy-card p-2">
                    <img src="{{ $placeholder }}" class="w-full rounded-lg">
                </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- RSVP & QR --}}
    <section class="py-20 px-6" x-data="{ showQr: null }">
        <div class="text-center mb-12">
            <span class="text-3xl">💫</span>
            <h2 class="font-orbitron text-2xl text-white mt-4">GIFT PORTAL</h2>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <button @click="showQr = 'groom'" class="galaxy-card p-6 text-center hover:border-[#22d3ee] transition animate-glow">
                <span class="text-2xl block mb-2">🤵</span>
                <span class="font-orbitron text-sm text-white">NHÀ TRAI</span>
            </button>
            <button @click="showQr = 'bride'" class="galaxy-card p-6 text-center hover:border-[#ec4899] transition animate-glow">
                <span class="text-2xl block mb-2">👰</span>
                <span class="font-orbitron text-sm text-white">NHÀ GÁI</span>
            </button>
        </div>
        
        <!-- QR Modal -->
        <div x-show="showQr" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90" style="display: none;">
            <div class="galaxy-card p-8 w-full max-w-sm text-center" @click.outside="showQr = null">
                <button @click="showQr = null" class="absolute top-4 right-4 text-gray-400 hover:text-white">✕</button>
                <h3 class="font-orbitron text-xl text-white mb-6 neon-text" x-text="showQr === 'groom' ? 'NHÀ TRAI' : 'NHÀ GÁI'"></h3>
                <template x-if="showQr === 'groom'">
                    <div>
                        @if($wedding->getFirstMediaUrl('groom_qr'))
                        <img src="{{ $wedding->getFirstMediaUrl('groom_qr') }}" class="w-48 h-48 mx-auto mb-4 rounded-lg border-2 border-[#22d3ee]">
                        @endif
                        <p class="text-sm text-gray-400">{{ $wedding->groom_qr_info }}</p>
                    </div>
                </template>
                <template x-if="showQr === 'bride'">
                    <div>
                        @if($wedding->getFirstMediaUrl('bride_qr'))
                        <img src="{{ $wedding->getFirstMediaUrl('bride_qr') }}" class="w-48 h-48 mx-auto mb-4 rounded-lg border-2 border-[#ec4899]">
                        @endif
                        <p class="text-sm text-gray-400">{{ $wedding->bride_qr_info }}</p>
                    </div>
                </template>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-20 text-center aurora-bg">
        <div class="text-5xl mb-4 animate-float">🌠</div>
        <h2 class="font-orbitron text-3xl text-white neon-text mb-2">Thank You</h2>
        <p class="font-orbitron text-sm text-[#fbbf24]">{{ $wedding->groom_name }} ✦ {{ $wedding->bride_name }}</p>
        <p class="text-xs text-gray-400 mt-4">To infinity and beyond...</p>
    </footer>
</div>

{{-- RSVP & Guestbook Components --}}
@include('components.wedding.rsvp-form', ['wedding' => $wedding])
@include('components.wedding.guestbook', ['wedding' => $wedding])

<script>
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
