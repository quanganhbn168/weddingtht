@extends('layouts.app')
{{-- Template Name: Luxury Gold (Vàng Hoàng Gia) --}}

@section('title', 'The Wedding of ' . $wedding->groom_name . ' & ' . $wedding->bride_name)

@section('content')
@section('og_image', $shareUrl)

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Montserrat:wght@300;400&display=swap');
    
    :root {
        --lux-bg: #0f172a; /* Midnight Blue/Black */
        --lux-gold: #d4af37;
        --lux-text: #e2e8f0;
    }

    body { font-family: 'Montserrat', sans-serif; background-color: var(--lux-bg); color: var(--lux-text); }
    h1, h2, h3, .font-cinzel { font-family: 'Cinzel', serif; }

    .text-gold { color: var(--lux-gold); }
    .border-gold { border-color: var(--lux-gold); }
    .bg-gold { background-color: var(--lux-gold); }
    
    .gold-gradient {
        background: linear-gradient(to right, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .frame-corner {
        position: absolute;
        width: 40px;
        height: 40px;
        border: 2px solid var(--lux-gold);
        pointer-events: none;
    }
    .top-left { top: 20px; left: 20px; border-right: none; border-bottom: none; }
    .top-right { top: 20px; right: 20px; border-left: none; border-bottom: none; }
    .bottom-left { bottom: 20px; left: 20px; border-right: none; border-top: none; }
    .bottom-right { bottom: 20px; right: 20px; border-left: none; border-top: none; }
    
    /* Premium Animations */
    @keyframes floatStar { 0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; } 50% { transform: translateY(-12px) scale(1.1); opacity: 1; } }
    @keyframes shimmerGold { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 10px rgba(212,175,55,0.3); } 50% { box-shadow: 0 0 25px rgba(212,175,55,0.6); } }
    @keyframes sparkle { 0%, 100% { opacity: 0; transform: scale(0); } 50% { opacity: 1; transform: scale(1); } }
    
    .animate-float-star { animation: floatStar 4s ease-in-out infinite; }
    .animate-shimmer-gold { background: linear-gradient(90deg, #bf953f, #fcf6ba, #b38728); background-size: 200% 100%; animation: shimmerGold 3s infinite; }
    .animate-fade-up { animation: fadeInUp 0.8s ease-out forwards; }
    .animate-pulse-glow { animation: pulseGlow 2s ease-in-out infinite; }
    
    .delay-200 { animation-delay: 0.2s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-600 { animation-delay: 0.6s; }
    
    /* Floating Stars */
    .floating-star { position: absolute; color: var(--lux-gold); opacity: 0.5; animation: floatStar 5s ease-in-out infinite; pointer-events: none; z-index: 5; }
    
    /* Sparkle Effect */
    .sparkle { position: absolute; width: 4px; height: 4px; background: var(--lux-gold); border-radius: 50%; animation: sparkle 2s ease-in-out infinite; }
    
    /* Hover Effects */
    .hover-glow { transition: all 0.4s ease; }
    .hover-glow:hover { box-shadow: 0 0 30px rgba(212,175,55,0.4); }
</style>

<div class="max-w-[480px] mx-auto bg-[#0f172a] min-h-screen shadow-2xl relative text-slate-200">
    
    {{-- Pro Features: Preload Animation & Falling Effects --}}
    @include('components.wedding.preload', ['wedding' => $wedding])
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    @include('components.wedding.upgrade-banner', ['wedding' => $wedding, 'showUpgradeBanner' => $showUpgradeBanner ?? false])
    
    @if($musicUrl)
    <div x-data="{ playing: false, audio: null }" x-init="audio = new Audio('{{ $musicUrl }}'); audio.loop = true;" class="fixed top-6 right-6 z-50">
        <button @click="playing ? audio.pause() : audio.play(); playing = !playing" class="w-10 h-10 rounded-full border border-[#d4af37] text-[#d4af37] flex items-center justify-center hover:bg-[#d4af37] hover:text-black transition duration-500">
            <template x-if="!playing"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></template>
            <template x-if="playing"><svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg></template>
        </button>
    </div>
    @endif

    {{-- HERO --}}
    <section class="min-h-screen flex flex-col items-center justify-center p-8 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-40">
             <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
             <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/80 to-transparent"></div>
        </div>

        <div class="relative z-10 text-center border border-[#d4af37]/50 p-8 w-full backdrop-blur-sm bg-black/20">
            {{-- Corners --}}
            <div class="frame-corner top-left"></div>
            <div class="frame-corner top-right"></div>
            <div class="frame-corner bottom-left"></div>
            <div class="frame-corner bottom-right"></div>

            <p class="uppercase tracking-[0.3em] text-[10px] text-[#d4af37] mb-6">Trân trọng báo tin</p>
            <h1 class="text-4xl md:text-5xl mb-4 gold-gradient font-bold">{{ $wedding->groom_name }}</h1>
            <div class="flex items-center justify-center gap-4 my-2">
                <div class="h-[1px] w-12 bg-[#d4af37]"></div>
                <span class="font-serif italic text-2xl text-[#d4af37]">&</span>
                <div class="h-[1px] w-12 bg-[#d4af37]"></div>
            </div>
            <h1 class="text-4xl md:text-5xl mb-8 gold-gradient font-bold">{{ $wedding->bride_name }}</h1>
            
            <p class="text-lg mb-2 font-cinzel">{{ $wedding->event_date?->format('F d, Y') }}</p>
            @if($wedding->event_date_lunar)
            <p class="text-sm italic text-gray-400">({{ $wedding->event_date_lunar }})</p>
            @endif
        </div>
        
        <div class="absolute bottom-10 animate-bounce text-[#d4af37]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </div>
    </section>

    {{-- COUPLE --}}
    <section class="py-20 px-6">
        <div class="text-center mb-16">
            <h2 class="font-cinzel text-3xl text-[#d4af37] mb-2">Groom & Bride</h2>
            <div class="w-24 h-1 bg-[#d4af37] mx-auto"></div>
        </div>

        <div class="space-y-16">
            {{-- Groom --}}
             <div class="relative">
                <div class="absolute -top-4 -left-4 w-24 h-24 border-t-2 border-l-2 border-[#d4af37] opacity-50"></div>
                <div class="aspect-[3/4] overflow-hidden border border-[#d4af37]/30">
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                </div>
                <div class="bg-[#0f172a] border border-[#d4af37] p-6 text-center -mt-10 mx-6 relative z-10 shadow-xl shadow-black/50">
                    <h3 class="text-2xl font-cinzel text-white mb-2">{{ $wedding->groom_name }}</h3>
                    <p class="text-[10px] uppercase tracking-widest text-[#d4af37] mb-2">Chú Rể</p>
                    <p class="text-xs text-slate-400">Con ông {{ $wedding->groom_father }}<br>và bà {{ $wedding->groom_mother }}</p>
                </div>
            </div>

            {{-- Bride --}}
             <div class="relative">
                <div class="absolute -bottom-4 -right-4 w-24 h-24 border-b-2 border-r-2 border-[#d4af37] opacity-50"></div>
                <div class="aspect-[3/4] overflow-hidden border border-[#d4af37]/30">
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                </div>
                <div class="bg-[#0f172a] border border-[#d4af37] p-6 text-center -mt-10 mx-6 relative z-10 shadow-xl shadow-black/50">
                    <h3 class="text-2xl font-cinzel text-white mb-2">{{ $wedding->bride_name }}</h3>
                    <p class="text-[10px] uppercase tracking-widest text-[#d4af37] mb-2">Cô Dâu</p>
                    <p class="text-xs text-slate-400">Con ông {{ $wedding->bride_father }}<br>và bà {{ $wedding->bride_mother }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-20 px-6 bg-slate-950 border-y border-[#d4af37]/20">
        <div class="text-center">
            <p class="text-xs uppercase tracking-[0.3em] text-[#d4af37]/70 mb-8">Countdown to the Big Day</p>
            <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="grid grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="border border-[#d4af37]/30 p-4 bg-black/30">
                        <span x-text="days" class="block text-4xl gold-gradient font-cinzel">00</span>
                        <span class="text-[10px] uppercase text-slate-400 tracking-widest">Days</span>
                    </div>
                </div>
                <div class="text-center">
                    <div class="border border-[#d4af37]/30 p-4 bg-black/30">
                        <span x-text="hours" class="block text-4xl gold-gradient font-cinzel">00</span>
                        <span class="text-[10px] uppercase text-slate-400 tracking-widest">Hours</span>
                    </div>
                </div>
                <div class="text-center">
                    <div class="border border-[#d4af37]/30 p-4 bg-black/30">
                        <span x-text="minutes" class="block text-4xl gold-gradient font-cinzel">00</span>
                        <span class="text-[10px] uppercase text-slate-400 tracking-widest">Minutes</span>
                    </div>
                </div>
                <div class="text-center">
                    <div class="border border-[#d4af37]/30 p-4 bg-black/30">
                        <span x-text="seconds" class="block text-4xl gold-gradient font-cinzel">00</span>
                        <span class="text-[10px] uppercase text-slate-400 tracking-widest">Seconds</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- EVENTS --}}
    <section class="py-20 px-6 bg-slate-900 border-y border-[#d4af37]/20">
        <h2 class="text-center font-cinzel text-3xl text-[#d4af37] mb-12">Sự Kiện</h2>
        
        <div class="grid gap-12">
            {{-- Event Card --}}
            @if($wedding->groom_reception_time)
            <div class="border border-[#d4af37]/30 p-8 text-center relative group">
                <div class="rotate-45 w-3 h-3 bg-[#d4af37] absolute -top-1.5 left-1/2 -ml-1.5"></div>
                <h3 class="text-xl uppercase tracking-widest text-white mb-4">Tiệc Nhà Trai</h3>
                <p class="text-3xl text-[#d4af37] font-serif italic mb-2">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}</p>
                <p class="text-sm text-slate-400 mb-6">{{ $wedding->groom_reception_venue }}</p>
                <div class="w-full h-px bg-[#d4af37]/30 my-4"></div>
                <p class="text-xs uppercase tracking-wider text-white">Lễ Thành Hôn</p>
                <p class="text-sm mt-1 text-slate-400">{{ $wedding->groom_address }}</p>
                 @if($wedding->groom_map_url)
                 <a href="{{ $wedding->groom_map_url }}" target="_blank" class="inline-block mt-6 px-6 py-2 border border-[#d4af37] text-[#d4af37] text-xs uppercase hover:bg-[#d4af37] hover:text-[#0f172a] transition">Bản đồ</a>
                 @endif
            </div>
            @endif

            @if($wedding->bride_reception_time)
            <div class="border border-[#d4af37]/30 p-8 text-center relative group">
                <div class="rotate-45 w-3 h-3 bg-[#d4af37] absolute -top-1.5 left-1/2 -ml-1.5"></div>
                <h3 class="text-xl uppercase tracking-widest text-white mb-4">Tiệc Nhà Gái</h3>
                <p class="text-3xl text-[#d4af37] font-serif italic mb-2">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}</p>
                <p class="text-sm text-slate-400 mb-6">{{ $wedding->bride_reception_venue }}</p>
                 <div class="w-full h-px bg-[#d4af37]/30 my-4"></div>
                <p class="text-xs uppercase tracking-wider text-white">Lễ Vu Quy</p>
                <p class="text-sm mt-1 text-slate-400">{{ $wedding->bride_address }}</p>
                @if($wedding->bride_map_url)
                 <a href="{{ $wedding->bride_map_url }}" target="_blank" class="inline-block mt-6 px-6 py-2 border border-[#d4af37] text-[#d4af37] text-xs uppercase hover:bg-[#d4af37] hover:text-[#0f172a] transition">Bản đồ</a>
                 @endif
            </div>
            @endif
        </div>
    </section>

    {{-- GALLERY & RSVP (Combined for simplicity in execution) --}}
    <section class="py-20 px-6 text-center">
        <h2 class="font-cinzel text-3xl text-[#d4af37] mb-8">Album Ảnh</h2>
        <div class="columns-2 gap-2 space-y-2 mb-12">
            @if($wedding->getMedia('gallery')->isNotEmpty())
                @foreach($wedding->getMedia('gallery') as $media)
                <img src="{{ $media->getUrl() }}" class="w-full border border-[#d4af37]/20 rounded-sm">
                @endforeach
            @else
                {{-- Placeholder gallery for demo --}}
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=600', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600', 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600', 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=600'] as $placeholder)
                <img src="{{ $placeholder }}" class="w-full border border-[#d4af37]/20 rounded-sm">
                @endforeach
            @endif
        </div>

        <div class="bg-gradient-to-br from-slate-900 to-slate-800 border border-[#d4af37] p-8 mt-12">
            <h3 class="text-2xl font-cinzel text-white mb-8">Gửi Lời Chúc</h3>
            <div class="flex gap-4 justify-center mb-8">
                @if($wedding->getFirstMediaUrl('groom_qr'))
                <div class="text-center">
                    <img src="{{ $wedding->getFirstMediaUrl('groom_qr') }}" class="w-32 h-32 mx-auto mb-2 border-2 border-[#d4af37]">
                    <p class="text-[10px] uppercase text-[#d4af37]">Nhà Trai</p>
                </div>
                @endif
                @if($wedding->getFirstMediaUrl('bride_qr'))
                <div class="text-center">
                    <img src="{{ $wedding->getFirstMediaUrl('bride_qr') }}" class="w-32 h-32 mx-auto mb-2 border-2 border-[#d4af37]">
                     <p class="text-[10px] uppercase text-[#d4af37]">Nhà Gái</p>
                </div>
                @endif
            </div>
            <p class="text-sm text-slate-400">Rất mong sự hiện diện của quý khách!</p>
        </div>
    </section>

    <footer class="py-10 text-center border-t border-[#d4af37]/10">
        <h2 class="gold-gradient font-cinzel text-2xl">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</h2>
    </footer>
</div>

@push('scripts')
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
@endpush
@endsection
