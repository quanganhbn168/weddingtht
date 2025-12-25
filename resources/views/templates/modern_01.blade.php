@extends('layouts.app')
{{-- Template Name: Modern Style (Hồng Phấn Hiện Đại) --}}

@section('title', 'HAPPY WEDDING ' . $wedding->groom_name . ' - ' . $wedding->bride_name)
@section('description', 'Wedding Invitation - Thiệp cưới của ' . $wedding->groom_name . ' và ' . $wedding->bride_name)

@section('content')
@section('og_image', $shareUrl)

{{-- Animations Styles --}}
<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes zoomIn { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }
    
    .animate-fade-up { animation: fadeInUp 1s ease-out forwards; }
    .animate-fade-down { animation: fadeInDown 1s ease-out forwards; }
    .animate-zoom-in { animation: zoomIn 1s ease-out forwards; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-500 { animation-delay: 0.5s; }
    .delay-700 { animation-delay: 0.7s; }
</style>

<div class="min-h-screen bg-rose-50 font-serif overflow-x-hidden max-w-[480px] mx-auto shadow-2xl relative">
    
    {{-- Music Player --}}
    @if($musicUrl)
    <div x-data="{ playing: false, audio: null }" x-init="audio = new Audio('{{ $musicUrl }}'); audio.loop = true;" class="fixed top-4 right-4 z-50">
        <button @click="playing ? audio.pause() : audio.play(); playing = !playing" class="w-10 h-10 rounded-full bg-white/80 backdrop-blur shadow-lg flex items-center justify-center text-rose-500 animate-spin-slow">
            <template x-if="!playing"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></template>
            <template x-if="playing"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg></template>
        </button>
    </div>
    @endif

    {{-- HERO SECTION --}}
    <section class="relative h-screen flex flex-col justify-end pb-16 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroUrl }}" class="w-full h-full object-cover">
            {{-- Gradient đáy ảnh để làm nổi chữ --}}
            <div class="absolute bottom-0 left-0 right-0 h-3/4 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
        </div>
        
        <div class="relative z-10 text-center text-white px-6 w-full max-w-4xl mx-auto">
            <div class="animate-fade-down mb-6">
                <p class="text-sm md:text-base tracking-[0.5em] uppercase font-sans font-light opacity-90">
                    Save The Date
                </p>
            </div>
            
            <div class="flex flex-col items-center gap-2 animate-zoom-in delay-200 mb-8">
                <h1 class="text-6xl md:text-8xl font-serif tracking-tight leading-none">{{ $wedding->groom_name }}</h1>
                <span class="text-4xl font-script text-white/90 my-2">&</span>
                <h1 class="text-6xl md:text-8xl font-serif tracking-tight leading-none">{{ $wedding->bride_name }}</h1>
            </div>
            
            <div class="animate-fade-up delay-500">
                <div class="inline-block border-y border-white/50 py-3 px-8 mb-4">
                    <p class="text-3xl md:text-5xl font-serif tracking-widest">{{ $wedding->event_date?->format('d . m . Y') }}</p>
                </div>
                {{-- Ngày Âm Lịch --}}
                @if($wedding->event_date_lunar)
                    <p class="text-base md:text-lg font-serif italic opacity-80">( {{ $wedding->event_date_lunar }} Âm Lịch )</p>
                @endif
                <p class="text-sm uppercase tracking-[0.4em] font-sans font-medium mt-6 opacity-70">Lễ Thành Hôn</p>
            </div>
            
            <div class="mt-8 animate-bounce">
                <svg class="w-6 h-6 text-white/50 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            </div>
        </div>
    </section>

    {{-- INTRO COUPLE --}}
    <section class="py-24 px-6 bg-white">
        <div class="text-center mb-20 animate-on-scroll">
            <span class="block w-[1px] h-12 bg-gray-300 mx-auto mb-6"></span>
            <p class="text-gray-400 text-xs tracking-[0.4em] uppercase mb-4 font-sans">The Couple</p>
            <h2 class="text-4xl md:text-5xl font-serif text-gray-900 leading-tight">Cô Dâu & Chú Rể</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 max-w-5xl mx-auto">
            {{-- Chú rể --}}
            <div class="flex flex-col items-center animate-on-scroll group">
                <div class="w-full aspect-[3/4] overflow-hidden mb-6 relative bg-gray-100">
                    <img src="{{ $groomPhoto }}" class="w-full h-full object-cover transition duration-1000 group-hover:scale-105 brightness-95 group-hover:brightness-100 grayscale-[5%] group-hover:grayscale-0">
                </div>
                <div class="text-center w-full">
                    <h3 class="text-3xl font-serif text-gray-900 mb-2 uppercase tracking-wide">{{ $wedding->groom_name }}</h3>
                    <div class="space-y-1 mt-4 text-gray-600 font-serif text-lg">
                        @if($wedding->groom_father)<p>Con ông: {{ $wedding->groom_father }}</p>@endif
                        @if($wedding->groom_mother)<p>Con bà: {{ $wedding->groom_mother }}</p>@endif
                    </div>
                </div>
            </div>
            
            {{-- Cô dâu --}}
            <div class="flex flex-col items-center animate-on-scroll group md:mt-24"> {{-- Staggered layout --}}
                <div class="w-full aspect-[3/4] overflow-hidden mb-6 relative bg-gray-100">
                    <img src="{{ $bridePhoto }}" class="w-full h-full object-cover transition duration-1000 group-hover:scale-105 brightness-95 group-hover:brightness-100 grayscale-[5%] group-hover:grayscale-0">
                </div>
                <div class="text-center w-full">
                    <h3 class="text-3xl font-serif text-gray-900 mb-2 uppercase tracking-wide">{{ $wedding->bride_name }}</h3>
                    <div class="space-y-1 mt-4 text-gray-600 font-serif text-lg">
                        @if($wedding->bride_father)<p>Con ông: {{ $wedding->bride_father }}</p>@endif
                        @if($wedding->bride_mother)<p>Con bà: {{ $wedding->bride_mother }}</p>@endif
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-32 px-6 max-w-2xl mx-auto">
            <span class="text-4xl text-gray-300 font-serif block mb-6">“</span>
            <p class="text-gray-600 text-lg leading-loose font-serif italic">
                Hôn nhân không phải là đích đến, mà là khởi đầu của một hành trình yêu thương bất tận.
            </p>
            <span class="block w-12 h-[1px] bg-gray-800 mx-auto mt-10"></span>
        </div>
    </section>

    {{-- EVENTS TIMELINE --}}
    <section class="py-24 px-6 bg-stone-50">
        <div class="text-center mb-20">
            <p class="text-gray-400 text-xs tracking-[0.4em] uppercase mb-4 font-sans">The Timeline</p>
            <h2 class="text-4xl md:text-5xl font-serif text-gray-900">Chương Trình Hôn Lễ</h2>
        </div>

        <div class="max-w-5xl mx-auto space-y-20">
            {{-- NHÀ GÁI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start group">
                <div class="text-right md:order-1 order-2 space-y-8">
                    <h3 class="text-3xl font-serif text-gray-900 border-b-2 border-rose-500 pb-2 inline-block">Nhà Gái</h3>
                    
                    {{-- Tiệc Cưới Nhà Gái --}}
                    @if($wedding->bride_reception_time)
                    <div class="relative pl-6 border-r-2 border-gray-100 pr-4">
                         <h4 class="text-xl font-bold font-serif uppercase tracking-wider text-rose-800 mb-2">Tiệc Cưới</h4>
                         <p class="text-2xl font-medium text-gray-800">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }}</p>
                         <p class="text-gray-600 font-sans mt-1">{{ $wedding->bride_reception_venue }}</p>
                         <p class="text-sm text-gray-500 mt-1 italic">{{ $wedding->bride_reception_address }}</p>
                    </div>
                    @endif

                    {{-- Lễ Vu Quy --}}
                    <div>
                        <h4 class="text-xl font-bold font-serif uppercase tracking-wider mt-4 text-rose-800">Lễ Vu Quy</h4>
                        <div class="flex items-center justify-end gap-3 text-gray-600 font-sans mt-2">
                            <span class="text-2xl font-medium">{{ $wedding->bride_ceremony_time ? \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') : '...' }}</span>
                            <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                            <span class="text-lg">{{ $wedding->bride_ceremony_date ? \Carbon\Carbon::parse($wedding->bride_ceremony_date)->format('d . m . Y') : '...' }}</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2 font-sans font-light">{{ $wedding->bride_address }}</p>
                        @if($wedding->bride_map_url)
                            <a href="{{ $wedding->bride_map_url }}" target="_blank" class="inline-block mt-4 text-xs uppercase tracking-widest border border-gray-300 px-4 py-2 hover:bg-black hover:text-white transition duration-300">Map</a>
                        @endif
                    </div>
                </div>
                <div class="md:order-2 order-1">
                    <div class="aspect-[4/3] bg-gray-200 overflow-hidden relative grayscale group-hover:grayscale-0 transition duration-700">
                         <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=800" class="w-full h-full object-cover">
                         <div class="absolute inset-0 border border-white/20 m-4"></div>
                    </div>
                </div>
            </div>

            {{-- NHÀ TRAI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start group">
                <div class="md:order-1 order-1">
                    <div class="aspect-[4/3] bg-gray-200 overflow-hidden relative grayscale group-hover:grayscale-0 transition duration-700">
                         <img src="https://images.unsplash.com/photo-1522673607200-1645062cd958?w=800" class="w-full h-full object-cover">
                         <div class="absolute inset-0 border border-white/20 m-4"></div>
                    </div>
                </div>
                <div class="text-left md:order-2 order-2 space-y-8">
                    <h3 class="text-3xl font-serif text-gray-900 border-b-2 border-blue-500 pb-2 inline-block">Nhà Trai</h3>

                     {{-- Tiệc Cưới Nhà Trai --}}
                    @if($wedding->groom_reception_time)
                    <div class="relative pl-6 border-l-2 border-gray-100">
                         <h4 class="text-xl font-bold font-serif uppercase tracking-wider text-blue-800 mb-2">Tiệc Cưới</h4>
                         <p class="text-2xl font-medium text-gray-800">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }}</p>
                         <p class="text-gray-600 font-sans mt-1">{{ $wedding->groom_reception_venue }}</p>
                         <p class="text-sm text-gray-500 mt-1 italic">{{ $wedding->groom_reception_address }}</p>
                    </div>
                    @endif

                    {{-- Lễ Thành Hôn --}}
                    <div>
                        <h4 class="text-xl font-bold font-serif uppercase tracking-wider mt-4 text-blue-800">Lễ Thành Hôn</h4>
                        <div class="flex items-center gap-3 text-gray-600 font-sans mt-2">
                             <span class="text-2xl font-medium">{{ $wedding->groom_ceremony_time ? \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') : '...' }}</span>
                            <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                            <span class="text-lg">{{ $wedding->groom_ceremony_date ? \Carbon\Carbon::parse($wedding->groom_ceremony_date)->format('d . m . Y') : '...' }}</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2 font-sans font-light">{{ $wedding->groom_address }}</p>
                        @if($wedding->groom_map_url)
                             <a href="{{ $wedding->groom_map_url }}" target="_blank" class="inline-block mt-4 text-xs uppercase tracking-widest border border-gray-300 px-4 py-2 hover:bg-black hover:text-white transition duration-300">Map</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date && $wedding->event_date->isFuture())
    <section class="py-32 bg-[url('https://images.unsplash.com/photo-1518176258769-f227c798150e?w=1600')] bg-cover bg-fixed relative overflow-hidden">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto text-white">
            <p class="text-xs tracking-[0.5em] uppercase mb-12 opacity-90 font-sans">The Big Day</p>
            <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="grid grid-cols-4 gap-4 md:gap-12 border-t border-b border-white/10 py-12">
                <div class="text-center">
                    <span x-text="days" class="block text-5xl md:text-7xl font-serif mb-2">00</span>
                    <span class="text-xs uppercase opacity-60 tracking-widest font-sans">Ngày</span>
                </div>
                <div class="text-center">
                    <span x-text="hours" class="block text-5xl md:text-7xl font-serif mb-2">00</span>
                    <span class="text-xs uppercase opacity-60 tracking-widest font-sans">Giờ</span>
                </div>
                <div class="text-center">
                    <span x-text="minutes" class="block text-5xl md:text-7xl font-serif mb-2">00</span>
                    <span class="text-xs uppercase opacity-60 tracking-widest font-sans">Phút</span>
                </div>
                <div class="text-center">
                    <span x-text="seconds" class="block text-5xl md:text-7xl font-serif mb-2">00</span>
                    <span class="text-xs uppercase opacity-60 tracking-widest font-sans">Giây</span>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- RSVP & QR --}}
    <section class="py-24 px-6 bg-white" x-data="{ showQr: null, showWishes: false }">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-serif text-gray-900 mb-6">Hộp Mừng Cưới</h2>
            <p class="text-gray-500 italic font-serif leading-relaxed max-w-md mx-auto">
                Sự hiện diện của quý khách là món quà trân quý nhất đối với chúng tôi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
            <button @click="showQr = 'groom'" class="group bg-gray-50 hover:bg-white p-10 border border-gray-100 hover:border-gray-900 transition duration-500 text-center">
                <span class="text-gray-900 font-bold text-sm uppercase tracking-[0.2em] block mb-2 group-hover:scale-110 transition duration-500">Nhà Trai</span>
            </button>
            <button @click="showQr = 'bride'" class="group bg-gray-50 hover:bg-white p-10 border border-gray-100 hover:border-gray-900 transition duration-500 text-center">
                <span class="text-gray-900 font-bold text-sm uppercase tracking-[0.2em] block mb-2 group-hover:scale-110 transition duration-500">Nhà Gái</span>
            </button>
        </div>
        
        <div class="mt-16 text-center">
            <button @click="showWishes = true" class="inline-block py-4 px-12 bg-black text-white text-xs uppercase tracking-[0.2em] hover:bg-rose-600 transition duration-500">
                Gửi Lời Chúc
            </button>
        </div>

        {{-- Wishes Modal --}}
        <div x-show="showWishes" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md" style="display: none;" x-transition.opacity>
             <div class="bg-white p-8 w-full max-w-md relative shadow-2xl animate-zoom-in" @click.outside="showWishes = false">
                <button @click="showWishes = false" class="absolute -top-12 right-0 text-white hover:text-gray-300 p-2 uppercase tracking-widest text-xs">
                    Đóng [X]
                </button>
                <h3 class="text-center text-xl font-serif mb-6 text-gray-900 uppercase tracking-widest">Gửi Lời Chúc</h3>
                <form class="space-y-4">
                    <div>
                        <input type="text" placeholder="Tên của bạn" class="w-full p-4 bg-gray-50 border-none focus:ring-1 focus:ring-gray-900 outline-none font-serif text-sm">
                    </div>
                    <div>
                        <textarea rows="4" placeholder="Lời chúc gửi tới cô dâu chú rể..." class="w-full p-4 bg-gray-50 border-none focus:ring-1 focus:ring-gray-900 outline-none font-serif text-sm"></textarea>
                    </div>
                    <button type="submit" class="w-full py-4 bg-gray-900 text-white uppercase tracking-widest text-xs hover:bg-rose-600 transition duration-300">Gửi ngay</button>
                </form>
             </div>
        </div>

        {{-- QR Modal --}}
        <div x-show="showQr" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md" style="display: none;" x-transition.opacity>
            <div class="bg-white p-8 w-full max-w-sm relative shadow-2xl animate-zoom-in" @click.outside="showQr = null">
                <button @click="showQr = null" class="absolute -top-12 right-0 text-white hover:text-gray-300 p-2 uppercase tracking-widest text-xs">
                    Đóng [X]
                </button>
                
                <h3 class="text-center text-xl font-serif mb-8 text-gray-900 uppercase tracking-widest border-b border-gray-100 pb-4" x-text="showQr === 'groom' ? 'Nhà Trai' : 'Nhà Gái'"></h3>
                
                <template x-if="showQr === 'groom'">
                    <div class="text-center">
                        @if($wedding->getFirstMediaUrl('groom_qr'))
                            <div class="p-4 border border-gray-100 inline-block mb-6">
                                <img src="{{ $wedding->getFirstMediaUrl('groom_qr') }}" class="w-48 h-48">
                            </div>
                        @else
                            <p class="text-gray-400 italic mb-4 py-8 bg-gray-50">Chưa cập nhật mã QR</p>
                        @endif
                        <div class="text-left space-y-4 font-mono text-xs text-gray-500 bg-gray-50 p-6">
                            <p class="whitespace-pre-line leading-loose">{{ $wedding->groom_qr_info }}</p>
                        </div>
                    </div>
                </template>
                
                <template x-if="showQr === 'bride'">
                    <div class="text-center">
                        @if($wedding->getFirstMediaUrl('bride_qr'))
                            <div class="p-4 border border-gray-100 inline-block mb-6">
                                <img src="{{ $wedding->getFirstMediaUrl('bride_qr') }}" class="w-48 h-48">
                            </div>
                        @else
                            <p class="text-gray-400 italic mb-4 py-8 bg-gray-50">Chưa cập nhật mã QR</p>
                        @endif
                        <div class="text-left space-y-4 font-mono text-xs text-gray-500 bg-gray-50 p-6">
                            <p class="whitespace-pre-line leading-loose">{{ $wedding->bride_qr_info }}</p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    {{-- ALBUM --}}
    @if($wedding->getMedia('gallery')->isNotEmpty())
    <section class="py-24 px-4 bg-stone-100">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-serif text-gray-900">Gallery</h2>
            <span class="block w-8 h-[2px] bg-gray-900 mx-auto mt-6"></span>
        </div>
        {{-- Masonry layout for mixed aspect ratios --}}
        <div class="columns-2 md:columns-3 gap-4 space-y-4 px-4 max-w-7xl mx-auto">
            @foreach($wedding->getMedia('gallery') as $media)
            <div class="break-inside-avoid overflow-hidden shadow-sm hover:shadow-2xl transition duration-500 cursor-pointer group bg-white p-1">
                {{-- Removed object-cover/h-full to allow natural aspect ratio --}}
                <img src="{{ $media->getUrl() }}" class="w-full h-auto transition duration-1000 group-hover:scale-[1.02] filter grayscale-[10%] group-hover:grayscale-0">
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- THANK YOU --}}
    <footer class="py-32 bg-stone-900 text-white text-center px-6 relative">
        <h2 class="text-5xl md:text-7xl font-serif mb-12 tracking-tight">Thank You</h2>
        <p class="text-gray-400 text-sm leading-8 max-w-md mx-auto mb-12 font-serif italic">
            "Sự hiện diện của quý khách là niềm vinh hạnh lớn lao cho gia đình chúng tôi."
        </p>
        <div class="text-lg font-sans uppercase tracking-[0.3em] pt-12 border-t border-white/10 inline-block px-16 opacity-80">
            {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
        </div>
    </footer>
</div>

<script>
    // Intersection Observer for scroll animations
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-up');
                    observer.unobserve(entry.target);
                }
            });
        });
        
        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    });
</script>
@endsection

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
