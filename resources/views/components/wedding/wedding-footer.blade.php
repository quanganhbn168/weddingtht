{{-- 
    SHARED: Wedding Footer Component
    Usage: <x-wedding.wedding-footer :wedding="$wedding" :side="$side" />
    Theming: Uses CSS vars from template's :root
--}}
@props(['wedding', 'side' => 'both'])
@php
    $isBride = $side === 'bride';
    $firstName = $isBride ? $wedding->bride_name : $wedding->groom_name;
    $secondName = $isBride ? $wedding->groom_name : $wedding->bride_name;
@endphp

<p class="font-script text-6xl text-gold mb-6">Thank You!</p>
<div class="font-display text-2xl text-gold/80 mb-2 italic">{{ $firstName }} & {{ $secondName }}</div>
<p class="text-gold/60 font-bold tracking-[0.3em] text-sm mb-10">{{ $wedding->event_date?->format('d.m.Y') }}</p>
<div class="separator mb-10">
    <svg class="w-6 h-6 text-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<p class="text-[10px] text-gray-400 uppercase tracking-widest">Designed with ❤️ by THT Media</p>
