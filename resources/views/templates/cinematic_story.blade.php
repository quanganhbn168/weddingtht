@extends('layouts.app')
{{-- Template Name: Cinematic Story (Phim Điện Ảnh Lãng Mạn) - PREMIUM --}}

@section('title', 'The Story of ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lora:ital,wght@0,400;0,600;1,400&display=swap');
    
    :root {
        --cinema-black: #0a0a0a;
        --cinema-gold: #c9a959;
        --cinema-white: #f5f5f5;
        --cinema-gray: #2a2a2a;
    }

    body { font-family: 'Lora', serif; background: var(--cinema-black); color: var(--cinema-white); }
    .font-bebas { font-family: 'Bebas Neue', cursive; letter-spacing: 0.1em; }
    
    /* Film Grain Effect */
    .film-grain::before {
        content: '';
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        opacity: 0.03;
        pointer-events: none;
        z-index: 1000;
    }
    
    /* Parallax Scroll */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes letterboxReveal { from { height: 100%; } to { height: 0; } }
    @keyframes typewriter { from { width: 0; } to { width: 100%; } }
    @keyframes blink { 50% { opacity: 0; } }
    @keyframes cineFade { 0%, 100% { opacity: 0.7; } 50% { opacity: 1; } }
    
    .animate-fade-up { animation: fadeUp 1s ease-out forwards; opacity: 0; }
    .animate-letterbox { animation: letterboxReveal 1.5s ease-out 0.5s forwards; }
    .animate-typewriter { overflow: hidden; white-space: nowrap; animation: typewriter 2s steps(30) forwards; }
    .animate-cine-fade { animation: cineFade 3s ease-in-out infinite; }
    
    .delay-300 { animation-delay: 0.3s; }
    .delay-500 { animation-delay: 0.5s; }
    .delay-700 { animation-delay: 0.7s; }
    .delay-1000 { animation-delay: 1s; }
    
    /* Letterbox Bars */
    .letterbox-top, .letterbox-bottom {
        position: fixed;
        left: 0; right: 0;
        height: 60px;
        background: black;
        z-index: 100;
    }
    .letterbox-top { top: 0; }
    .letterbox-bottom { bottom: 0; }
    
    /* Cinema Card */
    .cinema-card {
        background: linear-gradient(135deg, rgba(42,42,42,0.9), rgba(10,10,10,0.95));
        border: 1px solid rgba(201,169,89,0.3);
    }
    
    /* Video Overlay */
    .video-overlay {
        background: linear-gradient(to bottom, transparent 0%, var(--cinema-black) 100%);
    }
</style>

<div class="film-grain"></div>

<!-- Letterbox Bars -->
<div class="letterbox-top"></div>
<div class="letterbox-bottom"></div>

