@php
    $t = $theme ?? config('wedding-themes.default');
    $sd = $sideData;
    $layout = $layout ?? 'stacked'; // stacked | side-by-side | polaroid
@endphp

<section class="py-16 px-4 relative overflow-hidden" style="background: {{ $t['bg'] }}" data-aos="fade-up">
    {{ $decoration ?? '' }}

    <h2 class="text-center mb-10" data-aos="fade-down">
        <span style="font-family: {{ $t['font_display'] }}; color: {{ $t['text'] }}" class="text-2xl tracking-[0.3em] uppercase">The Story</span>
        <span style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}" class="text-4xl mx-2">of</span>
        <span style="font-family: {{ $t['font_display'] }}; color: {{ $t['text'] }}" class="text-2xl tracking-[0.3em] uppercase">Love</span>
    </h2>

    @if($layout === 'polaroid')
    {{-- Polaroid stacked photos --}}
    <div class="relative mx-auto" style="max-width: 340px; height: 480px;">
        <div class="absolute" style="top: 0; left: 0; z-index: 2;" data-aos="fade-right">
            <div style="width: 200px; height: 250px; padding: 8px; background: white; border: 3px solid {{ $t['primary'] }}; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: rotate(-5deg);">
                <img src="{{ $groomPhoto }}" style="width: 100%; height: 100%; object-fit: cover; object-position: top;" alt="{{ $wedding->groom_name }}">
            </div>
        </div>
        <div class="absolute" style="top: 60px; right: 0; text-align: right; z-index: 3;" data-aos="fade-left">
            <p style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}" class="text-3xl mb-1">Chú rể</p>
            <h3 style="font-family: {{ $t['font_body'] }}; color: {{ $t['text'] }}" class="text-2xl font-bold">{{ $wedding->groom_name }}</h3>
        </div>
        <div class="absolute" style="bottom: 20px; right: 0; z-index: 4;" data-aos="fade-left">
            <div style="width: 200px; height: 250px; padding: 8px; background: white; border: 3px solid {{ $t['primary'] }}; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: rotate(5deg);">
                <img src="{{ $bridePhoto }}" style="width: 100%; height: 100%; object-fit: cover; object-position: top;" alt="{{ $wedding->bride_name }}">
            </div>
        </div>
        <div class="absolute" style="bottom: 80px; left: 0; text-align: left; z-index: 5;" data-aos="fade-right">
            <p style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}" class="text-3xl mb-1">Cô dâu</p>
            <h3 style="font-family: {{ $t['font_body'] }}; color: {{ $t['text'] }}" class="text-2xl font-bold">{{ $wedding->bride_name }}</h3>
        </div>
    </div>

    @elseif($layout === 'side-by-side')
    {{-- Side by side --}}
    <div class="grid grid-cols-2 gap-6 max-w-sm mx-auto">
        <div class="text-center" data-aos="fade-right">
            <div class="w-32 h-40 mx-auto mb-3 rounded-2xl overflow-hidden shadow-lg" style="border: 3px solid {{ $t['primary'] }}">
                <img src="{{ $groomPhoto }}" class="w-full h-full object-cover object-top" alt="{{ $wedding->groom_name }}">
            </div>
            <p style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}" class="text-2xl">Chú rể</p>
            <h3 style="font-family: {{ $t['font_display'] }}; color: {{ $t['text'] }}" class="text-lg font-bold">{{ $wedding->groom_name }}</h3>
        </div>
        <div class="text-center" data-aos="fade-left">
            <div class="w-32 h-40 mx-auto mb-3 rounded-2xl overflow-hidden shadow-lg" style="border: 3px solid {{ $t['accent'] }}">
                <img src="{{ $bridePhoto }}" class="w-full h-full object-cover object-top" alt="{{ $wedding->bride_name }}">
            </div>
            <p style="font-family: {{ $t['font_script'] }}; color: {{ $t['accent'] }}" class="text-2xl">Cô dâu</p>
            <h3 style="font-family: {{ $t['font_display'] }}; color: {{ $t['text'] }}" class="text-lg font-bold">{{ $wedding->bride_name }}</h3>
        </div>
    </div>

    @else
    {{-- Default stacked --}}
    <div class="space-y-8 max-w-sm mx-auto">
        <div class="text-center" data-aos="fade-up">
            <div class="w-40 h-52 mx-auto mb-4 rounded-2xl overflow-hidden shadow-xl" style="border: 3px solid {{ $t['primary'] }}">
                <img src="{{ $groomPhoto }}" class="w-full h-full object-cover object-top" alt="{{ $wedding->groom_name }}">
            </div>
            <p style="font-family: {{ $t['font_script'] }}; color: {{ $t['primary'] }}" class="text-3xl">Chú rể</p>
            <h3 style="font-family: {{ $t['font_display'] }}; color: {{ $t['text'] }}" class="text-xl font-bold">{{ $wedding->groom_name }}</h3>
        </div>
        <div class="text-center" data-aos="fade-up" data-aos-delay="200">
            <div class="w-40 h-52 mx-auto mb-4 rounded-2xl overflow-hidden shadow-xl" style="border: 3px solid {{ $t['accent'] }}">
                <img src="{{ $bridePhoto }}" class="w-full h-full object-cover object-top" alt="{{ $wedding->bride_name }}">
            </div>
            <p style="font-family: {{ $t['font_script'] }}; color: {{ $t['accent'] }}" class="text-3xl">Cô dâu</p>
            <h3 style="font-family: {{ $t['font_display'] }}; color: {{ $t['text'] }}" class="text-xl font-bold">{{ $wedding->bride_name }}</h3>
        </div>
    </div>
    @endif
</section>
