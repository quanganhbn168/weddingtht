{{-- DA05 VIP: Section 2 - Invitation + Family Info (Lines 116-205) --}}
@props(['wedding', 'side' => 'both'])
@php
    $isBride = $side === 'bride';
    $firstName = $isBride ? $wedding->bride_name : $wedding->groom_name;
    $secondName = $isBride ? $wedding->groom_name : $wedding->bride_name;

    if ($isBride) {
        $mainTime = $wedding->bride_ceremony_time ?? $wedding->bride_reception_time;
        $mainDate = $wedding->bride_ceremony_date ?? $wedding->bride_reception_date ?? $wedding->event_date;
        $mainVenue = $wedding->bride_reception_venue ?? $wedding->bride_address;
        $mainAddress = $wedding->bride_address;
        $mainMapUrl = $wedding->bride_ceremony_map_url ?? $wedding->bride_map_url;
    } else {
        $mainTime = $wedding->groom_ceremony_time ?? $wedding->groom_reception_time;
        $mainDate = $wedding->groom_ceremony_date ?? $wedding->groom_reception_date ?? $wedding->event_date;
        $mainVenue = $wedding->groom_reception_venue ?? $wedding->groom_address;
        $mainAddress = $wedding->groom_address;
        $mainMapUrl = $wedding->groom_ceremony_map_url ?? $wedding->groom_map_url;
    }
@endphp

<section class="py-12 px-6 bg-cream text-center relative watercolor-overlay bg-main-watercolor" data-aos="fade-up">
    <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 left-0" alt="">
    <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 right-0 rotate-180" alt="">

    {{-- Family Info Grid: Nhà Trai | Nhà Gái --}}
    <div class="grid grid-cols-2 gap-4 mb-10 max-w-sm mx-auto" data-aos="fade-up">
        {{-- Nhà Trai --}}
        <div class="text-center">
            <p class="font-display text-sm font-bold text-gold tracking-wider mb-2">Nhà Trai</p>
            <p class="text-xs text-gray-600 font-semibold">{{ $wedding->groom_father }}</p>
            <p class="text-xs text-gray-600 font-semibold mb-2">{{ $wedding->groom_mother }}</p>
            <p class="text-[10px] text-gray-400 italic leading-tight mb-3">{{ $wedding->groom_address }}</p>
            @if($wedding->groom_ceremony_map_url)
            <a href="{{ $wedding->groom_ceremony_map_url }}" target="_blank" class="inline-block border border-gold/40 rounded-full px-4 py-1.5 text-[10px] font-bold text-gold tracking-wider hover:bg-gold/10 transition uppercase">Xem chỉ đường</a>
            @endif
        </div>
        {{-- Nhà Gái --}}
        <div class="text-center">
            <p class="font-display text-sm font-bold text-gold tracking-wider mb-2">Nhà Gái</p>
            <p class="text-xs text-gray-600 font-semibold">{{ $wedding->bride_father }}</p>
            <p class="text-xs text-gray-600 font-semibold mb-2">{{ $wedding->bride_mother }}</p>
            <p class="text-[10px] text-gray-400 italic leading-tight mb-3">{{ $wedding->bride_address }}</p>
            @if($wedding->bride_ceremony_map_url)
            <a href="{{ $wedding->bride_ceremony_map_url }}" target="_blank" class="inline-block border border-gold/40 rounded-full px-4 py-1.5 text-[10px] font-bold text-gold tracking-wider hover:bg-gold/10 transition uppercase">Xem chỉ đường</a>
            @endif
        </div>
    </div>

    {{-- Separator --}}
    <div class="separator mb-8"></div>

    {{-- Formal Invitation Text --}}
    <p class="font-display text-base tracking-[0.15em] uppercase text-gray-600 font-bold mb-2" data-aos="fade-up">Trân Trọng Kính Mời</p>
    <p class="font-script text-xl text-gold mb-1" data-aos="fade-up" data-aos-delay="100">Bạn và người thương</p>
    <p class="text-xs tracking-[0.1em] text-gray-400 mb-8 font-medium">Đến dự buổi tiệc chung vui cùng gia đình chúng tôi</p>

    {{-- Couple Names --}}
    <div class="mb-8">
        <h2 class="font-script text-5xl text-gold mb-2" data-aos="fade-down">{{ $firstName }}</h2>
        <p class="font-display text-2xl text-rose italic">and</p>
        <h2 class="font-script text-5xl text-gold mt-2" data-aos="fade-up">{{ $secondName }}</h2>
    </div>

    {{-- Ceremony Time --}}
    <p class="text-xs italic text-gray-400 mb-4">Hôn lễ được tổ chức vào lúc</p>
    <div class="border-y border-gold/20 py-5 max-w-xs mx-auto mb-8">
        <p class="font-display text-3xl tracking-widest text-gold font-bold">
            {{ $mainTime ? \Carbon\Carbon::parse($mainTime)->format('H:i') : '' }}
            – {{ $mainDate ? mb_strtoupper(\Carbon\Carbon::parse($mainDate)->translatedFormat('l')) : '' }}
        </p>
        <p class="font-display text-4xl text-gold font-bold mt-2">{{ $mainDate?->format('d.m.Y') }}</p>
    </div>

    {{-- Venue Info --}}
    @if($mainVenue)
    <div class="border-t border-gold/20 pt-6">
        <p class="text-xs italic text-gray-400 mb-3">Địa điểm:</p>
        <p class="font-display text-xl font-bold text-gray-700 leading-snug">{{ $mainVenue }}</p>
        <p class="text-sm italic text-gray-500 mt-2">{{ $mainAddress }}</p>
    </div>
    @endif

    {{-- Map Link --}}
    @if($mainMapUrl)
    <a href="{{ $mainMapUrl }}" target="_blank" class="inline-flex items-center gap-2 mt-8 text-gold hover:scale-105 transition group">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
        <span class="font-display text-sm font-bold tracking-[0.15em] uppercase group-hover:underline">Chỉ Đường</span>
    </a>
    @endif
</section>
