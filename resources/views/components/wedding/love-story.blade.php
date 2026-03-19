@php
    $t = $theme ?? config('wedding-themes.default');
    $loveStoryRaw = $wedding->content['love_story'] ?? [];
    $loveStory = is_array($loveStoryRaw) ? $loveStoryRaw : [];
@endphp

@if(count($loveStory) > 0)
<section class="py-16 px-6 relative" style="background: {{ $t['bg'] }}" data-aos="fade-up">
    {{ $decoration ?? '' }}

    <h2 class="text-center mb-10" data-aos="fade-down">
        <span style="font-family: {{ $t['font_display'] }}; color: {{ $t['text'] }}" class="text-2xl tracking-[0.2em] uppercase">Chuyện Tình</span>
        <span style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}" class="text-4xl mx-2">yêu</span>
    </h2>

    <div class="relative max-w-sm mx-auto pl-10">
        {{-- Vertical line --}}
        <div class="absolute left-3 top-0 bottom-0 w-px" style="background: {{ $t['primary'] }}30"></div>

        @foreach($loveStory as $item)
        <div class="relative mb-12" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
            {{-- Dot --}}
            <div class="absolute" style="left: -34px; top: 8px; width: 14px; height: 14px; background: {{ $t['primary'] }}; border-radius: 50%; border: 3px solid {{ $t['bg'] }}; box-shadow: 0 0 0 2px {{ $t['primary'] }};"></div>
            {{-- Year + Title --}}
            <h3 style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}; font-style: italic;" class="text-3xl mb-3">{{ $item['year'] ?? '' }} - {{ $item['title'] ?? '' }}</h3>
            {{-- Description --}}
            <p class="text-sm leading-relaxed italic" style="color: {{ $t['text_muted'] }}">{{ $item['description'] ?? '' }}</p>
        </div>
        @endforeach
    </div>
</section>
@endif
