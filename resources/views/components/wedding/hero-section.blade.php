@php
    $t = $theme ?? config('wedding-themes.default');
    $sd = $sideData;
@endphp

<section class="relative" data-aos="fade-up">
    {{-- Hero Image --}}
    <div class="relative w-full aspect-[3/4] overflow-hidden">
        <img src="{{ $heroUrl }}" class="w-full h-full object-cover" alt="{{ $sd->firstName }} & {{ $sd->secondName }}">
        <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/60"></div>
        <div class="absolute inset-0 flex flex-col justify-between items-center py-12 px-6 text-white text-center">
            <p style="font-family: {{ $t['font_script'] }}" class="text-5xl drop-shadow-lg" data-aos="fade-down">We get married</p>
            <div>
                <p style="font-family: {{ $t['font_display'] }}" class="text-2xl font-medium tracking-wide drop-shadow-lg">
                    {{ $sd->firstName }} <span style="color: {{ $t['primary'] }}">&</span> {{ $sd->secondName }}
                </p>
                <p style="font-family: {{ $t['font_display'] }}" class="text-xl font-light tracking-[0.2em] mt-2 drop-shadow-lg">
                    {{ $wedding->event_date?->format('d.m.Y') }}
                </p>
            </div>
        </div>
    </div>

    {{ $slot ?? '' }}
</section>
