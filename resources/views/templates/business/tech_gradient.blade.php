{{-- 
Template Name: Tech Gradient (Công Nghệ)
Type: business
Description: Giao diện hiện đại, gradient chuyển màu, ảnh lớn không khung.
--}}
@extends('layouts.business')

@section('title', $card->name)

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&display=swap');
    
    .tech-gradient-theme {
        font-family: 'Rajdhani', sans-serif;
        background-color: #0f172a;
        color: white;
    }
    .tech-gradient-theme .tech-bg { background: radial-gradient(circle at 50% 50%, #1e1b4b, #020617); }
    .tech-gradient-theme .text-glow { text-shadow: 0 0 10px rgba(56, 189, 248, 0.5); }
    .tech-gradient-theme .border-glow { box-shadow: 0 0 15px rgba(56, 189, 248, 0.2); }
    .tech-gradient-theme .circuit-pattern {
        background-image: radial-gradient(#38bdf8 1px, transparent 1px);
        background-size: 30px 30px;
        opacity: 0.08;
    }
</style>
@endpush

@section('content')
    <div class="tech-gradient-theme tech-bg min-h-screen relative overflow-hidden">
        <div class="absolute inset-0 circuit-pattern pointer-events-none"></div>
        
        <!-- Navbar -->
        <nav class="fixed top-0 w-full z-50 py-4 bg-gradient-to-b from-[#0f172a] to-transparent">
            <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
                <span class="font-bold text-xl tracking-wide text-cyan-400">{{ $card->company }}</span>
                <a href="tel:{{ $card->phone }}" class="px-5 py-2 rounded bg-cyan-500/20 border border-cyan-500/30 text-cyan-400 hover:bg-cyan-500 hover:text-white transition text-sm font-bold uppercase tracking-wider">
                    Liên hệ
                </a>
            </div>
        </nav>

        <!-- Hero with Floating Portrait -->
        <header class="min-h-screen relative flex items-end md:items-center pt-24 pb-16 md:pb-0">
            <!-- Glowing Orbs -->
            <div class="absolute top-20 right-10 w-[400px] h-[400px] bg-cyan-500/20 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="absolute bottom-20 left-10 w-[300px] h-[300px] bg-purple-600/20 rounded-full blur-[80px] pointer-events-none"></div>

            <div class="relative z-10 w-full max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row items-end md:items-center gap-12">
                    
                    <!-- Floating Portrait (No Frame) -->
                    <div class="md:w-1/2 order-1 flex justify-center relative" data-aos="fade-right" data-aos-duration="1200">
                        <!-- Glow Effect -->
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[300px] h-[300px] bg-cyan-500/30 rounded-full blur-[80px]"></div>
                        
                        @if($card->hasMedia('avatar'))
                            <img src="{{ $card->getFirstMediaUrl('avatar') }}" 
                                 class="relative z-10 max-h-[60vh] md:max-h-[85vh] w-auto object-contain drop-shadow-[0_20px_80px_rgba(56,189,248,0.4)]" 
                                 alt="{{ $card->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($card->name) }}&background=0ea5e9&color=000&size=512" 
                                 class="relative z-10 max-h-[60vh] md:max-h-[85vh] w-auto object-cover rounded-2xl" 
                                 alt="{{ $card->name }}">
                        @endif
                    </div>

                    <!-- Text Content -->
                    <div class="md:w-1/2 order-2 text-center md:text-left" data-aos="fade-left">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-cyan-900/30 border border-cyan-500/30 text-cyan-400 text-sm font-bold tracking-wider uppercase mb-6">
                            <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                            {{ $card->title }}
                        </div>
                        <h1 class="text-5xl md:text-7xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-purple-300 text-glow">
                            {{ $card->name }}
                        </h1>
                        <p class="text-slate-300 text-lg leading-relaxed mb-10 max-w-lg">{{ Str::limit(strip_tags($card->about), 180) }}</p>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 mb-10">
                            @foreach($card->social_links ?? [] as $link)
                            <a href="{{ $link['url'] }}" target="_blank" class="w-12 h-12 rounded-lg bg-slate-800 flex items-center justify-center text-cyan-400 hover:bg-cyan-500 hover:text-white transition duration-300 shadow-lg border border-white/5">
                                <i class="{{ match($link['platform']) { 'facebook' => 'fab fa-facebook-f', 'linkedin' => 'fab fa-linkedin-in', 'github' => 'fab fa-github', default => 'fas fa-link' } }}"></i>
                            </a>
                            @endforeach
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                            @if($card->phone)
                            <a href="tel:{{ $card->phone }}" class="px-8 py-4 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 transition shadow-lg shadow-cyan-900/50 font-bold tracking-wide flex items-center justify-center gap-3">
                                <i class="fas fa-phone"></i> GỌI NGAY
                            </a>
                            @endif
                            @if($card->email)
                            <a href="mailto:{{ $card->email }}" class="px-8 py-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition font-bold tracking-wide flex items-center justify-center gap-3">
                                <i class="fas fa-envelope"></i> GỬI EMAIL
                            </a>
                            @endif
                            @if($card->website)
                            <a href="{{ $card->website }}" target="_blank" class="px-8 py-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition font-bold tracking-wide flex items-center justify-center gap-3">
                                <i class="fas fa-globe"></i> WEBSITE
                            </a>
                            @endif
                        </div>
                        
                        @if($card->address)
                        <div class="mt-6 flex items-center justify-center md:justify-start gap-2 text-slate-400 text-sm">
                            <i class="fas fa-map-marker-alt text-cyan-400"></i>
                            <span>{{ $card->address }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats -->
        @if(!empty($stats))
        <section class="py-16 relative">
            <div class="max-w-5xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($stats as $index => $stat)
                <div class="bg-slate-900/50 border border-cyan-500/20 p-8 rounded-2xl text-center backdrop-blur-sm hover:border-cyan-500/50 transition" data-aos="flip-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="text-4xl font-bold text-cyan-400 mb-2 text-glow">{{ $stat['number'] }}</div>
                    <div class="text-xs text-slate-400 uppercase tracking-widest font-bold">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Services -->
        @if(count($services) > 0)
        <section class="py-24 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="flex items-center gap-4 mb-14">
                    <h2 class="text-3xl font-bold text-white uppercase tracking-wider">System <span class="text-cyan-500">Modules</span></h2>
                    <div class="h-px bg-gradient-to-r from-cyan-500/50 to-transparent flex-1"></div>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($services as $index => $svc)
                    <div class="bg-slate-900/80 border border-white/5 p-8 rounded-xl hover:border-cyan-500/50 transition duration-300 group relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="absolute inset-0 bg-cyan-500/5 translate-y-full group-hover:translate-y-0 transition duration-500"></div>
                        <div class="w-14 h-14 bg-slate-800 rounded-lg flex items-center justify-center text-cyan-400 text-2xl mb-6 group-hover:scale-110 transition relative z-10 border border-cyan-500/20">
                            <i class="{{ $svc['icon'] }}"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3 relative z-10">{{ $svc['title'] }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed relative z-10">{{ $svc['description'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Quote -->
        @if($quoteText)
        <section class="py-24 bg-slate-900/50 border-y border-white/5 relative">
            <div class="max-w-3xl mx-auto px-6 text-center" data-aos="zoom-in">
                <p class="text-2xl md:text-3xl font-light italic text-cyan-100 mb-8 leading-relaxed">
                    "{{ $quoteText }}"
                </p>
                <div class="inline-block px-5 py-2 rounded bg-cyan-900/30 text-cyan-400 text-sm font-bold uppercase tracking-widest border border-cyan-500/20">
                    {{ $quoteAuthor }}
                </div>
            </div>
        </section>
        @endif

        <!-- Experience -->
        @if(count($experience) > 0)
        <section class="py-24 px-6">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-white uppercase tracking-wider mb-14 text-center">Log Data</h2>
                
                <div class="space-y-8">
                    @foreach($experience as $index => $exp)
                    <div class="flex gap-6 items-start" data-aos="fade-left" data-aos-delay="{{ $index * 50 }}">
                        <div class="hidden md:flex flex-col items-center">
                            <div class="w-4 h-4 bg-cyan-500 rounded-full shadow-[0_0_15px_#0ea5e9]"></div>
                            <div class="w-px h-full bg-gradient-to-b from-cyan-500/50 to-transparent my-2 min-h-[80px]"></div>
                        </div>
                        <div class="flex-1 bg-white/5 border border-white/5 p-8 rounded-r-xl rounded-bl-xl hover:bg-white/10 transition">
                            <div class="flex flex-wrap justify-between items-start gap-4 mb-3">
                                <h3 class="text-xl font-bold text-white">{{ $exp['title'] }}</h3>
                                <span class="text-cyan-400 font-mono text-sm bg-cyan-900/20 px-3 py-1 rounded">{{ $exp['year'] }}</span>
                            </div>
                            <div class="text-slate-400 text-sm font-bold uppercase mb-3">{{ $exp['company'] }}</div>
                            <p class="text-slate-300 text-sm leading-relaxed">{{ $exp['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <footer class="py-12 text-center text-slate-600 text-sm font-mono border-t border-white/5 bg-slate-950">
            &lt;/&gt; {{ date('Y') }} {{ $card->company }}. SYSTEM ONLINE.
        </footer>
    </div>
@endsection
