@extends('layouts.app')
{{-- Template Name: Luxury Gold (Vàng Hoàng Gia) --}}

@section('title', 'The Wedding of ' . $wedding->groom_name . ' & ' . $wedding->bride_name)

@section('content')
@php
    $coverUrl = $wedding->getFirstMediaUrl('cover') ?: 'https://images.unsplash.com/photo-1511285560982-1351cdeb9821?w=1920&q=80';
    $groomPhoto = $wedding->getFirstMediaUrl('groom_photo') ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&fit=crop';
    $bridePhoto = $wedding->getFirstMediaUrl('bride_photo') ?: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=800&fit=crop';
    $musicUrl = $wedding->background_music ? asset('storage/' . $wedding->background_music) : null;
@endphp

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
</style>

<div class="max-w-[480px] mx-auto bg-[#0f172a] min-h-screen shadow-2xl relative text-slate-200">
    
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
             <img src="{{ $coverUrl }}" class="w-full h-full object-cover">
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
        @if($wedding->getMedia('gallery')->isNotEmpty())
        <div class="columns-2 gap-2 space-y-2 mb-12">
            @foreach($wedding->getMedia('gallery') as $media)
            <img src="{{ $media->getUrl() }}" class="w-full border border-[#d4af37]/20 rounded-sm">
            @endforeach
        </div>
        @endif

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
@endsection