<div class="max-w-[480px] mx-auto bg-[#0a0a0a] min-h-screen shadow-2xl relative">
    
    {{-- Pro Features: Preload Animation & Demo Watermark --}}
    @include('components.wedding.preload', ['wedding' => $wedding])
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    @include('components.wedding.upgrade-banner', ['wedding' => $wedding, 'showUpgradeBanner' => $showUpgradeBanner ?? false])
    
    {{-- Music Player --}}
    @if($musicUrl)
    <div x-data="{ playing: false, audio: null }" x-init="audio = new Audio('{{ $musicUrl }}'); audio.loop = true;" class="fixed top-20 right-6 z-50">
        <button @click="playing ? audio.pause() : audio.play(); playing = !playing" 
                class="w-10 h-10 rounded-full bg-black/80 border border-[#c9a959] text-[#c9a959] flex items-center justify-center hover:bg-[#c9a959] hover:text-black transition">
            <template x-if="!playing"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></template>
            <template x-if="playing"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg></template>
        </button>
    </div>
    @endif

    {{-- CINEMATIC OPENING --}}
    <section class="min-h-screen relative flex items-center justify-center overflow-hidden">
        <!-- Hero Video/Image Background -->
        <div class="absolute inset-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-[#0a0a0a]/50"></div>
        </div>
        
        <!-- Film Credits Style -->
        <div class="relative z-10 text-center px-8 py-20">
            <p class="font-bebas text-[#c9a959] text-sm tracking-[0.5em] mb-8 animate-fade-up">A LOVE STORY</p>
            
            <div class="space-y-4 animate-fade-up delay-300">
                <h1 class="font-bebas text-6xl md:text-7xl text-white tracking-wide">{{ strtoupper($wedding->groom_name) }}</h1>
                <div class="flex items-center justify-center gap-6">
                    <div class="w-20 h-[1px] bg-[#c9a959]"></div>
                    <span class="font-bebas text-[#c9a959] text-2xl">&</span>
                    <div class="w-20 h-[1px] bg-[#c9a959]"></div>
                </div>
                <h1 class="font-bebas text-6xl md:text-7xl text-white tracking-wide">{{ strtoupper($wedding->bride_name) }}</h1>
            </div>
            
            <div class="mt-16 animate-fade-up delay-700">
                <p class="font-bebas text-[#c9a959] text-xs tracking-[0.3em] mb-2">COMING</p>
                <p class="font-bebas text-4xl text-white">{{ $wedding->event_date?->format('d . m . Y') }}</p>
                @if($wedding->event_date_lunar)
                <p class="text-sm text-gray-400 italic mt-2">({{ $wedding->event_date_lunar }})</p>
                @endif
            </div>
            
            <!-- Scroll Indicator -->
            <div class="absolute bottom-20 left-1/2 -translate-x-1/2 animate-cine-fade">
                <div class="w-6 h-10 border-2 border-[#c9a959] rounded-full flex justify-center pt-2">
                    <div class="w-1 h-3 bg-[#c9a959] rounded-full animate-bounce"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- CHAPTER: THE PROTAGONISTS --}}
    <section class="py-24 px-6 relative">
        <div class="text-center mb-16 animate-fade-up">
            <p class="font-bebas text-[#c9a959] text-xs tracking-[0.3em]">CHAPTER ONE</p>
            <h2 class="font-bebas text-4xl text-white mt-2">THE PROTAGONISTS</h2>
        </div>
        
        <div class="space-y-20">
            <!-- Groom -->
            <div class="cinema-card rounded-lg overflow-hidden animate-fade-up">
                <div class="aspect-[4/5] relative">
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <p class="font-bebas text-[#c9a959] text-xs tracking-widest mb-1">THE GROOM</p>
                        <h3 class="font-bebas text-3xl text-white">{{ strtoupper($wedding->groom_name) }}</h3>
                        <p class="text-sm text-gray-400 mt-2 italic">"Con ông {{ $wedding->groom_father }} và bà {{ $wedding->groom_mother }}"</p>
                    </div>
                </div>
            </div>
            
            <!-- Bride -->
            <div class="cinema-card rounded-lg overflow-hidden animate-fade-up">
                <div class="aspect-[4/5] relative">
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <p class="font-bebas text-[#c9a959] text-xs tracking-widest mb-1">THE BRIDE</p>
                        <h3 class="font-bebas text-3xl text-white">{{ strtoupper($wedding->bride_name) }}</h3>
                        <p class="text-sm text-gray-400 mt-2 italic">"Con ông {{ $wedding->bride_father }} và bà {{ $wedding->bride_mother }}"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-24 px-6 bg-[#111] border-y border-[#c9a959]/20">
        <div class="text-center mb-12">
            <p class="font-bebas text-[#c9a959] text-xs tracking-[0.3em]">COUNTDOWN TO</p>
            <h2 class="font-bebas text-3xl text-white mt-2">THE BIG PREMIERE</h2>
        </div>
        
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="grid grid-cols-4 gap-3">
            <div class="cinema-card rounded-lg p-4 text-center">
                <span x-text="days" class="font-bebas text-4xl text-[#c9a959] block">00</span>
                <span class="text-xs text-gray-500 uppercase tracking-wider">Days</span>
            </div>
            <div class="cinema-card rounded-lg p-4 text-center">
                <span x-text="hours" class="font-bebas text-4xl text-[#c9a959] block">00</span>
                <span class="text-xs text-gray-500 uppercase tracking-wider">Hours</span>
            </div>
            <div class="cinema-card rounded-lg p-4 text-center">
                <span x-text="minutes" class="font-bebas text-4xl text-[#c9a959] block">00</span>
                <span class="text-xs text-gray-500 uppercase tracking-wider">Mins</span>
            </div>
            <div class="cinema-card rounded-lg p-4 text-center">
                <span x-text="seconds" class="font-bebas text-4xl text-[#c9a959] block">00</span>
                <span class="text-xs text-gray-500 uppercase tracking-wider">Secs</span>
            </div>
        </div>
    </section>
    @endif

    {{-- CHAPTER: THE EVENTS --}}
    <section class="py-24 px-6">
        <div class="text-center mb-16">
            <p class="font-bebas text-[#c9a959] text-xs tracking-[0.3em]">CHAPTER TWO</p>
            <h2 class="font-bebas text-4xl text-white mt-2">SHOWTIMES</h2>
        </div>
        
        <div class="space-y-8">
            <!-- Nhà Gái -->
            <div class="cinema-card rounded-lg p-6">
                <div class="flex items-center gap-4 mb-4 pb-4 border-b border-[#c9a959]/30">
                    <span class="font-bebas text-[#c9a959] text-xl">🎬</span>
                    <h3 class="font-bebas text-xl text-white tracking-wide">NHÀ GÁI - LỄ VU QUY</h3>
                </div>
                <div class="space-y-3 text-gray-300">
                    <p class="flex justify-between"><span class="text-gray-500">Thời gian:</span><span class="font-bebas text-lg">{{ $wedding->bride_ceremony_time ? \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') : '--' }}</span></p>
                    <p class="flex justify-between"><span class="text-gray-500">Địa điểm:</span><span class="text-right text-sm">{{ $wedding->bride_address }}</span></p>
                </div>
                @if($wedding->bride_map_url)
                <a href="{{ $wedding->bride_map_url }}" target="_blank" class="mt-4 inline-block font-bebas text-sm text-[#c9a959] border border-[#c9a959] px-4 py-2 hover:bg-[#c9a959] hover:text-black transition">VIEW LOCATION</a>
                @endif
            </div>
            
            <!-- Nhà Trai -->
            <div class="cinema-card rounded-lg p-6">
                <div class="flex items-center gap-4 mb-4 pb-4 border-b border-[#c9a959]/30">
                    <span class="font-bebas text-[#c9a959] text-xl">🎬</span>
                    <h3 class="font-bebas text-xl text-white tracking-wide">NHÀ TRAI - LỄ THÀNH HÔN</h3>
                </div>
                <div class="space-y-3 text-gray-300">
                    <p class="flex justify-between"><span class="text-gray-500">Thời gian:</span><span class="font-bebas text-lg">{{ $wedding->groom_ceremony_time ? \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') : '--' }}</span></p>
                    <p class="flex justify-between"><span class="text-gray-500">Địa điểm:</span><span class="text-right text-sm">{{ $wedding->groom_address }}</span></p>
                </div>
                @if($wedding->groom_map_url)
                <a href="{{ $wedding->groom_map_url }}" target="_blank" class="mt-4 inline-block font-bebas text-sm text-[#c9a959] border border-[#c9a959] px-4 py-2 hover:bg-[#c9a959] hover:text-black transition">VIEW LOCATION</a>
                @endif
            </div>
        </div>
    </section>

    {{-- GALLERY - Behind The Scenes --}}
    <section class="py-24 px-4 bg-[#111]">
        <div class="text-center mb-12 px-2">
            <p class="font-bebas text-[#c9a959] text-xs tracking-[0.3em]">BONUS FEATURES</p>
            <h2 class="font-bebas text-3xl text-white mt-2">BEHIND THE SCENES</h2>
        </div>
        
        <div class="columns-2 gap-2 space-y-2">
            @if($wedding->getMedia('gallery')->isNotEmpty())
                @foreach($wedding->getMedia('gallery') as $media)
                <div class="break-inside-avoid cinema-card p-1 rounded-lg">
                    <img src="{{ $media->getUrl() }}" class="w-full rounded">
                </div>
                @endforeach
            @else
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=400', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=400', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=400'] as $placeholder)
                <div class="break-inside-avoid cinema-card p-1 rounded-lg">
                    <img src="{{ $placeholder }}" class="w-full rounded">
                </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- RSVP & QR --}}
    <section class="py-24 px-6" x-data="{ showQr: null }">
        <div class="text-center mb-12">
            <p class="font-bebas text-[#c9a959] text-xs tracking-[0.3em]">SPECIAL THANKS</p>
            <h2 class="font-bebas text-3xl text-white mt-2">GIFT BOX</h2>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <button @click="showQr = 'groom'" class="cinema-card rounded-lg p-6 text-center hover:border-[#c9a959] transition">
                <span class="font-bebas text-lg text-white">NHÀ TRAI</span>
            </button>
            <button @click="showQr = 'bride'" class="cinema-card rounded-lg p-6 text-center hover:border-[#c9a959] transition">
                <span class="font-bebas text-lg text-white">NHÀ GÁI</span>
            </button>
        </div>
        
        <!-- QR Modal -->
        <div x-show="showQr" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90" style="display: none;">
            <div class="cinema-card rounded-lg p-8 w-full max-w-sm text-center" @click.outside="showQr = null">
                <button @click="showQr = null" class="absolute top-4 right-4 text-gray-400 hover:text-white">✕</button>
                <h3 class="font-bebas text-2xl text-white mb-6" x-text="showQr === 'groom' ? 'NHÀ TRAI' : 'NHÀ GÁI'"></h3>
                <template x-if="showQr === 'groom'">
                    <div>
                        @if($wedding->getFirstMediaUrl('groom_qr'))
                        <img src="{{ $wedding->getFirstMediaUrl('groom_qr') }}" class="w-48 h-48 mx-auto mb-4 border border-[#c9a959]">
                        @endif
                        <p class="text-sm text-gray-400">{{ $wedding->groom_qr_info }}</p>
                    </div>
                </template>
                <template x-if="showQr === 'bride'">
                    <div>
                        @if($wedding->getFirstMediaUrl('bride_qr'))
                        <img src="{{ $wedding->getFirstMediaUrl('bride_qr') }}" class="w-48 h-48 mx-auto mb-4 border border-[#c9a959]">
                        @endif
                        <p class="text-sm text-gray-400">{{ $wedding->bride_qr_info }}</p>
                    </div>
                </template>
            </div>
        </div>
    </section>

    {{-- END CREDITS --}}
    <footer class="py-24 text-center bg-[#0a0a0a] border-t border-[#c9a959]/20">
        <p class="font-bebas text-[#c9a959] text-xs tracking-[0.3em] mb-4">THE END</p>
        <h2 class="font-bebas text-4xl text-white mb-4">THANK YOU</h2>
        <p class="font-bebas text-lg text-gray-400">FOR BEING PART OF OUR STORY</p>
        <div class="mt-8 pt-8 border-t border-gray-800 mx-12">
            <p class="font-bebas text-sm text-gray-500">{{ strtoupper($wedding->groom_name) }} & {{ strtoupper($wedding->bride_name) }}</p>
        </div>
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
