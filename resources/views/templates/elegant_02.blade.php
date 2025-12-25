@extends('layouts.app')
{{-- Template Name: Royal Fine Art (Sang Trọng Cổ Điển) --}}

@section('title', 'The Wedding of ' . $wedding->groom_name . ' & ' . $wedding->bride_name)

@section('content')

@section('og_image', $shareUrl)

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Great+Vibes&display=swap');
    
    :root {
        --paper-bg: #f9f7f2;
        --ink-color: #4a403a;
        --gold-accent: #c0a062;
    }

    body { font-family: 'Cormorant Garamond', serif; background-color: var(--paper-bg); color: var(--ink-color); }
    h1, h2, h3 { font-weight: 400; }
    .font-script { font-family: 'Great Vibes', cursive; }

    /* Classic Double Border */
    .royal-border {
        border: 1px solid var(--gold-accent);
        padding: 4px;
        position: relative;
    }
    .royal-border::before {
        content: '';
        position: absolute;
        top: -6px; left: -6px; right: -6px; bottom: -6px;
        border: 1px solid var(--gold-accent);
        opacity: 0.5;
        pointer-events: none;
    }

    /* Paper Texture Overlay (Lightweight) */
    .bg-texture {
        background-color: #f9f7f2;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%239C92AC' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .divider-h {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 2rem 0;
        color: var(--gold-accent);
    }
    .divider-h::before, .divider-h::after {
        content: '';
        flex: 1;
        height: 1px;
        background: currentColor;
        margin: 0 1rem;
        opacity: 0.5;
    }
    .divider-h span {  font-size: 1.5rem; }

</style>

