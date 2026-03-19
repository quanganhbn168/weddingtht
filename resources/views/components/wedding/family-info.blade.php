@php
    $t = $theme ?? config('wedding-themes.default');
    $sd = $sideData;
@endphp

<section class="py-12 px-6 text-center relative" style="background: {{ $t['bg'] }}" data-aos="fade-up">
    {{ $decoration ?? '' }}

    {{-- Family Info Grid --}}
    <div class="grid grid-cols-2 gap-4 mb-10 max-w-sm mx-auto" data-aos="fade-up">
        {{-- Nhà Trai --}}
        <div class="text-center">
            <p style="font-family: {{ $t['font_display'] }}; color: {{ $t['primary'] }}" class="text-sm font-bold tracking-wider mb-2">Nhà Trai</p>
            <p class="text-xs font-semibold" style="color: {{ $t['text_muted'] }}">{{ $wedding->groom_father }}</p>
            <p class="text-xs font-semibold mb-2" style="color: {{ $t['text_muted'] }}">{{ $wedding->groom_mother }}</p>
            <p class="text-[10px] italic leading-tight mb-3" style="color: {{ $t['text_muted'] }}">{{ $wedding->groom_address }}</p>
            @if($wedding->groom_map_url)
            <a href="{{ $wedding->groom_map_url }}" target="_blank"
               class="inline-block border px-4 py-1.5 text-[10px] font-bold tracking-wider hover:opacity-80 transition uppercase"
               style="border-color: {{ $t['primary'] }}40; color: {{ $t['primary'] }}; border-radius: 9999px;">
                Xem chỉ đường
            </a>
            @endif
        </div>
        {{-- Nhà Gái --}}
        <div class="text-center">
            <p style="font-family: {{ $t['font_display'] }}; color: {{ $t['primary'] }}" class="text-sm font-bold tracking-wider mb-2">Nhà Gái</p>
            <p class="text-xs font-semibold" style="color: {{ $t['text_muted'] }}">{{ $wedding->bride_father }}</p>
            <p class="text-xs font-semibold mb-2" style="color: {{ $t['text_muted'] }}">{{ $wedding->bride_mother }}</p>
            <p class="text-[10px] italic leading-tight mb-3" style="color: {{ $t['text_muted'] }}">{{ $wedding->bride_address }}</p>
            @if($wedding->bride_map_url)
            <a href="{{ $wedding->bride_map_url }}" target="_blank"
               class="inline-block border px-4 py-1.5 text-[10px] font-bold tracking-wider hover:opacity-80 transition uppercase"
               style="border-color: {{ $t['primary'] }}40; color: {{ $t['primary'] }}; border-radius: 9999px;">
                Xem chỉ đường
            </a>
            @endif
        </div>
    </div>

    {{-- Separator --}}
    <div class="wc-separator mb-8">
        <span style="background: linear-gradient(to right, transparent, {{ $t['primary'] }}, transparent); width: 60px; height: 1px; display: block;"></span>
    </div>

    {{-- Formal Invitation Text --}}
    <p style="font-family: {{ $t['font_display'] }}; color: {{ $t['text_muted'] }}" class="text-base tracking-[0.15em] uppercase font-bold mb-2" data-aos="fade-up">Trân Trọng Kính Mời</p>
    <p style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}" class="text-xl mb-1" data-aos="fade-up" data-aos-delay="100">Bạn và người thương</p>
    <p class="text-xs tracking-[0.1em] mb-8 font-medium" style="color: {{ $t['text_muted'] }}">Đến dự buổi tiệc chung vui cùng gia đình chúng tôi</p>

    {{-- Couple Names --}}
    <div class="mb-8">
        <h2 style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}" class="text-5xl mb-2" data-aos="fade-down">{{ $sd->firstName }}</h2>
        <p style="font-family: {{ $t['font_display'] }}; color: {{ $t['accent'] }}" class="text-2xl italic">and</p>
        <h2 style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}" class="text-5xl mt-2" data-aos="fade-up">{{ $sd->secondName }}</h2>
    </div>

    {{-- Ceremony Time --}}
    @php
        $mainTime = $sd->mainCeremonyTime ?? $sd->mainReceptionTime;
        $mainDate = $sd->mainCeremonyDate ?? $sd->mainReceptionDate ?? $wedding->event_date;
    @endphp
    @if($mainTime || $mainDate)
    <p class="text-xs italic mb-4" style="color: {{ $t['text_muted'] }}">Hôn lễ được tổ chức vào lúc</p>
    <div class="border-y py-5 max-w-xs mx-auto mb-8" style="border-color: {{ $t['primary'] }}20">
        <p style="font-family: {{ $t['font_display'] }}; color: {{ $t['primary'] }}" class="text-3xl tracking-widest font-bold">
            @if($mainTime) {{ \Carbon\Carbon::parse($mainTime)->format('H:i') }} @endif
            @if($mainDate) – {{ mb_strtoupper(\Carbon\Carbon::parse($mainDate)->translatedFormat('l')) }} @endif
        </p>
        @if($mainDate)
        <p style="font-family: {{ $t['font_display'] }}; color: {{ $t['primary'] }}" class="text-4xl font-bold mt-2">{{ \Carbon\Carbon::parse($mainDate)->format('d.m.Y') }}</p>
        @endif
    </div>
    @endif

    {{-- Venue Info --}}
    @if($sd->mainVenue)
    <div class="border-t pt-6" style="border-color: {{ $t['primary'] }}20">
        <p class="text-xs italic mb-3" style="color: {{ $t['text_muted'] }}">Địa điểm:</p>
        <p style="font-family: {{ $t['font_display'] }}; color: {{ $t['text'] }}" class="text-xl font-bold leading-snug">{{ $sd->mainVenue }}</p>
        @if($sd->mainAddress)
        <p class="text-sm italic mt-2" style="color: {{ $t['text_muted'] }}">{{ $sd->mainAddress }}</p>
        @endif
    </div>
    @endif

    {{-- Map Link --}}
    @if($sd->mainMapUrl)
    <a href="{{ $sd->mainMapUrl }}" target="_blank" class="inline-flex items-center gap-2 mt-8 hover:scale-105 transition group" style="color: {{ $t['primary'] }}">
        <i class="fa-solid fa-location-dot text-lg"></i>
        <span style="font-family: {{ $t['font_display'] }}" class="text-sm font-bold tracking-[0.15em] uppercase group-hover:underline">Chỉ Đường</span>
    </a>
    @endif
</section>
