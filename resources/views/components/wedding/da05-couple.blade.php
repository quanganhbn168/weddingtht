{{-- DA05 VIP: The Story of Love - Couple Info (Lines 279-315) --}}
@props(['wedding', 'groomPhoto', 'bridePhoto'])

<section class="py-16 px-4 bg-cream relative overflow-hidden bg-main-watercolor" data-aos="fade-up">
    <img src="{{ asset('images/hoa-1.png') }}" class="floral-corner top-0 left-0 opacity-30" alt="">

    {{-- Heading: THE STORY of LOVE --}}
    <h2 class="text-center mb-10" data-aos="fade-down">
        <span class="font-display text-2xl tracking-[0.3em] uppercase text-gray-700">The Story</span>
        <span class="font-script text-4xl text-gold mx-2">of</span>
        <span class="font-display text-2xl tracking-[0.3em] uppercase text-gray-700">Love</span>
    </h2>

    {{-- Stacked overlapping photos --}}
    <div class="relative mx-auto" style="max-width: 340px; height: 480px;">
        {{-- Groom photo: top-left, tilted --}}
        <div class="absolute" style="top: 0; left: 0; z-index: 2;" data-aos="fade-right">
            <div style="width: 200px; height: 250px; padding: 8px; background: white; border: 3px solid #A67C52; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: rotate(-5deg);">
                <img src="{{ $groomPhoto }}" style="width: 100%; height: 100%; object-fit: cover; object-position: top;" alt="{{ $wedding->groom_name }}">
            </div>
        </div>
        {{-- Groom text --}}
        <div class="absolute" style="top: 60px; right: 0; text-align: right; z-index: 3;" data-aos="fade-left">
            <p class="font-script text-3xl text-gold mb-1">Chú rể</p>
            <h3 style="font-family: 'Philosopher', serif;" class="text-2xl font-bold text-gray-700">{{ $wedding->groom_name }}</h3>
        </div>

        {{-- Bride photo: bottom-right, overlapping groom --}}
        <div class="absolute" style="bottom: 20px; right: 0; z-index: 4;" data-aos="fade-left">
            <div style="width: 200px; height: 250px; padding: 8px; background: white; border: 3px solid #A67C52; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: rotate(5deg);">
                <img src="{{ $bridePhoto }}" style="width: 100%; height: 100%; object-fit: cover; object-position: top;" alt="{{ $wedding->bride_name }}">
            </div>
        </div>
        {{-- Bride text --}}
        <div class="absolute" style="bottom: 80px; left: 0; text-align: left; z-index: 5;" data-aos="fade-right">
            <p class="font-script text-3xl text-gold mb-1">Cô dâu</p>
            <h3 style="font-family: 'Philosopher', serif;" class="text-2xl font-bold text-gray-700">{{ $wedding->bride_name }}</h3>
        </div>
    </div>
</section>
