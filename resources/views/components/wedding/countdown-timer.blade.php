{{-- 
    SHARED: Countdown Timer Component
    Usage: <x-wedding.countdown-timer :wedding="$wedding" :side="$side" />
    Theming: Uses CSS vars from template's :root
--}}
@props(['wedding', 'side' => 'both'])
@php
    $isBride = $side === 'bride';
    $firstName = $isBride ? $wedding->bride_name : $wedding->groom_name;
    $secondName = $isBride ? $wedding->groom_name : $wedding->bride_name;
    // Lấy chữ đầu của TÊN (từ cuối trong họ tên tiếng Việt)
    $firstInitial = mb_strtoupper(mb_substr(trim(strrchr(' ' . trim($firstName), ' ')), 0, 1));
    $secondInitial = mb_strtoupper(mb_substr(trim(strrchr(' ' . trim($secondName), ' ')), 0, 1));
@endphp

@if($wedding->event_date)
<div class="text-center">
    {{-- Couple Monogram --}}
    <div class="mb-8" data-aos="zoom-in">
        <div class="relative inline-block">
            <span class="font-display text-8xl font-bold text-gold tracking-tight">{{ $firstInitial }}</span>
            <span class="font-display text-8xl font-bold text-gold tracking-tight">{{ $secondInitial }}</span>
        </div>
        <p class="font-script text-lg text-gold/80 -mt-2">{{ $firstName }} & {{ $secondName }}</p>
        <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 mt-1 font-bold">Happy Wedding</p>
    </div>

    {{-- Countdown Heading --}}
    <p class="font-display text-sm tracking-[0.2em] uppercase text-gray-500 mb-1 font-bold" data-aos="fade-up">We will come</p>
    <p class="font-display text-base tracking-[0.15em] uppercase text-gray-600 mb-8 font-bold" data-aos="fade-up">Husband and Wife in</p>

    {{-- Countdown Timer --}}
    <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d H:i:s') }}')" class="grid grid-cols-4 gap-4 max-w-sm mx-auto mb-12" data-aos="fade-up">
        @foreach([['days','Ngày'],['hours','Giờ'],['minutes','Phút'],['seconds','Giây']] as $c)
        <div class="text-center">
            <div class="font-display text-5xl font-bold text-gold" x-text="{{ $c[0] }}">00</div>
            <div class="text-xs text-gray-400 uppercase font-bold tracking-widest mt-1">{{ $c[1] }}</div>
        </div>
        @endforeach
    </div>
</div>
@endif
