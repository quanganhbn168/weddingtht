{{-- 
Template Name: Luxury Gold (Vàng Sang Trọng)
Type: business
Description: Giao diện Landing Page tông đen vàng quyền lực, ảnh lớn không khung.
--}}
@extends('layouts.business')

@section('title', $card->name)

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Manrope:wght@300;400;500;600&display=swap');
    
    .luxury-gold-theme {
        font-family: 'Manrope', sans-serif;
        background-color: #0c0c0c;
        color: #d4af37;
    }
    .luxury-gold-theme .font-serif { font-family: 'Playfair Display', serif; }
    .luxury-gold-theme .text-gold { color: #D4AF37; }
    .luxury-gold-theme .bg-gold { background-color: #D4AF37; }
    .luxury-gold-theme .border-gold { border-color: #D4AF37; }
</style>
@endpush

@section('content')
    <div class="luxury-gold-theme overflow-x-hidden min-h-screen">
        
        <!-- Navbar -->
        <nav class="fixed top-0 left-0 w-full z-50 p-6 flex justify-between items-center bg-gradient-to-b from-black/80 to-transparent">
            <div class="text-white font-serif text-xl font-bold tracking-widest">{{ $card->company }}</div>
            <a href="tel:{{ $card->phone }}" class="hidden md:block px-6 py-2 border border-[#d4af37] text-[#d4af37] hover:bg-[#d4af37] hover:text-black transition uppercase text-xs tracking-widest">Liên hệ</a>
        </nav>

        <!-- Hero Section with Full Background + Floating Portrait -->
        <header class="min-h-screen relative flex items-end md:items-center overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2029&auto=format&fit=crop" 
                     class="w-full h-full object-cover opacity-30" alt="Background">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0c0c0c] via-[#0c0c0c]/70 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#0c0c0c] via-transparent to-[#0c0c0c]/50"></div>
            </div>
            
            <!-- Gold Accent Lines -->
            <div class="absolute top-20 left-10 w-[1px] h-40 bg-gradient-to-b from-[#d4af37] to-transparent hidden md:block"></div>
            <div class="absolute bottom-20 right-10 w-[1px] h-40 bg-gradient-to-t from-[#d4af37] to-transparent hidden md:block"></div>

            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 pb-20 md:pb-0">
                <div class="flex flex-col md:flex-row items-end md:items-center gap-8 md:gap-0">
                    
                    <!-- Text Content -->
                    <div class="md:w-1/2 order-2 md:order-1 text-center md:text-left">
                        <div class="inline-block w-16 h-[2px] bg-[#d4af37] mb-6 hidden md:block" data-aos="fade-right"></div>
                        <span class="text-[#666] uppercase tracking-[0.3em] text-xs font-bold block mb-4" data-aos="fade-up">{{ $card->title }}</span>
                        <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif font-bold text-white mb-6 leading-none" data-aos="fade-up" data-aos-delay="100">
                            {{ $card->name }}
                        </h1>
                        <div class="text-gray-400 leading-relaxed text-lg mb-10 font-light max-w-xl" data-aos="fade-up" data-aos-delay="200">
                            {!! Str::limit(strip_tags($card->about), 200) !!}
                        </div>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-4" data-aos="fade-up" data-aos-delay="300">
                            @if($card->phone)
                            <a href="tel:{{ $card->phone }}" class="px-8 py-4 bg-[#d4af37] text-black font-bold uppercase tracking-widest text-sm hover:bg-white transition duration-300">
                                <i class="fas fa-phone mr-2"></i> Gọi ngay
                            </a>
                            @endif
                            @if($card->email)
                            <a href="mailto:{{ $card->email }}" class="px-8 py-4 border border-[#333] text-[#888] hover:border-white hover:text-white transition duration-300 uppercase tracking-widest text-sm">
                                Gửi Email
                            </a>
                            @endif
                        </div>

                        <!-- Social Links (Inline) -->
                        <div class="flex justify-center md:justify-start gap-4 mt-10" data-aos="fade-up" data-aos-delay="400">
                            @foreach($card->social_links ?? [] as $link)
                            <a href="{{ $link['url'] }}" class="w-10 h-10 flex items-center justify-center border border-[#333] text-[#666] rounded-full hover:border-[#d4af37] hover:text-[#d4af37] transition duration-300">
                                <i class="{{ match($link['platform']) { 'facebook' => 'fab fa-facebook-f', 'linkedin' => 'fab fa-linkedin-in', 'youtube' => 'fab fa-youtube', 'zalo' => 'fas fa-comment-dots', default => 'fas fa-link' } }}"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Floating Portrait (No Frame) -->
                    <div class="md:w-1/2 order-1 md:order-2 flex justify-center md:justify-end relative" data-aos="fade-left" data-aos-duration="1200">
                        <!-- Glow Effect Behind Portrait -->
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[300px] h-[300px] bg-[#d4af37]/20 rounded-full blur-[100px]"></div>
                        
                        @if($card->hasMedia('avatar'))
                            <img src="{{ $card->getFirstMediaUrl('avatar') }}" 
                                 class="relative z-10 max-h-[70vh] md:max-h-[90vh] w-auto object-contain drop-shadow-[0_20px_50px_rgba(212,175,55,0.3)]" 
                                 alt="{{ $card->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=2787&auto=format&fit=crop" 
                                 class="relative z-10 max-h-[70vh] md:max-h-[80vh] w-auto object-cover rounded-t-full grayscale" 
                                 alt="Placeholder Portrait">
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats Section (Gold Bar) -->
        @if(!empty($stats))
        <section class="py-16 bg-[#d4af37] text-black relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="max-w-6xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 relative z-10">
                @foreach($stats as $index => $stat)
                <div class="text-center border-r border-black/10 last:border-0 hover:translate-y-[-5px] transition" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="text-4xl md:text-5xl font-serif font-bold mb-1">{{ $stat['number'] }}</div>
                    <div class="text-xs font-bold uppercase tracking-widest opacity-70">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Services -->
        @if(count($services) > 0)
        <section class="py-32 px-6 bg-[#111] relative">
            <!-- Decorative -->
            <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[#d4af37]/30 to-transparent"></div>
            
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-20">
                    <span class="text-[#d4af37] uppercase tracking-[0.3em] text-xs font-bold block mb-4">Chuyên môn</span>
                    <h2 class="text-4xl md:text-5xl font-serif text-white">Dịch vụ & Giải pháp</h2>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($services as $index => $svc)
                    <div class="bg-[#0c0c0c] p-10 border border-[#222] hover:border-[#d4af37] transition duration-500 group relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <!-- Hover Glow -->
                        <div class="absolute inset-0 bg-[#d4af37]/5 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        
                        <div class="text-[#d4af37] text-4xl mb-6 group-hover:scale-110 transition duration-300 block w-fit relative z-10">
                            <i class="{{ $svc['icon'] }}"></i>
                        </div>
                        <h3 class="text-xl font-serif text-white mb-4 relative z-10">{{ $svc['title'] }}</h3>
                        <p class="text-gray-500 leading-relaxed font-light text-sm relative z-10">{{ $svc['description'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Quote Section with Parallax BG -->
        @if($quoteText)
        <section class="py-40 px-6 relative bg-fixed bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=2564&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-black/85"></div>
            <div class="max-w-4xl mx-auto text-center relative z-10 px-6" data-aos="zoom-in">
                <div class="text-[#d4af37] text-7xl font-serif opacity-30 mb-4">"</div>
                <h2 class="text-2xl md:text-4xl font-serif text-white leading-relaxed italic mb-10">
                    {{ $quoteText }}
                </h2>
                <div class="inline-block border-b-2 border-[#d4af37] pb-2 text-[#d4af37] uppercase tracking-widest text-sm font-bold">
                    {{ $quoteAuthor }}
                </div>
            </div>
        </section>
        @endif

        <!-- Experience Timeline -->
        @if(count($experience) > 0)
        <section class="py-32 px-6 bg-[#0c0c0c]">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-end justify-between mb-20 border-b border-[#222] pb-6">
                     <div>
                        <span class="text-[#d4af37] uppercase tracking-[0.3em] text-xs font-bold">Hành trình</span>
                        <h2 class="text-4xl md:text-5xl font-serif text-white mt-2">Kinh nghiệm</h2>
                     </div>
                </div>

                <div class="space-y-0">
                    @foreach($experience as $index => $exp)
                    <div class="group flex flex-col md:flex-row gap-10 py-10 border-b border-[#222] hover:bg-[#111] transition px-4 md:px-8" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <div class="md:w-1/4">
                             <span class="text-3xl font-serif text-[#d4af37]">{{ $exp['year'] }}</span>
                        </div>
                        <div class="md:w-3/4">
                            <h3 class="text-xl font-bold text-white mb-1 group-hover:text-[#d4af37] transition">{{ $exp['title'] }}</h3>
                            <div class="text-[#666] text-sm uppercase tracking-wider mb-4">{{ $exp['company'] }}</div>
                            <p class="text-gray-500 font-light leading-relaxed">{{ $exp['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-20 px-6 bg-[#080808] border-t border-[#222] text-center relative">
            <!-- Gold Line -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-20 h-[2px] bg-[#d4af37]"></div>
            
            <h2 class="text-3xl font-serif text-white mb-6">{{ $card->company }}</h2>
            <div class="flex flex-col md:flex-row justify-center gap-6 md:gap-12 text-[#666] text-sm font-light uppercase tracking-widest mb-10">
                @if($card->phone) <a href="tel:{{ $card->phone }}" class="hover:text-[#d4af37] transition">{{ $card->phone }}</a> @endif
                @if($card->email) <a href="mailto:{{ $card->email }}" class="hover:text-[#d4af37] transition">{{ $card->email }}</a> @endif
            </div>
            <p class="text-[#333] text-xs uppercase tracking-widest">
                &copy; {{ date('Y') }} {{ $card->name }}. All Rights Reserved.
            </p>
        </footer>
    </div>
@endsection
