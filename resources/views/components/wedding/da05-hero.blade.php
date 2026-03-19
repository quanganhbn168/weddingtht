{{-- DA05 VIP: Hero Photos (Lines 249-274) --}}
@props(['wedding', 'heroUrl', 'side' => 'both'])
@php
    $isBride = $side === 'bride';
    $firstName = $isBride ? $wedding->bride_name : $wedding->groom_name;
    $secondName = $isBride ? $wedding->groom_name : $wedding->bride_name;
@endphp

<section class="relative" data-aos="fade-up">
    {{-- Photo 1: We get married --}}
    <div class="relative w-full aspect-[3/4] overflow-hidden">
        <img src="{{ $heroUrl }}" class="w-full h-full object-cover" alt="We get married">
        <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/60"></div>
        <div class="absolute inset-0 flex flex-col justify-between items-center py-12 px-6 text-white text-center">
            <p class="font-script text-5xl drop-shadow-lg" data-aos="fade-down">We get married</p>
            <div>
                <p style="font-family: 'Philosopher', serif;" class="text-2xl font-medium tracking-wide drop-shadow-lg">{{ $firstName }} <span class="text-gold">&</span> {{ $secondName }}</p>
                <p style="font-family: 'Philosopher', serif;" class="text-xl font-light tracking-[0.2em] mt-2 drop-shadow-lg">{{ $wedding->event_date?->format('d.m.Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Photo 2: Save the Date (xe-giay.png) --}}
    @php
        $galleryImages = $wedding->gallery_images;
        $saveTheDateBg = $galleryImages->isNotEmpty()
            ? ($galleryImages->first()->getUrl('gallery_web') ?: $galleryImages->first()->getUrl())
            : null;
    @endphp
    <div class="relative w-full aspect-[3/4] overflow-hidden">
        {{-- Ảnh gallery làm background --}}
        @if($saveTheDateBg)
        <img src="{{ $saveTheDateBg }}" class="absolute inset-0 w-full h-full object-cover object-top" alt="Background">
        @else
        <div class="absolute inset-0 bg-[#f5ede3]"></div>
        @endif

        {{-- Overlay tối nhẹ --}}
        <div class="absolute inset-0 bg-black/25"></div>

        {{-- Xe giấy overlay — neo ở đáy, không bị cắt --}}
        <img src="{{ asset('images/xe-giay.png') }}" class="absolute bottom-0 left-0 right-0 w-full object-contain object-bottom z-10" style="max-height: 70%;" alt="Save the Date">

        {{-- Overlay gradient để chữ nổi ở dưới --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-transparent to-transparent z-10"></div>

        {{-- Chữ góc dưới bên trái --}}
        <div class="absolute bottom-6 left-6 z-20 text-white text-left">
            <p style="font-family: 'Philosopher', serif;" class="text-sm tracking-[0.3em] uppercase opacity-80 mb-1">Save the Date</p>
            <p class="font-script text-4xl leading-tight drop-shadow-lg">{{ $firstName }}</p>
            <p class="font-script text-2xl leading-tight opacity-85 drop-shadow-lg">&amp; {{ $secondName }}</p>
            @if($wedding->event_date)
            <p style="font-family: 'Philosopher', serif;" class="text-sm tracking-[0.2em] mt-2 opacity-70">
                {{ $wedding->event_date->format('d . m . Y') }}
            </p>
            @endif
        </div>
    </div>
</section>
