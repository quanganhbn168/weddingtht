{{-- 
Template Name: Corporate Blue (Doanh Nghiệp)
Type: business
Description: Chuyên nghiệp, tin cậy, ảnh lớn không khung.
--}}
@extends('layouts.business')

@section('title', $card->name)

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
    
    .corporate-blue-theme {
        font-family: 'Roboto', sans-serif;
        background-color: #f8fafc;
    }
    .corporate-blue-theme .bg-corporate { background-color: #1e3a8a; }
    .corporate-blue-theme .text-corporate { color: #1e3a8a; }
</style>
@endpush

@section('content')
    <div class="corporate-blue-theme min-h-screen">
        
        <!-- Top Bar -->
        <div class="bg-corporate text-white py-2">
            <div class="max-w-6xl mx-auto px-6 flex justify-between items-center text-sm">
                <span class="font-medium">{{ $card->company }}</span>
                <div class="flex gap-6">
                    @if($card->email) <a href="mailto:{{ $card->email }}" class="hover:text-blue-200 transition"><i class="fas fa-envelope mr-1"></i> {{ $card->email }}</a> @endif
                    @if($card->phone) <a href="tel:{{ $card->phone }}" class="hover:text-blue-200 transition"><i class="fas fa-phone mr-1"></i> {{ $card->phone }}</a> @endif
                </div>
            </div>
        </div>

        <!-- Hero with Background + Portrait -->
        <header class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-white to-blue-50">
            <!-- Background Pattern -->
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-100/50 rounded-full blur-[100px]"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-slate-100 rounded-full blur-[80px]"></div>
            </div>
            
            <div class="max-w-6xl mx-auto px-6 py-16 md:py-24 relative z-10">
                <div class="flex flex-col md:flex-row items-end md:items-center gap-12">
                    
                    <!-- Portrait (Frameless) -->
                    <div class="md:w-2/5 order-1 flex justify-center relative" data-aos="fade-right" data-aos-duration="1000">
                        <!-- Shadow/Glow -->
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[80%] h-20 bg-[#1e3a8a]/10 rounded-full blur-2xl"></div>
                        
                        @if($card->hasMedia('avatar'))
                            <img src="{{ $card->getFirstMediaUrl('avatar') }}" 
                                 class="relative z-10 max-h-[50vh] md:max-h-[70vh] w-auto object-contain drop-shadow-[0_25px_50px_rgba(30,58,138,0.2)]" 
                                 alt="{{ $card->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($card->name) }}&background=1e3a8a&color=fff&size=512" 
                                 class="relative z-10 max-h-[50vh] md:max-h-[70vh] w-auto object-cover rounded-2xl" 
                                 alt="{{ $card->name }}">
                        @endif
                    </div>

                    <!-- Text Content -->
                    <div class="md:w-3/5 order-2" data-aos="fade-left">
                        <span class="text-corporate font-bold uppercase tracking-wider text-sm bg-blue-50 px-4 py-2 rounded-lg mb-6 inline-block border border-blue-100">
                            {{ $card->title }}
                        </span>
                        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">{{ $card->name }}</h1>
                        
                        <div class="text-gray-600 leading-relaxed mb-8 text-lg max-w-xl">
                            {!! $card->about !!}
                        </div>

                        <div class="flex flex-wrap gap-3">
                            @foreach($card->social_links ?? [] as $link)
                            <a href="{{ $link['url'] }}" target="_blank" class="px-5 py-3 bg-white shadow-sm hover:bg-corporate hover:text-white rounded-lg text-gray-700 transition font-medium text-sm flex items-center gap-2 border border-gray-100">
                                <i class="{{ match($link['platform']) { 'facebook' => 'fab fa-facebook-f', 'linkedin' => 'fab fa-linkedin-in', 'website' => 'fas fa-globe', default => 'fas fa-link' } }}"></i>
                                {{ $link['label'] ?? ucfirst($link['platform']) }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        @if(!empty($stats))
        <section class="bg-corporate text-white py-14">
            <div class="max-w-5xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach($stats as $index => $stat)
                <div class="text-center border-r border-blue-800 last:border-0" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="text-4xl font-bold mb-1">{{ $stat['number'] }}</div>
                    <div class="text-blue-200 text-sm font-medium uppercase tracking-wider">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Services -->
        @if(count($services) > 0)
        <section class="py-24 max-w-5xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Lĩnh vực hoạt động</h2>
                <div class="w-16 h-1 bg-corporate mx-auto mt-4"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($services as $index => $svc)
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-blue-100 transition duration-300 group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="w-14 h-14 bg-blue-50 text-corporate rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:bg-corporate group-hover:text-white transition">
                        <i class="{{ $svc['icon'] }}"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $svc['title'] }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $svc['description'] }}</p>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Quote -->
        @if($quoteText)
        <section class="py-24 bg-slate-100 relative">
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <i class="fas fa-quote-left text-5xl text-slate-300 mb-8"></i>
                <blockquote class="text-2xl md:text-3xl font-light text-gray-800 italic mb-8 leading-relaxed">
                    "{{ $quoteText }}"
                </blockquote>
                <cite class="not-italic font-bold text-corporate text-lg">– {{ $quoteAuthor }}</cite>
            </div>
        </section>
        @endif

        <!-- Experience Table -->
        @if(count($experience) > 0)
        <section class="py-24 max-w-5xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-900 mb-12">Kinh nghiệm làm việc</h2>
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @foreach($experience as $index => $exp)
                <div class="flex flex-col md:flex-row border-b border-gray-100 last:border-0 hover:bg-blue-50/30 transition" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="p-8 md:w-1/4 bg-slate-50 flex items-center justify-center md:justify-start font-bold text-corporate text-xl">
                        {{ $exp['year'] }}
                    </div>
                    <div class="p-8 md:w-3/4">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $exp['title'] }}</h3>
                        <div class="text-gray-500 font-medium mb-3">{{ $exp['company'] }}</div>
                        <p class="text-gray-600">{{ $exp['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-12 text-center">
             <div class="max-w-4xl mx-auto px-6">
                <div class="mb-4 font-bold text-gray-900 text-xl">{{ $card->company }}</div>
                @if($card->address)
                <div class="flex items-center justify-center gap-2 text-gray-500 mb-4">
                    <i class="fas fa-map-marker-alt text-corporate"></i>
                    <span>{{ $card->address }}</span>
                </div>
                @endif
                <div class="flex justify-center gap-6 mb-4">
                    @if($card->phone)<a href="tel:{{ $card->phone }}" class="text-gray-500 hover:text-corporate transition"><i class="fas fa-phone mr-1"></i> {{ $card->phone }}</a>@endif
                    @if($card->email)<a href="mailto:{{ $card->email }}" class="text-gray-500 hover:text-corporate transition"><i class="fas fa-envelope mr-1"></i> {{ $card->email }}</a>@endif
                    @if($card->website)<a href="{{ $card->website }}" target="_blank" class="text-gray-500 hover:text-corporate transition"><i class="fas fa-globe mr-1"></i> Website</a>@endif
                </div>
                <div class="text-sm text-gray-500">
                    &copy; {{ date('Y') }}. All professional rights reserved.
                </div>
            </div>
        </footer>

    </div>
@endsection
