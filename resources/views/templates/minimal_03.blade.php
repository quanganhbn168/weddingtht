@extends('layouts.app')
{{-- Template Name: Editorial Magazine (Tạp Chí Thời Trang) --}}

@section('title', 'The Union | ' . $wedding->groom_name . ' & ' . $wedding->bride_name)

@section('content')
@section('og_image', $shareUrl)

<style>
    @import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400;500&display=swap');
    
    :root {
        --bg-color: #f4f4f0;
        --text-color: #1a1a1a;
        --accent-color: #8c8c88;
    }

    body { font-family: 'Jost', sans-serif; background-color: var(--bg-color); color: var(--text-color); }
    h1, h2, h3, .font-display { font-family: 'Italiana', serif; }

    .tracking-widest-xl { letter-spacing: 0.3em; }
    
    /* Editorial Grid Layout */
    .editorial-grid {
        display: grid;
        grid-template-columns: 1fr 11fr;
        gap: 1rem;
    }
    .vertical-text {
        writing-mode: vertical-rl;
        transform: rotate(180deg);
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-size: 10px;
        color: var(--accent-color);
        border-left: 1px solid #e0e0e0;
        padding-left: 10px;
        height: 100%;
        display: flex;
        align-items: center;
    }
</style>

<div class="max-w-[480px] mx-auto bg-[#fdfdfd] min-h-screen shadow-xl relative text-[#1a1a1a]">

    {{-- Music --}}
    @if($musicUrl)
    <div x-data="{ playing: false, audio: null }" x-init="audio = new Audio('{{ $musicUrl }}'); audio.loop = true;" class="fixed top-8 right-8 z-50 mixture-blend-difference">
        <button @click="playing ? audio.pause() : audio.play(); playing = !playing" class="w-8 h-8 flex items-center justify-center text-[#1a1a1a] opacity-80 hover:opacity-100 transition">
            <template x-if="!playing"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></template>
            <template x-if="playing"><svg class="w-6 h-6 animate-spin-slow" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg></template>
        </button>
    </div>
    @endif

    {{-- MAGAZINE COVER HERO --}}
    <section class="h-screen relative flex flex-col justify-between p-6 bg-[#f4f4f0]">
        <div class="flex justify-between items-start pt-4 border-b border-black/10 pb-4">
            <span class="text-[10px] uppercase tracking-widest font-bold">Volume. 01</span>
            <span class="text-[10px] uppercase tracking-widest font-bold">The Wedding Edition</span>
            <span class="text-[10px] uppercase tracking-widest font-bold">{{ now()->year }}</span>
        </div>

        <div class="absolute inset-0 top-32 bottom-24 mx-6 z-0">
             <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
        </div>

        <div class="relative z-10 text-center mt-auto mb-12 bg-white/95 backdrop-blur-sm p-8 mx-4 shadow-sm border border-black/5">
            <h1 class="text-5xl md:text-6xl uppercase tracking-tighter leading-[0.9] mb-4 text-black">
                {{ $wedding->groom_name }} <br> 
                <span class="text-4xl italic lowercase font-serif text-[#666]">&</span> <br>
                {{ $wedding->bride_name }}
            </h1>
            <p class="text-xs uppercase tracking-[0.4em] font-medium mt-6 text-black">Save The Date</p>
            <p class="text-lg font-display mt-2 text-black">{{ $wedding->event_date?->format('F d, Y') }}</p>
        </div>
    </section>

    {{-- EDITORIAL COUPLE --}}
    <section class="py-24 px-6">
        <div class="mb-16">
            <h2 class="text-8xl font-display opacity-5 absolute -left-4 pointer-events-none">Love</h2>
            <p class="text-[10px] uppercase tracking-[0.3em] font-bold border-l-2 border-black pl-3 ml-2">The Protagonists</p>
        </div>

        <div class="space-y-20">
            {{-- GROOM --}}
            <div class="editorial-grid">
                <div class="vertical-text">The Groom</div>
                <div>
                    <div class="w-full aspect-[3/4] overflow-hidden mb-4 relative">
                        {{-- No Grayscale, No contrast filter --}}
                        <img src="{{ $groomPhoto }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 right-0 bg-white px-4 py-2 border border-gray-100">
                             <h3 class="text-2xl font-display text-black">{{ $wedding->groom_name }}</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed pl-4 border-l border-gray-200">
                        "Là một người đàn ông của gia đình, anh luôn tâm niệm rằng hạnh phúc không phải là những điều to lớn, mà là những khoảnh khắc bình yên bên người mình yêu."
                    </p>
                </div>
            </div>

            {{-- BRIDE --}}
            <div class="editorial-grid" style="grid-template-columns: 11fr 1fr;">
                <div class="text-right">
                    <div class="w-full aspect-[3/4] overflow-hidden mb-4 relative">
                         {{-- No Grayscale, No contrast filter --}}
                        <img src="{{ $bridePhoto }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 bg-white px-4 py-2 border border-gray-100">
                             <h3 class="text-2xl font-display text-black">{{ $wedding->bride_name }}</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed pr-4 border-r border-gray-200 inline-block text-right">
                        "Em không cần một câu chuyện cổ tích, em chỉ cần một hiện thực mà ở đó có anh cùng em đi qua những tháng năm."
                    </p>
                </div>
                <div class="vertical-text" style="writing-mode: vertical-lr; transform: none; border-left: none; border-right: 1px solid #e0e0e0; padding-left: 0; padding-right: 10px;">The Bride</div>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN TYPOGRAPHY --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-24 px-6 bg-[#1a1a1a] text-[#f4f4f0] overflow-hidden relative">
        <h2 class="text-[120px] leading-none font-display opacity-10 absolute -top-10 -right-20 pointer-events-none whitespace-nowrap">Forever</h2>
        
        <div class="relative z-10">
            <p class="text-xs uppercase tracking-[0.4em] mb-12 border-b border-gray-700 pb-4 inline-block">Countdown To Eternity</p>
            <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="flex flex-col gap-8">
                <div class="flex items-baseline justify-between border-b border-gray-800 pb-2">
                    <span class="text-xs uppercase tracking-widest text-gray-500">Days Remaining</span>
                    <span x-text="days" class="text-6xl font-display"></span>
                </div>
                <div class="flex items-baseline justify-between border-b border-gray-800 pb-2">
                    <span class="text-xs uppercase tracking-widest text-gray-500">Hours</span>
                    <span x-text="hours" class="text-6xl font-display"></span>
                </div>
                <div class="flex items-baseline justify-between border-b border-gray-800 pb-2">
                    <span class="text-xs uppercase tracking-widest text-gray-500">Minutes</span>
                    <span x-text="minutes" class="text-6xl font-display"></span>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- EVENTS MINIMAL LIST --}}
    <section class="py-24 px-6 bg-[#fdfdfd]">
        <div class="mb-16 text-center">
            <h2 class="text-4xl font-display mb-2 text-black">The Timeline</h2>
            <p class="text-[10px] uppercase tracking-widest text-gray-400">Save these moments</p>
        </div>

        <div class="space-y-16 max-w-sm mx-auto">
            {{-- NHÀ GÁI --}}
            <div class="block"> {{-- Removed group/hover --}}
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-4xl font-display text-black">01.</span>
                    <h3 class="text-xl uppercase tracking-widest border-b border-gray-200 flex-1 pb-1 text-black">Nhà Gái</h3>
                </div>
                
                <div class="pl-12 space-y-8">
                    @if($wedding->bride_reception_time)
                    <div>
                        <p class="font-bold text-xs uppercase tracking-wider mb-1 text-gray-500">Tiệc Cưới</p>
                        <p class="text-2xl font-display italic text-black">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $wedding->bride_reception_venue }}</p>
                    </div>
                    @endif

                    <div>
                        <p class="font-bold text-xs uppercase tracking-wider mb-1 text-gray-500">Lễ Vu Quy</p>
                         <div class="flex items-baseline gap-3 mb-1">
                            <span class="text-2xl font-display italic text-black">{{ $wedding->bride_ceremony_time ? \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') : '--' }}</span>
                            <span class="text-xs text-black uppercase">{{ $wedding->bride_ceremony_date ? \Carbon\Carbon::parse($wedding->bride_ceremony_date)->format('M d') : '' }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">{{ $wedding->bride_address }}</p>
                        @if($wedding->bride_map_url)
                        <a href="{{ $wedding->bride_map_url }}" target="_blank" class="text-[10px] uppercase font-bold border border-black px-4 py-2 bg-white text-black hover:bg-black hover:text-white transition">Google Maps</a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- NHÀ TRAI --}}
             <div class="block">
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-4xl font-display text-black">02.</span>
                    <h3 class="text-xl uppercase tracking-widest border-b border-gray-200 flex-1 pb-1 text-black">Nhà Trai</h3>
                </div>
                
                <div class="pl-12 space-y-8">
                    @if($wedding->groom_reception_time)
                    <div>
                        <p class="font-bold text-xs uppercase tracking-wider mb-1 text-gray-500">Tiệc Cưới</p>
                        <p class="text-2xl font-display italic text-black">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $wedding->groom_reception_venue }}</p>
                    </div>
                    @endif

                    <div>
                        <p class="font-bold text-xs uppercase tracking-wider mb-1 text-gray-500">Lễ Thành Hôn</p>
                         <div class="flex items-baseline gap-3 mb-1">
                            <span class="text-2xl font-display italic text-black">{{ $wedding->groom_ceremony_time ? \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') : '--' }}</span>
                            <span class="text-xs text-black uppercase">{{ $wedding->groom_ceremony_date ? \Carbon\Carbon::parse($wedding->groom_ceremony_date)->format('M d') : '' }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">{{ $wedding->groom_address }}</p>
                        @if($wedding->groom_map_url)
                        <a href="{{ $wedding->groom_map_url }}" target="_blank" class="text-[10px] uppercase font-bold border border-black px-4 py-2 bg-white text-black hover:bg-black hover:text-white transition">Google Maps</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RSVP & WISHES --}}
    <section class="py-24 px-6 bg-[#f4f4f0]" x-data="{ showQr: null, showWishes: false }">
        <h2 class="text-center font-display text-4xl mb-12">Box of Wishes</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-0 border border-black/10 max-w-md mx-auto mb-10 bg-white">
            <button @click="showQr = 'groom'" class="p-8 border-b md:border-b-0 md:border-r border-black/10 hover:bg-gray-50 transition text-left">
                <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-2">For The</span>
                <span class="text-2xl font-display block text-black">Groom's Family</span>
            </button>
            <button @click="showQr = 'bride'" class="p-8 hover:bg-gray-50 transition text-right">
                 <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-2">For The</span>
                <span class="text-2xl font-display block text-black">Bride's Family</span>
            </button>
        </div>

        <div class="text-center">
            <button @click="showWishes = true" class="text-sm uppercase tracking-[0.3em] font-bold border-b-2 border-black pb-1 text-black hover:opacity-70 transition">
                Send Your Love
            </button>
        </div>

        {{-- CLEAN MODALS --}}
        <div x-show="showWishes" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-white/95" style="display: none;">
             <div class="w-full max-w-md relative" @click.outside="showWishes = false">
                <button @click="showWishes = false" class="absolute -top-12 right-0 text-xl font-serif italic text-black">Close</button>
                <h3 class="text-4xl font-display mb-8 text-center text-black">Words of Love</h3>
                <form class="space-y-8">
                    <input type="text" placeholder="Your Name" class="w-full bg-transparent border-b border-gray-300 py-4 text-xl font-display focus:border-black outline-none placeholder:text-gray-300 text-black">
                    <textarea rows="3" placeholder="Your Message" class="w-full bg-transparent border-b border-gray-300 py-4 text-xl font-display focus:border-black outline-none placeholder:text-gray-300 text-black"></textarea>
                    <button type="submit" class="w-full bg-black text-white py-4 text-xs uppercase tracking-widest hover:bg-gray-800 transition">Send Message</button>
                </form>
             </div>
        </div>
        
        <div x-show="showQr" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-white/95" style="display: none;">
            <div class="w-full max-w-sm text-center relative" @click.outside="showQr = null">
                <button @click="showQr = null" class="absolute -top-12 right-0 text-xl font-serif italic text-black">Close</button>
                <h3 class="text-2xl font-display mb-8 text-black" x-text="showQr === 'groom' ? 'Groom\'s Gift Box' : 'Bride\'s Gift Box'"></h3>
                <template x-if="showQr === 'groom'">
                    <div>
                         @if($wedding->getFirstMediaUrl('groom_qr'))
                            <img src="{{ $wedding->getFirstMediaUrl('groom_qr') }}" class="w-48 h-48 mx-auto mb-6 border border-gray-200">
                        @else
                            <div class="w-48 h-48 mx-auto mb-6 bg-gray-100 flex items-center justify-center"><p class="text-[10px] uppercase">No QR Code</p></div>
                        @endif
                        <p class="font-mono text-xs text-gray-500">{{ $wedding->groom_qr_info }}</p>
                    </div>
                </template>
                <template x-if="showQr === 'bride'">
                    <div>
                         @if($wedding->getFirstMediaUrl('bride_qr'))
                            <img src="{{ $wedding->getFirstMediaUrl('bride_qr') }}" class="w-48 h-48 mx-auto mb-6 border border-gray-200">
                        @else
                             <div class="w-48 h-48 mx-auto mb-6 bg-gray-100 flex items-center justify-center"><p class="text-[10px] uppercase">No QR Code</p></div>
                        @endif
                         <p class="font-mono text-xs text-gray-500">{{ $wedding->bride_qr_info }}</p>
                    </div>
                </template>
            </div>
        </div>
    </section>

    {{-- GALLERY EDITORIAL --}}
    <section class="py-24 px-4 bg-white">
        <h2 class="text-[10vw] font-display text-center leading-none opacity-5 mb-[-5vw] relative z-0 text-black">Memories</h2>
        <div class="columns-1 md:columns-2 gap-8 space-y-8 relative z-10 px-4">
            @if($wedding->getMedia('gallery')->isNotEmpty())
                @foreach($wedding->getMedia('gallery') as $media)
                <div class="break-inside-avoid">
                    <img src="{{ $media->getUrl() }}" class="w-full h-auto">
                </div>
                @endforeach
            @else
                {{-- Placeholder gallery for demo --}}
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=600', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600', 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600', 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=600'] as $placeholder)
                <div class="break-inside-avoid">
                    <img src="{{ $placeholder }}" class="w-full h-auto">
                </div>
                @endforeach
            @endif
        </div>
    </section>

    <footer class="py-12 bg-[#f4f4f0] text-center border-t border-black/5">
        <p class="font-display text-2xl mb-4">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</p>
        <p class="text-[10px] uppercase tracking-widest text-gray-400">Thank you for being part of our story.</p>
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
