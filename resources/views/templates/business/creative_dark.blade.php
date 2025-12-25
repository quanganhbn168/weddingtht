{{-- 
Template Name: Creative Dark (Sáng Tạo)
Type: business
Description: Giao diện tối, màu sắc nổi bật, ảnh lớn không khung.
--}}
@extends('layouts.business')

@section('title', $card->name)

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap');
    
    .creative-dark-theme {
        font-family: 'Outfit', sans-serif;
        background-color: #000;
        color: #fff;
    }
    .creative-dark-theme .neon-text { text-shadow: 0 0 10px rgba(236, 72, 153, 0.5), 0 0 20px rgba(236, 72, 153, 0.3); }
    .creative-dark-theme .gradient-pink-purple { background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%); }
    .creative-dark-theme .text-gradient { background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
</style>
@endpush

@section('content')
    <div class="creative-dark-theme min-h-screen overflow-x-hidden selection:bg-pink-500 selection:text-white">
        
        <!-- Navbar -->
        <nav class="fixed w-full z-50 py-6 bg-gradient-to-b from-black/90 to-transparent">
            <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
                <a href="#" class="text-2xl font-black tracking-tighter uppercase">{{ $card->company ?? 'CREATIVE' }}</a>
                <a href="tel:{{ $card->phone }}" class="w-12 h-12 rounded-full border border-white/30 flex items-center justify-center hover:bg-white hover:text-black transition">
                    <i class="fas fa-phone"></i>
                </a>
            </div>
        </nav>

        <!-- Hero with Floating Portrait -->
        <header class="min-h-screen flex items-end md:items-center relative pt-20">
            <!-- Background Effects -->
            <div class="absolute inset-0 z-0">
                <div class="absolute top-[10%] right-[5%] w-[500px] h-[500px] bg-purple-600/30 rounded-full blur-[120px] animate-pulse"></div>
                <div class="absolute bottom-[10%] left-[5%] w-[500px] h-[500px] bg-pink-600/30 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
                <!-- Grid Pattern -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0wIDBoNDB2NDBoLTQweiIvPjxwYXRoIGQ9Ik00MCAwdjQwaDQwdi00MHoiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIvPjwvZz48L3N2Zz4=')] opacity-50"></div>
            </div>

            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 pb-16 md:pb-0">
                <div class="flex flex-col md:flex-row items-end md:items-center gap-8">
                    
                    <!-- Text Content -->
                    <div class="md:w-1/2 order-2 md:order-1 text-center md:text-left">
                        <span class="text-pink-500 uppercase tracking-[0.3em] text-xs font-bold block mb-4" data-aos="fade-up">{{ $card->title }}</span>
                        <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 tracking-tighter uppercase leading-none" data-aos="fade-up" data-aos-delay="100">
                            <span class="text-gradient neon-text">{{ $card->name }}</span>
                        </h1>
                        
                        <div class="text-gray-400 text-lg mb-10 font-light max-w-lg" data-aos="fade-up" data-aos-delay="200">
                            {!! Str::limit(strip_tags($card->about), 150) !!}
                        </div>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-4" data-aos="fade-up" data-aos-delay="300">
                            @foreach($card->social_links ?? [] as $link)
                            <a href="{{ $link['url'] }}" class="w-14 h-14 rounded-full border border-gray-800 flex items-center justify-center text-xl hover:bg-white hover:text-black hover:border-white transition duration-300">
                                <i class="{{ match($link['platform']) { 'facebook' => 'fab fa-facebook-f', 'linkedin' => 'fab fa-linkedin-in', 'tiktok' => 'fab fa-tiktok', default => 'fas fa-link' } }}"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Floating Portrait (No Frame) -->
                    <div class="md:w-1/2 order-1 md:order-2 flex justify-center relative" data-aos="fade-left" data-aos-duration="1200">
                        <!-- Glow Behind -->
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[350px] h-[350px] gradient-pink-purple rounded-full blur-[100px] opacity-50"></div>
                        
                        @if($card->hasMedia('avatar'))
                            <img src="{{ $card->getFirstMediaUrl('avatar') }}" 
                                 class="relative z-10 max-h-[60vh] md:max-h-[85vh] w-auto object-contain drop-shadow-[0_20px_60px_rgba(236,72,153,0.4)]" 
                                 alt="{{ $card->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=987&auto=format&fit=crop" 
                                 class="relative z-10 max-h-[60vh] md:max-h-[85vh] w-auto object-cover rounded-t-full grayscale" 
                                 alt="Placeholder">
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats -->
        @if(!empty($stats))
        <section class="border-y border-gray-900 bg-gray-900/50 backdrop-blur-sm">
            <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4">
                @foreach($stats as $index => $stat)
                <div class="p-10 md:p-12 text-center border-r border-gray-900 last:border-0 hover:bg-gray-900/80 transition duration-300" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="text-4xl md:text-5xl font-black mb-2 text-white">{{ $stat['number'] }}</div>
                    <div class="text-pink-500 font-bold uppercase text-xs tracking-widest">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Services (Cards) -->
        @if(count($services) > 0)
        <section class="py-32 px-6">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-5xl md:text-7xl font-black mb-20 text-center uppercase tracking-tighter">
                    My <span class="text-gradient">World</span>
                </h2>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($services as $index => $svc)
                    <div class="group relative p-[2px] gradient-pink-purple hover:scale-[1.02] transition duration-500 rounded-3xl" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="bg-black h-full w-full rounded-[1.4rem] p-10 relative overflow-hidden">
                            <div class="absolute -right-6 -bottom-6 text-9xl text-gray-900 opacity-30 group-hover:opacity-10 group-hover:scale-125 transition duration-500">
                                <i class="{{ $svc['icon'] }}"></i>
                            </div>

                            <div class="relative z-10">
                                <div class="w-16 h-16 rounded-2xl bg-gray-900 flex items-center justify-center text-3xl mb-8 group-hover:bg-white group-hover:text-black transition duration-500">
                                    <i class="{{ $svc['icon'] }}"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-4 group-hover:text-pink-400 transition">{{ $svc['title'] }}</h3>
                                <p class="text-gray-400 font-light leading-relaxed">{{ $svc['description'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Quote -->
        @if($quoteText)
        <section class="py-40 px-6 relative overflow-hidden">
             <!-- Big Outline Text Background -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[15vw] font-black text-gray-900 select-none opacity-20 whitespace-nowrap z-0">
                INSPIRE
            </div>
            
            <div class="max-w-4xl mx-auto text-center relative z-10" data-aos="zoom-in">
                <p class="text-3xl md:text-5xl font-bold leading-tight mb-10">
                    <span class="text-pink-500">"</span>{{ $quoteText }}<span class="text-purple-500">"</span>
                </p>
                <cite class="text-xl text-gray-400 not-italic font-mono uppercase tracking-widest">// {{ $quoteAuthor }}</cite>
            </div>
        </section>
        @endif

        <!-- Experience -->
        @if(count($experience) > 0)
        <section class="py-32 bg-gray-900">
            <div class="max-w-5xl mx-auto px-6">
                <div class="flex flex-col md:flex-row gap-20">
                    <div class="md:w-1/3">
                        <h2 class="text-5xl font-black uppercase mb-6 sticky top-32">Timeline</h2>
                    </div>
                    <div class="md:w-2/3 space-y-16">
                        @foreach($experience as $index => $exp)
                        <div class="group" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                            <span class="text-5xl font-black text-gray-800 group-hover:text-gray-700 transition block mb-4">{{ $exp['year'] }}</span>
                            <h3 class="text-3xl font-bold mb-2 group-hover:text-pink-500 transition">{{ $exp['title'] }}</h3>
                            <div class="text-purple-400 font-mono text-sm mb-4 uppercase tracking-widest">{{ $exp['company'] }}</div>
                            <p class="text-gray-400 font-light text-lg">{{ $exp['description'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif

        <footer class="py-20 text-center border-t border-gray-900">
            <h2 class="text-[8vw] md:text-[6vw] font-black text-gray-900 leading-none select-none hover:text-gray-800 transition duration-500 cursor-default">
                {{ $card->company }}
            </h2>
            <div class="mt-8 flex justify-center gap-8 text-sm font-bold uppercase tracking-widest text-gray-500">
                @if($card->email) <a href="mailto:{{ $card->email }}" class="hover:text-white transition">Email</a> @endif
                @if($card->phone) <a href="tel:{{ $card->phone }}" class="hover:text-white transition">Phone</a> @endif
            </div>
        </footer>
    </div>
@endsection
