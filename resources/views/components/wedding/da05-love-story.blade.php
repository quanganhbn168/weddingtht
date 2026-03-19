{{-- DA05 VIP: Love Story Timeline (Lines 320-345) --}}
@props(['wedding'])
@php
    $loveStoryRaw = $wedding->content['love_story'] ?? [];
    $loveStory = is_array($loveStoryRaw) ? $loveStoryRaw : [];
@endphp

@if(count($loveStory) > 0)
<section class="py-16 px-6 bg-cream relative bg-main-watercolor" data-aos="fade-up">
    <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 left-0 opacity-30" alt="">
    <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner bottom-0 right-0 rotate-180 opacity-30" alt="">

    <div class="relative max-w-sm mx-auto pl-10">
        {{-- Vertical line --}}
        <div class="absolute left-3 top-0 bottom-0 w-px bg-gold/30"></div>

        @foreach($loveStory as $item)
        <div class="relative mb-12" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
            {{-- Dot --}}
            <div class="absolute" style="left: -34px; top: 8px; width: 14px; height: 14px; background: #A67C52; border-radius: 50%; border: 3px solid #FDF8F4; box-shadow: 0 0 0 2px #A67C52;"></div>
            {{-- Year + Title --}}
            <h3 class="font-script text-3xl text-gold mb-3" style="font-style: italic;">{{ $item['year'] ?? '' }} - {{ $item['title'] ?? '' }}</h3>
            {{-- Description --}}
            <p class="text-sm text-gray-600 leading-relaxed italic">{{ $item['description'] ?? '' }}</p>
        </div>
        @endforeach
    </div>
</section>
@endif
