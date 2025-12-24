@extends('layouts.app')
{{-- Template Name: Traditional Red (Đỏ Truyền Thống) --}}

@section('title', 'Lễ Cưới ' . $wedding->groom_name . ' & ' . $wedding->bride_name)

@section('content')
@php
    $coverUrl = $wedding->getFirstMediaUrl('cover') ?: 'https://images.unsplash.com/photo-1545652034-7870e28f244b?w=1920&q=80';
    $groomPhoto = $wedding->getFirstMediaUrl('groom_photo') ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&fit=crop';
    $bridePhoto = $wedding->getFirstMediaUrl('bride_photo') ?: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=800&fit=crop';
    $musicUrl = $wedding->background_music ? asset('storage/' . $wedding->background_music) : null;
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Be+Vietnam+Pro:wght@300;400;600&family=Pinyon+Script&display=swap');
    
    :root {
        --red-pri: #8a1c1c; 
        --red-dark: #5c0f0f;
        --gold-pri: #dfb968;
        --gold-light: #f6e3ba;
    }

    body { font-family: 'Be Vietnam Pro', sans-serif; background-color: var(--red-pri); color: var(--gold-pri); }
    .font-playfair { font-family: 'Playfair Display', serif; }
    .font-script { font-family: 'Pinyon Script', cursive; }

    /* Traditional Pattern Background */
    .bg-pattern {
        background-color: var(--red-pri);
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0c0 16.569-13.431 30-30 30 16.569 0 30 13.431 30 30 0-16.569 13.431-30 30-30C43.431 30 30 16.569 30 0z' fill='%235c0f0f' fill-opacity='0.4' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    /* Gradient Text */
    .text-gradient-gold {
        background: linear-gradient(to bottom, #f6e3ba, #dfb968, #b08d45);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Cloud Border Top/Bottom */
    .cloud-border-y {
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='20' viewBox='0 0 100 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 20h100v-10c-10 0-20-5-30-5s-20 5-30 5-20-5-30-5-20 10-10 10z' fill='%23dfb968' fill-opacity='0.2'/%3E%3C/svg%3E");
        height: 20px;
        width: 100%;
        background-repeat: repeat-x;
    }
</style>

<div class="max-w-[480px] mx-auto bg-pattern min-h-screen shadow-2xl relative overflow-hidden border-x border-[#5c0f0f]">
    
    @if($musicUrl)
    <div x-data="{ playing: false, audio: null }" x-init="audio = new Audio('{{ $musicUrl }}'); audio.loop = true;" class="fixed top-6 right-6 z-50">
        <button @click="playing ? audio.pause() : audio.play(); playing = !playing" class="w-10 h-10 rounded-full border border-[#gold-pri] bg-[#8a1c1c]/80 text-[#gold-pri] flex items-center justify-center shadow-lg backdrop-blur-sm">
            <template x-if="!playing"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></template>
            <template x-if="playing"><svg class="w-5 h-5 animate-spin" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg></template>
        </button>
    </div>
    @endif

    {{-- HEADER --}}
    <section class="relative pt-12 pb-20 px-6 text-center">
        <div class="absolute top-0 left-0 w-full cloud-border-y transform rotate-180"></div>
        
        {{-- DOUBLE HAPPINESS (Song Hỷ) --}}
        <div class="w-20 h-20 mx-auto mb-6 border-2 border-[#dfb968] rounded-full flex items-center justify-center p-1 bg-[#5c0f0f]">
            <div class="w-full h-full border border-[#dfb968] rounded-full flex items-center justify-center">
                <span class="text-4xl font-serif text-[#dfb968] leading-none pt-1">囍</span>
            </div>
        </div>

        <p class="text-xs uppercase tracking-[0.2em] text-[#f6e3ba] mb-4 opacity-80">Save The Date</p>
        
        <h1 class="text-4xl font-playfair font-bold text-gradient-gold mb-2">{{ $wedding->groom_name }}</h1>
        <div class="flex items-center justify-center gap-4 my-2 opacity-60">
            <div class="h-px w-8 bg-[#dfb968]"></div>
            <span class="font-script text-2xl text-[#f6e3ba]">&</span>
            <div class="h-px w-8 bg-[#dfb968]"></div>
        </div>
        <h1 class="text-4xl font-playfair font-bold text-gradient-gold mb-8">{{ $wedding->bride_name }}</h1>

        <div class="inline-block border-y border-[#dfb968]/50 py-2 px-8">
            <p class="text-xl font-playfair text-[#f6e3ba]">{{ $wedding->event_date?->format('d | m | Y') }}</p>
        </div>
        @if($wedding->event_date_lunar)
        <p class="text-xs mt-2 text-[#dfb968]/70 italic">Tức ngày {{ $wedding->event_date_lunar }} âm lịch</p>
        @endif
    </section>

    {{-- HERO IMAGE --}}
    <div class="relative h-[50vh] overflow-hidden">
        <img src="{{ $coverUrl }}" class="w-full h-full object-cover">
        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-[#8a1c1c] to-transparent"></div>
        <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-[#8a1c1c] to-transparent"></div>
    </div>

    {{-- COUPLE SECTION --}}
    <section class="py-20 px-6 relative">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[80%] border border-[#dfb968]/10 rounded-[50%] -rotate-12 pointer-events-none"></div>
        
        <div class="grid gap-16 relative z-10">
            {{-- Groom --}}
            <div class="flex flex-col items-center">
                <div class="relative w-48 aspect-[3/4] mb-6">
                    <div class="absolute inset-0 border-2 border-[#dfb968] animate-spin-slow rounded-[2rem]" style="animation-duration: 20s"></div>
                    <div class="absolute inset-2 overflow-hidden border-2 border-[#5c0f0f] rounded-[1.5rem]">
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <h3 class="text-2xl font-playfair font-bold text-[#f6e3ba] mb-1">Nhà Trai</h3>
                <p class="text-lg mb-2">{{ $wedding->groom_name }}</p>
                <p class="text-xs text-[#dfb968]/70">Con ông {{ $wedding->groom_father }}<br>Con bà {{ $wedding->groom_mother }}</p>
            </div>

            {{-- Bride --}}
             <div class="flex flex-col items-center">
                <div class="relative w-48 aspect-[3/4] mb-6">
                    <div class="absolute inset-0 border-2 border-[#dfb968] animate-spin-slow rounded-[2rem]" style="animation-duration: 20s; animation-direction: reverse;"></div>
                    <div class="absolute inset-2 overflow-hidden border-2 border-[#5c0f0f] rounded-[1.5rem]">
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <h3 class="text-2xl font-playfair font-bold text-[#f6e3ba] mb-1">Nhà Gái</h3>
                <p class="text-lg mb-2">{{ $wedding->bride_name }}</p>
                <p class="text-xs text-[#dfb968]/70">Con ông {{ $wedding->bride_father }}<br>Con bà {{ $wedding->bride_mother }}</p>
            </div>
        </div>
    </section>

    {{-- INVITATION --}}
    <section class="py-20 px-4">
        <div class="bg-[#5c0f0f]/40 border border-[#dfb968]/30 p-8 backdrop-blur-sm rounded-lg relative">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#8a1c1c] px-4">
                <h2 class="font-playfair text-2xl text-gradient-gold">Cung Thỉnh</h2>
            </div>

            <div class="space-y-10 mt-4">
                {{-- Nhà Gái --}}
                <div class="text-center">
                    <h3 class="text-[#dfb968] font-bold uppercase tracking-widest text-xs mb-4">Lễ Vu Quy (Nhà Gái)</h3>
                    <div class="flex justify-center items-baseline gap-2 mb-2">
                        <span class="text-3xl font-playfair text-white">{{ \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') }}</span>
                    </div>
                    <p class="text-[#f6e3ba]/80 text-sm mb-4">{{ $wedding->bride_address }}</p>
                    @if($wedding->bride_reception_time)
                    <div class="border-t border-[#dfb968]/20 pt-4 mt-4">
                        <p class="text-xs text-[#dfb968]">Tiệc rượu lúc: <strong>{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}</strong></p>
                        <p class="text-xs text-[#dfb968] mt-1">Tại: {{ $wedding->bride_reception_venue }}</p>
                    </div>
                    @endif
                </div>

                <div class="w-full h-px bg-gradient-to-r from-transparent via-[#dfb968]/50 to-transparent"></div>

                {{-- Nhà Trai --}}
                <div class="text-center">
                    <h3 class="text-[#dfb968] font-bold uppercase tracking-widest text-xs mb-4">Lễ Thành Hôn (Nhà Trai)</h3>
                    <div class="flex justify-center items-baseline gap-2 mb-2">
                        <span class="text-3xl font-playfair text-white">{{ \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') }}</span>
                    </div>
                    <p class="text-[#f6e3ba]/80 text-sm mb-4">{{ $wedding->groom_address }}</p>
                    @if($wedding->groom_reception_time)
                    <div class="border-t border-[#dfb968]/20 pt-4 mt-4">
                        <p class="text-xs text-[#dfb968]">Tiệc rượu lúc: <strong>{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}</strong></p>
                         <p class="text-xs text-[#dfb968] mt-1">Tại: {{ $wedding->groom_reception_venue }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    @if($wedding->getMedia('gallery')->isNotEmpty())
    <section class="py-16 px-4">
        <h2 class="text-center font-script text-4xl text-gradient-gold mb-10">Khoảnh Khắc Hạnh Phúc</h2>
        <div class="columns-2 gap-3 space-y-3">
             @foreach($wedding->getMedia('gallery') as $media)
            <div class="break-inside-avoid border border-[#dfb968]/30 p-1 bg-[#5c0f0f]/30">
                <img src="{{ $media->getUrl() }}" class="w-full shadow-lg">
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- FOOTER --}}
    <footer class="py-12 bg-[#5c0f0f] text-center border-t border-[#dfb968]/20 relative">
        <div class="absolute top-0 left-0 w-full cloud-border-y"></div>
        <div class="mt-8">
            <span class="text-4xl text-[#dfb968] opacity-50 block mb-2">囍</span>
             <p class="font-playfair text-[#f6e3ba] text-lg">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</p>
             <p class="text-[10px] uppercase text-[#dfb968]/60 mt-2 tracking-widest">Cảm ơn đã chúc phúc</p>
        </div>
    </footer>
</div>
@endsection
