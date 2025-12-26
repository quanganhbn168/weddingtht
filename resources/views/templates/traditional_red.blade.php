@extends('layouts.app')
{{-- Template Name: Traditional Red (Đỏ Truyền Thống) --}}

@section('title', 'Lễ Cưới ' . $wedding->groom_name . ' & ' . $wedding->bride_name)

@section('content')
@section('og_image', $shareUrl)

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
    
    /* Premium Traditional Animations */
    @keyframes lanternFloat { 0%, 100% { transform: translateY(0) rotate(-2deg); } 50% { transform: translateY(-10px) rotate(2deg); } }
    @keyframes goldenShimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    @keyframes auspiciousGlow { 0%, 100% { box-shadow: 0 0 10px rgba(223,185,104,0.3); } 50% { box-shadow: 0 0 25px rgba(223,185,104,0.6); } }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .animate-lantern { animation: lanternFloat 5s ease-in-out infinite; }
    .animate-golden-shimmer { background: linear-gradient(90deg, #dfb968, #f6e3ba, #dfb968); background-size: 200% 100%; animation: goldenShimmer 3s infinite; -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .animate-auspicious-glow { animation: auspiciousGlow 2s ease-in-out infinite; }
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; }
    
    .delay-200 { animation-delay: 0.2s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-600 { animation-delay: 0.6s; }
    
    /* Floating Lanterns */
    .floating-lantern { position: absolute; opacity: 0.4; animation: lanternFloat 6s ease-in-out infinite; pointer-events: none; z-index: 5; }
    
    /* Traditional Hover Effects */
    .hover-glow-gold { transition: all 0.4s ease; }
    .hover-glow-gold:hover { box-shadow: 0 0 20px rgba(223,185,104,0.4); }

<div class="max-w-[480px] mx-auto bg-pattern min-h-screen shadow-2xl relative overflow-hidden border-x border-[#5c0f0f]">
    
    {{-- Pro Features: Preload Animation & Falling Effects --}}
    @include('components.wedding.preload', ['wedding' => $wedding])
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    @include('components.wedding.upgrade-banner', ['wedding' => $wedding, 'showUpgradeBanner' => $showUpgradeBanner ?? false])
    
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
        <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
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

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-20 px-6 bg-[#5c0f0f] border-y border-[#dfb968]/30">
        <div class="text-center">
            <p class="text-xs uppercase tracking-[0.3em] text-[#dfb968]/70 mb-8">Đếm Ngược Ngày Trọng Đại</p>
            <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="grid grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="border border-[#dfb968]/40 p-4 bg-[#8a1c1c]/50">
                        <span x-text="days" class="block text-3xl font-playfair text-[#f6e3ba]">00</span>
                        <span class="text-[10px] uppercase text-[#dfb968]/60 tracking-widest">Ngày</span>
                    </div>
                </div>
                <div class="text-center">
                    <div class="border border-[#dfb968]/40 p-4 bg-[#8a1c1c]/50">
                        <span x-text="hours" class="block text-3xl font-playfair text-[#f6e3ba]">00</span>
                        <span class="text-[10px] uppercase text-[#dfb968]/60 tracking-widest">Giờ</span>
                    </div>
                </div>
                <div class="text-center">
                    <div class="border border-[#dfb968]/40 p-4 bg-[#8a1c1c]/50">
                        <span x-text="minutes" class="block text-3xl font-playfair text-[#f6e3ba]">00</span>
                        <span class="text-[10px] uppercase text-[#dfb968]/60 tracking-widest">Phút</span>
                    </div>
                </div>
                <div class="text-center">
                    <div class="border border-[#dfb968]/40 p-4 bg-[#8a1c1c]/50">
                        <span x-text="seconds" class="block text-3xl font-playfair text-[#f6e3ba]">00</span>
                        <span class="text-[10px] uppercase text-[#dfb968]/60 tracking-widest">Giây</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- GALLERY --}}
    <section class="py-16 px-4">
        <h2 class="text-center font-script text-4xl text-gradient-gold mb-10">Khoảnh Khắc Hạnh Phúc</h2>
        <div class="columns-2 gap-3 space-y-3">
            @if($wedding->getMedia('gallery')->isNotEmpty())
                @foreach($wedding->getMedia('gallery') as $media)
                <div class="break-inside-avoid border border-[#dfb968]/30 p-1 bg-[#5c0f0f]/30">
                    <img src="{{ $media->getUrl() }}" class="w-full shadow-lg">
                </div>
                @endforeach
            @else
                {{-- Placeholder gallery for demo --}}
                @foreach(['https://images.unsplash.com/photo-1519741497674-611481863552?w=600', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600', 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600', 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600', 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=600'] as $placeholder)
                <div class="break-inside-avoid border border-[#dfb968]/30 p-1 bg-[#5c0f0f]/30">
                    <img src="{{ $placeholder }}" class="w-full shadow-lg">
                </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- RSVP & QR --}}
    <section class="py-16 px-4" x-data="{ showQr: null }">
        <div class="bg-[#5c0f0f]/50 border border-[#dfb968]/30 p-8 text-center">
            <h2 class="font-playfair text-2xl text-[#f6e3ba] mb-6">Mừng Cưới</h2>
            <p class="text-[#dfb968]/70 text-sm mb-8 italic">Sự hiện diện của quý khách là món quà trân quý nhất</p>
            <div class="flex gap-4 justify-center">
                <button @click="showQr = 'groom'" class="px-6 py-3 border border-[#dfb968] text-[#dfb968] text-xs uppercase tracking-widest hover:bg-[#dfb968] hover:text-[#5c0f0f] transition">Nhà Trai</button>
                <button @click="showQr = 'bride'" class="px-6 py-3 border border-[#dfb968] text-[#dfb968] text-xs uppercase tracking-widest hover:bg-[#dfb968] hover:text-[#5c0f0f] transition">Nhà Gái</button>
            </div>
        </div>

        {{-- QR Modal --}}
        <div x-show="showQr" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90" style="display: none;" x-transition.opacity>
            <div class="bg-[#8a1c1c] border border-[#dfb968] p-8 w-full max-w-sm relative" @click.outside="showQr = null">
                <button @click="showQr = null" class="absolute top-4 right-4 text-[#dfb968] hover:text-white">✕</button>
                <h3 class="text-center text-lg font-playfair mb-6 text-[#f6e3ba]" x-text="showQr === 'groom' ? 'Nhà Trai' : 'Nhà Gái'"></h3>
                
                <template x-if="showQr === 'groom'">
                    <div class="text-center">
                        @if($wedding->getFirstMediaUrl('groom_qr'))
                            <img src="{{ $wedding->getFirstMediaUrl('groom_qr') }}" class="w-40 h-40 mx-auto border-2 border-[#dfb968] mb-4">
                        @else
                            <p class="text-[#dfb968]/60 italic py-8">Chưa cập nhật mã QR</p>
                        @endif
                        <p class="text-xs text-[#dfb968]/70 whitespace-pre-line">{{ $wedding->groom_qr_info }}</p>
                    </div>
                </template>
                
                <template x-if="showQr === 'bride'">
                    <div class="text-center">
                        @if($wedding->getFirstMediaUrl('bride_qr'))
                            <img src="{{ $wedding->getFirstMediaUrl('bride_qr') }}" class="w-40 h-40 mx-auto border-2 border-[#dfb968] mb-4">
                        @else
                            <p class="text-[#dfb968]/60 italic py-8">Chưa cập nhật mã QR</p>
                        @endif
                        <p class="text-xs text-[#dfb968]/70 whitespace-pre-line">{{ $wedding->bride_qr_info }}</p>
                    </div>
                </template>
            </div>
        </div>
    </section>

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