<div class="max-w-[480px] mx-auto bg-texture min-h-screen shadow-2xl relative border-x-[12px] border-[#f2ece4] text-[#4a403a]">
    
    @if($musicUrl)
    <div x-data="{ playing: false, audio: null }" x-init="audio = new Audio('{{ $musicUrl }}'); audio.loop = true;" class="fixed top-6 right-6 z-50">
        <button @click="playing ? audio.pause() : audio.play(); playing = !playing" class="w-10 h-10 rounded-full border border-[#c0a062] bg-[#f9f7f2] text-[#c0a062] flex items-center justify-center hover:bg-[#c0a062] hover:text-white transition duration-500">
            <template x-if="!playing"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></template>
            <template x-if="playing"><svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg></template>
        </button>
    </div>
    @endif

    {{-- HERO --}}
    <section class="min-h-screen flex flex-col justify-center items-center p-8 text-center relative">
        <div class="absolute inset-0 top-0 h-2/3 z-0">
             <img src="{{ $heroUrl }}" class="w-full h-full object-cover opacity-100 mask-image-gradient-b">
             <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-[#f9f7f2]"></div>
        </div>

        <div class="relative z-10 w-full mt-auto bg-white/80 backdrop-blur-[2px] p-8 shadow-sm royal-border">
            <p class="uppercase tracking-[0.3em] text-xs text-[#c0a062] mb-4">The Wedding Of</p>
            <h1 class="text-5xl mb-2">{{ $wedding->groom_name }}</h1>
            <span class="font-script text-4xl text-[#c0a062] block my-2">&</span>
            <h1 class="text-5xl mb-8">{{ $wedding->bride_name }}</h1>
            
            <div class="w-24 h-[1px] bg-[#c0a062] mx-auto mb-4 opacity-50"></div>
            <p class="text-xl italic">{{ $wedding->event_date?->format('l, F d, Y') }}</p>
            @if($wedding->event_date_lunar)
            <p class="text-sm italic text-gray-500 mt-1">({{ $wedding->event_date_lunar }})</p>
            @endif
        </div>
    </section>

    {{-- QUOTE --}}
    <section class="py-20 px-8 text-center">
        <span class="text-6xl text-[#c0a062] opacity-30 block font-serif">“</span>
        <p class="text-2xl font-script leading-relaxed text-[#5d544f] -mt-4">
             Yêu nhau không phải là nhìn nhau, mà là cùng nhau nhìn về một hướng.
        </p>
        <div class="divider-h"><span>❦</span></div>
    </section>

    {{-- COUPLE --}}
    <section class="py-12 px-6">
        <div class="space-y-16">
            {{-- Groom --}}
            <div class="text-center">
                <div class="w-48 h-64 mx-auto mb-6 p-2 border border-[#c0a062] bg-white shadow-lg rotate-1">
                    {{-- Full Color --}}
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                </div>
                <h3 class="text-3xl mb-1">{{ $wedding->groom_name }}</h3>
                <p class="text-[#c0a062] text-xs uppercase tracking-widest mb-4">The Groom</p>
                <p class="text-sm italic text-gray-600">Con ông {{ $wedding->groom_father }} & bà {{ $wedding->groom_mother }}</p>
            </div>

            {{-- Bride --}}
             <div class="text-center">
                <div class="w-48 h-64 mx-auto mb-6 p-2 border border-[#c0a062] bg-white shadow-lg -rotate-1">
                    {{-- Full Color --}}
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                </div>
                <h3 class="text-3xl mb-1">{{ $wedding->bride_name }}</h3>
                 <p class="text-[#c0a062] text-xs uppercase tracking-widest mb-4">The Bride</p>
                <p class="text-sm italic text-gray-600">Con ông {{ $wedding->bride_father }} & bà {{ $wedding->bride_mother }}</p>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-20 px-6 bg-[#f2ece4] text-center border-y border-[#e6dfd5]">
        <h2 class="text-3xl mb-8 italic">Save the Date</h2>
        <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="flex justify-center gap-8 font-serif">
            <div>
                <span x-text="days" class="text-4xl block"></span>
                <span class="text-xs uppercase tracking-widest text-[#c0a062]">Days</span>
            </div>
            <div>
                <span x-text="hours" class="text-4xl block"></span>
                <span class="text-xs uppercase tracking-widest text-[#c0a062]">Hours</span>
            </div>
            <div>
                <span x-text="minutes" class="text-4xl block"></span>
                <span class="text-xs uppercase tracking-widest text-[#c0a062]">Mins</span>
            </div>
        </div>
    </section>
    @endif

    {{-- EVENTS --}}
    <section class="py-24 px-6">
        <h2 class="text-center text-4xl mb-12 font-script text-[#c0a062]">Trân trọng kính mời</h2>

        <div class="space-y-12">
            {{-- Card Nhà Gái --}}
            <div class="bg-white p-8 shadow-lg border-t-4 border-[#c0a062] relative">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4">
                     <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#c0a062]">Nhà Gái</span>
                </div>
                
                <div class="text-center space-y-6">
                    @if($wedding->bride_reception_time)
                    <div>
                         <p class="font-bold text-lg mb-1">Tiệc Cưới</p>
                         <p class="text-3xl italic text-[#4a403a]">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}</p>
                         <p class="text-sm text-gray-500 mt-2">{{ $wedding->bride_reception_venue }}</p>
                    </div>
                    <div class="w-12 h-px bg-gray-200 mx-auto"></div>
                    @endif

                    <div>
                        <p class="font-bold text-lg mb-1">Lễ Vu Quy</p>
                         <p class="text-3xl italic text-[#4a403a] mb-2">{{ $wedding->bride_ceremony_time ? \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') : '--' }}</p>
                         <p class="text-sm font-bold uppercase tracking-widest text-gray-400">{{ $wedding->bride_ceremony_date ? \Carbon\Carbon::parse($wedding->bride_ceremony_date)->format('d . m . Y') : '' }}</p>
                         <p class="text-sm text-gray-500 mt-4">{{ $wedding->bride_address }}</p>
                         @if($wedding->bride_map_url)
                         <a href="{{ $wedding->bride_map_url }}" target="_blank" class="inline-block mt-4 text-[#c0a062] border-b border-[#c0a062] text-xs uppercase pb-1 tracking-widest hover:text-[#4a403a] transition">Xem Bản Đồ</a>
                         @endif
                    </div>
                </div>
            </div>

            {{-- Card Nhà Trai --}}
            <div class="bg-white p-8 shadow-lg border-t-4 border-[#c0a062] relative">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4">
                     <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#c0a062]">Nhà Trai</span>
                </div>
                
                <div class="text-center space-y-6">
                    @if($wedding->groom_reception_time)
                    <div>
                         <p class="font-bold text-lg mb-1">Tiệc Cưới</p>
                         <p class="text-3xl italic text-[#4a403a]">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}</p>
                         <p class="text-sm text-gray-500 mt-2">{{ $wedding->groom_reception_venue }}</p>
                    </div>
                    <div class="w-12 h-px bg-gray-200 mx-auto"></div>
                    @endif

                    <div>
                        <p class="font-bold text-lg mb-1">Lễ Thành Hôn</p>
                         <p class="text-3xl italic text-[#4a403a] mb-2">{{ $wedding->groom_ceremony_time ? \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') : '--' }}</p>
                         <p class="text-sm font-bold uppercase tracking-widest text-gray-400">{{ $wedding->groom_ceremony_date ? \Carbon\Carbon::parse($wedding->groom_ceremony_date)->format('d . m . Y') : '' }}</p>
                         <p class="text-sm text-gray-500 mt-4">{{ $wedding->groom_address }}</p>
                         @if($wedding->groom_map_url)
                         <a href="{{ $wedding->groom_map_url }}" target="_blank" class="inline-block mt-4 text-[#c0a062] border-b border-[#c0a062] text-xs uppercase pb-1 tracking-widest hover:text-[#4a403a] transition">Xem Bản Đồ</a>
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RSVP & WISHES --}}
    <section class="py-24 px-6 bg-[#eae4dc]" x-data="{ showQr: null, showWishes: false }">
        <div class="bg-[#f9f7f2] p-8 border border-[#d8d0c5] text-center shadow-2xl relative">
            <div class="absolute top-4 left-4 border-t border-l border-[#c0a062] w-8 h-8"></div>
            <div class="absolute top-4 right-4 border-t border-r border-[#c0a062] w-8 h-8"></div>
            <div class="absolute bottom-4 left-4 border-b border-l border-[#c0a062] w-8 h-8"></div>
            <div class="absolute bottom-4 right-4 border-b border-r border-[#c0a062] w-8 h-8"></div>
            
            <h2 class="text-3xl font-script mb-8 text-[#c0a062]">Hộp Mừng Cưới</h2>
            
            <div class="flex justify-center gap-4 mb-8">
                <button @click="showQr = 'groom'" class="bg-white border border-[#eae4dc] py-3 px-6 text-sm uppercase tracking-widest hover:bg-[#c0a062] hover:text-white transition">Nhà Trai</button>
                <button @click="showQr = 'bride'" class="bg-white border border-[#eae4dc] py-3 px-6 text-sm uppercase tracking-widest hover:bg-[#c0a062] hover:text-white transition">Nhà Gái</button>
            </div>

            <button @click="showWishes = true" class="w-full bg-[#4a403a] text-white py-4 uppercase tracking-[0.2em] text-xs hover:opacity-90 transition">Gửi Lời Chúc</button>
        </div>

        {{-- Modals clean --}}
        <div x-show="showWishes" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-[#4a403a]/90" style="display: none;">
             <div class="bg-[#f9f7f2] w-full max-w-md p-8 shadow-2xl relative border-4 border-double border-[#d8d0c5]" @click.outside="showWishes = false">
                 <button @click="showWishes = false" class="absolute top-2 right-4 text-2xl text-[#c0a062]">&times;</button>
                <h3 class="text-center text-3xl font-script mb-8 text-[#4a403a]">Lời Chúc Phúc</h3>
                <form class="space-y-6">
                    <input type="text" placeholder="Tên của bạn" class="w-full bg-transparent border-b border-[#c0a062] py-3 text-lg outline-none placeholder:text-[#d8d0c5]">
                    <textarea rows="4" placeholder="Lời nhắn gửi..." class="w-full bg-transparent border-b border-[#c0a062] py-3 text-lg outline-none placeholder:text-[#d8d0c5]"></textarea>
                    <button type="submit" class="w-full bg-[#c0a062] text-white py-4 text-xs uppercase tracking-widest hover:bg-[#a68b55]">Gửi Lời Chúc</button>
                </form>
             </div>
        </div>

        <div x-show="showQr" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-[#4a403a]/90" style="display: none;">
            <div class="bg-[#f9f7f2] w-full max-w-sm p-8 text-center relative border-4 border-double border-[#d8d0c5]" @click.outside="showQr = null">
                 <button @click="showQr = null" class="absolute top-2 right-4 text-2xl text-[#c0a062]">&times;</button>
                <h3 class="text-xl font-bold uppercase tracking-widest mb-8 text-[#c0a062]" x-text="showQr === 'groom' ? 'Nhà Trai' : 'Nhà Gái'"></h3>
                <template x-if="showQr === 'groom'">
                    <div>
                         @if($wedding->getFirstMediaUrl('groom_qr'))
                            <img src="{{ $wedding->getFirstMediaUrl('groom_qr') }}" class="w-48 h-48 mx-auto mb-6 p-2 bg-white border border-[#eae4dc]">
                        @endif
                        <p class="font-serif italic text-gray-500">{{ $wedding->groom_qr_info }}</p>
                    </div>
                </template>
                <template x-if="showQr === 'bride'">
                    <div>
                         @if($wedding->getFirstMediaUrl('bride_qr'))
                            <img src="{{ $wedding->getFirstMediaUrl('bride_qr') }}" class="w-48 h-48 mx-auto mb-6 p-2 bg-white border border-[#eae4dc]">
                        @endif
                         <p class="font-serif italic text-gray-500">{{ $wedding->bride_qr_info }}</p>
                    </div>
                </template>
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    <section class="py-24 px-4 bg-white">
        <h2 class="text-center text-4xl font-script mb-12 text-[#c0a062]">Những Khoảnh Khắc Đẹp</h2>
        <div class="columns-2 gap-4 space-y-4">
            @if($wedding->getMedia('gallery')->isNotEmpty())
                @foreach($wedding->getMedia('gallery') as $media)
                <div class="break-inside-avoid p-2 bg-white border border-[#eae4dc] shadow-md">
                    <img src="{{ $media->getUrl() }}" class="w-full h-auto">
                </div>
                @endforeach
            @else
                {{-- Placeholder gallery for demo --}}
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=600', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600', 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600', 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=600'] as $placeholder)
                <div class="break-inside-avoid p-2 bg-white border border-[#eae4dc] shadow-md">
                    <img src="{{ $placeholder }}" class="w-full h-auto">
                </div>
                @endforeach
            @endif
        </div>
    </section>

    <footer class="py-16 text-center bg-[#f9f7f2] border-t border-[#eae4dc]">
        <h2 class="font-script text-5xl mb-4 text-[#c0a062]">Thank You</h2>
        <p class="uppercase tracking-widest text-xs">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</p>
    </footer>
</div>

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
