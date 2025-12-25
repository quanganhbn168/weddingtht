{{-- 
Template Name: CEO Profile (Premium Landing) 
Type: business
Description: Giao diện Landing Page cao cấp cho doanh nhân.
--}}
@extends('layouts.business')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        gold: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gold-gradient { background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%); }
        .text-gradient { background: linear-gradient(135deg, #f59e0b 0%, #fff 50%, #b45309 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        body { background-color: #0f172a; color: white; } /* Default dark theme for this template */
    </style>
@endpush

@section('content')
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-slate-900/80 backdrop-blur-md border-b border-white/5 transition-all duration-300" id="navbar">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <span class="font-serif text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-gold-600">
                {{ $card->company ?? 'Business Profile' }}
            </span>
            <a href="#contact" class="hidden md:inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white transition-all duration-200 bg-white/10 rounded-full hover:bg-gold-500 hover:text-black hover:shadow-[0_0_20px_rgba(245,158,11,0.5)]">
                Liên hệ
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative pt-40 pb-32 overflow-hidden flex items-center justify-center min-h-screen">
        <!-- Animated Background -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-gold-600/20 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-900/20 rounded-full blur-[120px] animate-pulse" style="animation-duration: 4s;"></div>
        </div>
        
        <div class="relative z-10 max-w-4xl mx-auto text-center px-6">
             <!-- Avatar -->
            <div class="mb-10 relative inline-block group" data-aos="zoom-in" data-aos-duration="1000">
                <div class="absolute inset-0 bg-gradient-to-tr from-gold-400 to-amber-700 blur-2xl opacity-40 rounded-full group-hover:opacity-60 transition duration-700"></div>
                <div class="relative w-48 h-48 md:w-64 md:h-64 p-1 rounded-full bg-gradient-to-tr from-gold-300 to-slate-800">
                    <div class="w-full h-full rounded-full overflow-hidden border-4 border-slate-900 bg-slate-800">
                         @if($card->hasMedia('avatar'))
                            <img src="{{ $card->getFirstMediaUrl('avatar') }}" class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($card->name) }}&background=0f172a&color=f59e0b&size=512" class="w-full h-full object-cover">
                        @endif
                    </div>
                </div>
                <!-- Premium Badge -->
                <div class="absolute bottom-2 right-6 w-8 h-8 bg-blue-500 border-4 border-slate-900 rounded-full flex items-center justify-center text-white text-xs shadow-lg" title="Verified">
                    <i class="fas fa-check"></i>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="200">
                <span class="inline-block py-1 px-3 rounded-full bg-gold-500/10 border border-gold-500/20 text-gold-400 text-sm font-semibold tracking-wider uppercase mb-4">
                    {{ $card->title }}
                </span>
                <h1 class="font-serif text-5xl md:text-7xl font-bold text-white leading-tight tracking-tight mb-6">
                    {{ $card->name }}
                </h1>
                 <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto font-light leading-relaxed">
                    {{ strip_tags(Str::limit($card->about, 120)) }}
                </p>
            </div>
            
            <div class="flex flex-wrap justify-center gap-5 mt-10" data-aos="fade-up" data-aos-delay="400">
                @if($card->phone)
                    <a href="tel:{{ $card->phone }}" class="group relative px-8 py-4 bg-gold-500 text-black font-bold rounded-full overflow-hidden shadow-[0_0_30px_rgba(245,158,11,0.3)] transition-all hover:scale-105 hover:shadow-[0_0_50px_rgba(245,158,11,0.6)]">
                        <span class="relative z-10 flex items-center gap-2">
                            <i class="fas fa-phone-alt"></i> Gọi điện
                        </span>
                        <div class="absolute inset-0 bg-white/30 transform -translate-x-full skew-x-12 group-hover:animate-shine"></div>
                    </a>
                @endif
                @if($card->email)
                    <a href="mailto:{{ $card->email }}" class="px-8 py-4 bg-white/5 border border-white/10 text-white font-bold rounded-full hover:bg-white/10 hover:border-white/30 transition-all backdrop-blur-sm flex items-center gap-2">
                        <i class="fas fa-envelope"></i> Gửi Email
                    </a>
                @endif
                @if($card->website)
                    <a href="{{ $card->website }}" target="_blank" class="px-8 py-4 bg-white/5 border border-white/10 text-white font-bold rounded-full hover:bg-white/10 hover:border-white/30 transition-all backdrop-blur-sm flex items-center gap-2">
                        <i class="fas fa-globe"></i> Website
                    </a>
                @endif
            </div>

            <!-- Socials -->
            @if(!empty($card->social_links))
            <div class="flex justify-center gap-6 mt-16" data-aos="fade-up" data-aos-delay="600">
                @foreach($card->social_links as $link)
                    @php
                        $icon = match($link['platform']) {
                            'facebook' => 'fab fa-facebook-f',
                            'zalo' => 'fas fa-comment-dots',
                            'tiktok' => 'fab fa-tiktok',
                            'linkedin' => 'fab fa-linkedin-in',
                            'youtube' => 'fab fa-youtube',
                            'bank' => 'fas fa-university',
                            default => 'fas fa-link'
                        };
                    @endphp
                    <a href="{{ $link['url'] }}" target="_blank" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-gold-600 hover:border-gold-600 transition-all duration-300 transform hover:-translate-y-1">
                        <i class="{{ $icon }} text-lg"></i>
                    </a>
                @endforeach
            </div>
            @endif
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce text-slate-500">
            <i class="fas fa-chevron-down"></i>
        </div>
    </header>

    @php
        $content = $card->content ?? [];
        $services = $content['services'] ?? [];
        $experience = $content['experience'] ?? [];
        $stats = $content['stats'] ?? [
            ['number' => '10+', 'label' => 'Năm kinh nghiệm'],
            ['number' => '100+', 'label' => 'Dự án'],
            ['number' => '50+', 'label' => 'Đối tác'],
            ['number' => '100%', 'label' => 'Hài lòng']
        ];
        $quoteText = $content['quote_text'] ?? "Thành công không phải là đích đến, mà là hành trình của sự kiên trì và đổi mới không ngừng.";
        $quoteAuthor = $content['quote_author'] ?? $card->name;
    @endphp

    <!-- About Section (Full Text) -->
    @if($card->about)
    <section class="py-32 bg-slate-900 relative">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-white/5 backdrop-blur-xl border border-white/5 rounded-3xl p-8 md:p-12 relative overflow-hidden" data-aos="fade-up">
                 <!-- Decorative quote -->
                <div class="absolute top-4 left-4 text-7xl text-gold-500/20 font-serif">“</div>
                
                <h3 class="font-serif text-4xl text-gold-500 mb-10 relative z-10">Câu chuyện thương hiệu</h3>
                <div class="prose prose-invert prose-xl text-slate-300 relative z-10 leading-loose">
                    {!! $card->about !!}
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Stats Section - Break the flow -->
    @if(!empty($stats))
    <section class="py-20 bg-slate-900 border-y border-white/5">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach($stats as $index => $stat)
            <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="text-4xl md:text-5xl font-bold text-white mb-2 counter">{{ $stat['number'] }}</div>
                <div class="text-gold-500 text-sm tracking-widest uppercase">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Services Section -->
    @if(count($services) > 0)
    <section class="py-32 bg-slate-800/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20" data-aos="fade-up">
                <span class="text-gold-500 tracking-widest text-sm font-bold uppercase">Expertise</span>
                <h3 class="font-serif text-4xl md:text-6xl font-bold mt-2 text-white">Dịch vụ & Giải pháp</h3>
                <div class="w-24 h-1 bg-gold-500 mx-auto mt-8 rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($services as $index => $svc)
                <div class="group bg-slate-900 border border-white/5 p-10 rounded-3xl hover:border-gold-500/30 hover:bg-slate-800 transition-all duration-500 relative flex flex-col min-h-[300px]" 
                     data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="absolute inset-0 bg-gradient-to-br from-gold-500/5 to-transparent opacity-0 group-hover:opacity-100 transition duration-500 rounded-3xl"></div>
                    
                    <div class="w-16 h-16 rounded-2xl bg-slate-800 border border-white/10 flex items-center justify-center text-gold-500 text-3xl mb-8 shadow-xl group-hover:scale-110 group-hover:bg-gold-500 group-hover:text-black transition duration-500 relative z-10">
                        <i class="{{ $svc['icon'] ?? 'fas fa-star' }}"></i>
                    </div>
                    
                    <h4 class="text-2xl font-bold mb-4 text-white group-hover:text-gold-400 transition relative z-10">{{ $svc['title'] }}</h4>
                    <p class="text-slate-400 text-lg leading-relaxed relative z-10 flex-grow">{{ $svc['description'] }}</p>
                    
                    <div class="mt-6 pt-6 border-t border-white/5 relative z-10">
                         <span class="text-sm font-bold text-gold-600 group-hover:text-gold-400 uppercase tracking-wider">Xem chi tiết <i class="fas fa-arrow-right ml-2"></i></span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Quote Parallax Separator -->
    @if($quoteText)
    <section class="py-32 relative bg-fixed bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80');">
        <div class="absolute inset-0 bg-black/80"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
            <i class="fas fa-quote-left text-5xl text-gold-500 mb-8 block"></i>
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-white leading-tight mb-8" data-aos="fade-up">
                "{!! $quoteText !!}"
            </h2>
            <cite class="text-gold-400 text-xl font-style-normal not-italic tracking-wider uppercase" data-aos="fade-up" data-aos-delay="100">- {{ $quoteAuthor }}</cite>
        </div>
    </section>
    @endif

    <!-- Experience Timeline -->
    @if(count($experience) > 0)
    <section class="py-24 bg-slate-900 relative">
        <div class="max-w-4xl mx-auto px-6">
             <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-gold-500 tracking-widest text-sm font-bold uppercase">Journey</span>
                <h3 class="font-serif text-3xl md:text-5xl font-bold mt-2 text-white">Chặng đường</h3>
            </div>

            <div class="space-y-12 relative">
                <!-- Vertical Line -->
                <div class="absolute left-[27px] top-4 bottom-4 w-0.5 bg-gradient-to-b from-gold-500/20 via-gold-500/50 to-transparent"></div>

                @foreach($experience as $index => $exp)
                <div class="flex gap-8 relative" data-aos="fade-right" data-aos-delay="{{ $index * 150 }}">
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-14 h-14 rounded-full bg-slate-900 border-2 border-gold-500/30 flex items-center justify-center relative z-10 shadow-[0_0_15px_rgba(245,158,11,0.1)]">
                             <div class="w-3 h-3 bg-gold-500 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                    <div class="bg-white/5 border border-white/5 p-6 rounded-2xl flex-1 hover:border-gold-500/20 transition duration-300">
                        <span class="inline-block py-1 px-3 rounded bg-gold-500/20 text-gold-400 text-xs font-bold mb-2 font-mono">
                            {{ $exp['year'] }}
                        </span>
                        <h4 class="text-xl font-bold text-white mb-1">{{ $exp['title'] }}</h4>
                        <p class="text-slate-400 text-sm font-medium mb-3 flex items-center gap-2">
                            <i class="fas fa-building text-gold-500/50"></i> {{ $exp['company'] }}
                        </p>
                        <p class="text-slate-300 leading-relaxed">{{ $exp['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA / Contact -->
    <footer id="contact" class="py-24 bg-black relative border-t border-white/10">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <h2 class="font-serif text-4xl md:text-5xl mb-8 text-white font-bold" data-aos="fade-up">Sẵn sàng hợp tác?</h2>
            <p class="text-slate-400 mb-12 text-lg" data-aos="fade-up" data-aos-delay="100">Liên hệ với tôi ngay hôm nay để thảo luận về dự án của bạn.</p>
            
            @if($card->address)
            <div class="mb-8 text-slate-400 flex items-center justify-center gap-2" data-aos="fade-up" data-aos-delay="150">
                <i class="fas fa-map-marker-alt text-gold-500"></i>
                <span>{{ $card->address }}</span>
            </div>
            @endif
            
            <div class="flex flex-col md:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="200">
                 @if($card->phone)
                <a href="tel:{{ $card->phone }}" class="flex-1 bg-white text-slate-900 py-4 px-8 rounded-xl font-bold hover:bg-gold-400 hover:shadow-lg transition text-lg">
                    <i class="fas fa-phone mr-2"></i> {{ $card->phone }}
                </a>
                @endif
                @if($card->email)
                <a href="mailto:{{ $card->email }}" class="flex-1 bg-slate-800 border border-slate-700 py-4 px-8 rounded-xl font-bold hover:bg-slate-700 hover:border-white/20 transition text-lg">
                    <i class="fas fa-envelope mr-2"></i> Gửi Email
                </a>
                @endif
                @if($card->website)
                <a href="{{ $card->website }}" target="_blank" class="flex-1 bg-slate-800 border border-slate-700 py-4 px-8 rounded-xl font-bold hover:bg-slate-700 hover:border-white/20 transition text-lg">
                    <i class="fas fa-globe mr-2"></i> Website
                </a>
                @endif
            </div>
            
             <div class="mt-16 pt-8 border-t border-white/10 opacity-40 text-sm">
                &copy; {{ date('Y') }} {{ $card->company }}. All rights reserved.
            </div>
        </div>
    </footer>
@endsection
