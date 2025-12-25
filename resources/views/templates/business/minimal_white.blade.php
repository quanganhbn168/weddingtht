{{-- 
Template Name: Minimal White (Trắng Tối Giản)
Type: business
Description: Giao diện Landing Page phong cách tối giản, ảnh lớn không khung.
--}}
@extends('layouts.business')

@section('title', $card->name)

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&family=Playfair+Display:ital@0;1&display=swap');
    
    .minimal-white-theme {
        font-family: 'Inter', sans-serif;
        background-color: #ffffff;
        color: #111;
    }
    .minimal-white-theme .font-serif { font-family: 'Playfair Display', serif; }
</style>
@endpush

@section('content')
    <div class="minimal-white-theme selection:bg-black selection:text-white min-h-screen">

        <!-- Navbar -->
        <nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100">
            <div class="max-w-6xl mx-auto px-6 h-16 flex justify-between items-center">
                <span class="font-bold tracking-tight text-lg">{{ $card->company }}</span>
                <a href="mailto:{{ $card->email }}" class="text-sm font-medium hover:text-gray-500 transition">Liên hệ</a>
            </div>
        </nav>
        
        <!-- Hero Section with Background + Floating Portrait -->
        <header class="min-h-screen relative flex items-end md:items-center pt-20 overflow-hidden">
            <!-- Light Background Pattern -->
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-white to-gray-100"></div>
                <!-- Decorative Blobs -->
                <div class="absolute top-[10%] right-[10%] w-[500px] h-[500px] bg-gray-200/50 rounded-full blur-[100px]"></div>
                <div class="absolute bottom-[20%] left-[5%] w-[400px] h-[400px] bg-gray-100 rounded-full blur-[80px]"></div>
            </div>

            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 pb-16 md:pb-0">
                <div class="flex flex-col md:flex-row items-end md:items-center gap-8">
                    
                    <!-- Portrait (Frameless, Large) -->
                    <div class="md:w-1/2 order-1 flex justify-center md:justify-start relative" data-aos="fade-right" data-aos-duration="1200">
                        @if($card->hasMedia('avatar'))
                            <img src="{{ $card->getFirstMediaUrl('avatar') }}" 
                                 class="relative z-10 max-h-[60vh] md:max-h-[85vh] w-auto object-contain drop-shadow-[0_30px_60px_rgba(0,0,0,0.15)]" 
                                 alt="{{ $card->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=987&auto=format&fit=crop" 
                                 class="relative z-10 max-h-[60vh] md:max-h-[85vh] w-auto object-cover rounded-t-3xl" 
                                 alt="Placeholder Portrait">
                        @endif
                    </div>

                    <!-- Text Content -->
                    <div class="md:w-1/2 order-2 text-center md:text-left md:pl-12">
                        <span class="inline-block px-4 py-2 rounded-full bg-gray-100 text-xs font-bold tracking-widest uppercase text-gray-500 mb-6" data-aos="fade-up">
                            {{ $card->title }}
                        </span>

                        <h1 class="text-5xl md:text-7xl font-black text-black tracking-tighter mb-6 leading-none" data-aos="fade-up" data-aos-delay="100">
                            {{ $card->name }}
                        </h1>
                        
                        <div class="text-gray-500 text-lg md:text-xl font-light leading-relaxed mb-10 max-w-lg" data-aos="fade-up" data-aos-delay="200">
                            {!! Str::limit(strip_tags($card->about), 180) !!}
                        </div>

                        <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4" data-aos="fade-up" data-aos-delay="300">
                            @if($card->email)
                            <a href="mailto:{{ $card->email }}" class="px-8 py-4 bg-black text-white rounded-full font-bold hover:bg-gray-800 transition shadow-xl shadow-gray-200">
                                Liên hệ ngay
                            </a>
                            @endif
                            @if($card->phone)
                            <a href="tel:{{ $card->phone }}" class="px-8 py-4 bg-gray-100 text-black rounded-full font-bold hover:bg-gray-200 transition">
                                <i class="fas fa-phone mr-2"></i> {{ $card->phone }}
                            </a>
                            @endif
                        </div>

                        <!-- Simple Socials -->
                        <div class="mt-10 flex justify-center md:justify-start gap-5" data-aos="fade-up" data-aos-delay="400">
                            @foreach($card->social_links ?? [] as $link)
                            <a href="{{ $link['url'] }}" class="text-gray-400 hover:text-black transition text-xl">
                                <i class="{{ match($link['platform']) { 'facebook' => 'fab fa-facebook-f', 'linkedin' => 'fab fa-linkedin-in', 'youtube' => 'fab fa-youtube', 'instagram' => 'fab fa-instagram', default => 'fas fa-link' } }}"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats -->
        @if(!empty($stats))
        <section class="border-y border-gray-100 bg-white py-16">
            <div class="max-w-5xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach($stats as $index => $stat)
                <div class="text-center" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="text-4xl font-black mb-2">{{ $stat['number'] }}</div>
                    <div class="text-xs text-gray-500 font-bold uppercase tracking-widest">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Services -->
        @if(count($services) > 0)
        <section class="py-32 px-6 bg-gray-50">
            <div class="max-w-5xl mx-auto">
                <div class="grid md:grid-cols-3 gap-12">
                    <div class="md:col-span-1" data-aos="fade-right">
                        <h2 class="text-4xl font-black tracking-tight mb-4">Chuyên<br>môn.</h2>
                        <div class="w-12 h-1 bg-black mb-6"></div>
                        <p class="text-gray-500 leading-relaxed text-sm">
                            Tập trung vào các giải pháp thiết yếu và tác động chiến lược.
                        </p>
                    </div>
                    <div class="md:col-span-2 grid sm:grid-cols-2 gap-8">
                        @foreach($services as $index => $svc)
                        <div class="group bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition duration-300" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="w-14 h-14 flex items-center justify-center bg-gray-100 rounded-xl mb-5 text-2xl text-gray-700 group-hover:bg-black group-hover:text-white transition duration-300">
                                <i class="{{ $svc['icon'] }}"></i>
                            </div>
                            <h3 class="text-lg font-bold mb-2">{{ $svc['title'] }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">{{ $svc['description'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- Quote -->
        @if($quoteText)
        <section class="py-32 bg-black text-white px-6 text-center">
            <div class="max-w-3xl mx-auto" data-aos="zoom-in">
                <p class="text-3xl md:text-5xl font-serif italic leading-tight mb-8 opacity-90">
                    "{{ $quoteText }}"
                </p>
                <cite class="text-sm font-bold uppercase tracking-widest opacity-50 not-italic">
                    — {{ $quoteAuthor }}
                </cite>
            </div>
        </section>
        @endif

        <!-- Experience -->
        @if(count($experience) > 0)
        <section class="py-32 px-6 bg-white">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-center text-4xl font-black mb-16">Kinh nghiệm</h2>
                
                <div class="space-y-0">
                    @foreach($experience as $index => $exp)
                    <div class="flex flex-col sm:flex-row gap-6 sm:gap-12 group py-10 border-b border-gray-100 last:border-0" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <div class="sm:w-1/4 pt-1">
                            <span class="text-3xl font-black text-gray-200 group-hover:text-black transition">{{ $exp['year'] }}</span>
                        </div>
                        <div class="sm:w-3/4">
                            <h3 class="text-xl font-bold mb-1">{{ $exp['title'] }}</h3>
                            <div class="text-sm font-semibold uppercase text-gray-400 mb-4">{{ $exp['company'] }}</div>
                            <p class="text-gray-600 leading-relaxed">{{ $exp['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Minimal Footer -->
        <footer class="py-16 border-t border-gray-100 text-center bg-gray-50">
            <div class="font-black text-2xl mb-3">{{ $card->company }}</div>
            <div class="text-gray-400 text-sm">© {{ date('Y') }}. Đơn giản là tinh tế nhất.</div>
        </footer>
    </div>
@endsection
