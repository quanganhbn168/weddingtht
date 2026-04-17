{{--
    SHARED: Event Cards Component
    Usage: <x-wedding.event-cards :wedding="$wedding" :side="$side" :groomPhoto="$groomPhoto" :bridePhoto="$bridePhoto" />
    Theming: Uses CSS vars from template's :root
--}}
@props(['wedding', 'side' => 'both', 'groomPhoto', 'bridePhoto'])

@php
    $eventImages = $wedding->gallery_images->slice(-4)->values();

    $img0 = $eventImages->get(0) ? ($eventImages->get(0)->getUrl('gallery_web') ?: $eventImages->get(0)->getUrl()) : $groomPhoto;
    $img1 = $eventImages->get(1) ? ($eventImages->get(1)->getUrl('gallery_web') ?: $eventImages->get(1)->getUrl()) : $bridePhoto;
    $img2 = $eventImages->get(2) ? ($eventImages->get(2)->getUrl('gallery_web') ?: $eventImages->get(2)->getUrl()) : $bridePhoto;
    $img3 = $eventImages->get(3) ? ($eventImages->get(3)->getUrl('gallery_web') ?: $eventImages->get(3)->getUrl()) : $groomPhoto;
@endphp

<style>
    .event-bg-card {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
        min-height: 260px;
    }
    .event-bg-card > img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    .event-bg-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.28), rgba(0, 0, 0, 0.78));
    }
    .event-bg-content {
        position: relative;
        z-index: 1;
        color: #fff;
    }
</style>

<h2 class="font-script text-5xl text-gold text-center mb-12">Sự Kiện Cưới</h2>
<div class="space-y-6 max-w-sm mx-auto">
    {{-- Tiệc nhà trai --}}
    @if($wedding->groom_reception_time && $side !== 'bride')
    <div class="event-bg-card p-6" data-aos="fade-right">
        <img src="{{ $img0 }}" alt="Tiệc mừng nhà trai">
        <div class="event-bg-overlay"></div>
        <div class="event-bg-content">
        <div class="text-center mb-4">
            <h3 class="font-display text-xl text-gold font-bold">Tiệc Mừng Nhà Trai</h3>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-white/70">Thời gian</p><p class="font-bold text-white">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }} - {{ ($wedding->groom_reception_date ?? $wedding->event_date)?->format('d/m/Y') }}</p></div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-white/70">Địa điểm</p><p class="font-bold text-white">{{ $wedding->groom_reception_venue }}</p><p class="text-xs italic text-white/85">{{ $wedding->groom_reception_address }}</p></div>
            </div>
        </div>
        @php
            $DEFAULT_MAP = 'https://maps.google.com/maps?q=Ha+Noi,+Vietnam&output=embed';
            $groomEmbed = $wedding->groom_map_embed ?: ($wedding->groom_map_url ? str_replace('/maps?', '/maps?', $wedding->groom_map_url) : $DEFAULT_MAP);
        @endphp
        @if($wedding->groom_map_embed)
        <div class="mt-4 rounded-xl overflow-hidden shadow-md" style="height:160px">
            <iframe src="{{ $wedding->groom_map_embed }}" width="100%" height="160" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        @endif
        @if($wedding->groom_map_url)
        <a href="{{ $wedding->groom_map_url }}" target="_blank" class="block w-full mt-3 py-3 btn-gold rounded-xl text-center text-sm font-bold uppercase tracking-wider">Xem Bản Đồ</a>
        @endif
        </div>
    </div>
    @endif

    {{-- Tiệc nhà gái --}}
    @if($wedding->bride_reception_time && $side !== 'groom')
    <div class="event-bg-card p-6" data-aos="fade-left">
        <img src="{{ $img1 }}" alt="Tiệc cưới nhà gái">
        <div class="event-bg-overlay"></div>
        <div class="event-bg-content">
        <div class="text-center mb-4">
            <h3 class="font-display text-xl text-rose font-bold">Tiệc Cưới Nhà Gái</h3>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-white/70">Thời gian</p><p class="font-bold text-white">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }} - {{ ($wedding->bride_reception_date ?? $wedding->event_date)?->format('d/m/Y') }}</p></div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-white/70">Địa điểm</p><p class="font-bold text-white">{{ $wedding->bride_reception_venue }}</p><p class="text-xs italic text-white/85">{{ $wedding->bride_reception_address }}</p></div>
            </div>
        </div>
        @if($wedding->bride_map_embed)
        <div class="mt-4 rounded-xl overflow-hidden shadow-md" style="height:160px">
            <iframe src="{{ $wedding->bride_map_embed }}" width="100%" height="160" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        @endif
        @if($wedding->bride_map_url)
        <a href="{{ $wedding->bride_map_url }}" target="_blank" class="block w-full mt-3 py-3 btn-gold rounded-xl text-center text-sm font-bold uppercase tracking-wider">Xem Bản Đồ</a>
        @endif
        </div>
    </div>
    @endif

    {{-- Lễ Vu Quy --}}
    @if($wedding->bride_ceremony_date && $side !== 'groom')
    <div class="event-bg-card p-6" data-aos="fade-left">
        <img src="{{ $img2 }}" alt="Lễ vu quy">
        <div class="event-bg-overlay"></div>
        <div class="event-bg-content">
        <div class="text-center mb-4">
            <h3 class="font-display text-xl text-rose font-bold">Lễ Vu Quy</h3>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-white/70">Thời gian</p><p class="font-bold text-white">{{ \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($wedding->bride_ceremony_date)->format('d/m/Y') }}</p></div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-white/70">Địa điểm</p><p class="font-bold text-white">{{ $wedding->bride_address }}</p></div>
            </div>
        </div>
        @if($wedding->bride_ceremony_map_url)
        <a href="{{ $wedding->bride_ceremony_map_url }}" target="_blank" class="block w-full mt-4 py-3 btn-gold rounded-xl text-center text-sm font-bold uppercase tracking-wider">Xem Bản Đồ</a>
        @endif
        </div>
    </div>
    @endif
    @if($wedding->groom_ceremony_date && $side !== 'bride')
    <div class="event-bg-card p-6" data-aos="fade-right">
        <img src="{{ $img3 }}" alt="Lễ thành hôn">
        <div class="event-bg-overlay"></div>
        <div class="event-bg-content">
        <div class="text-center mb-4">
            <h3 class="font-display text-xl text-gold font-bold">Lễ Thành Hôn</h3>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-white/70">Thời gian</p><p class="font-bold text-white">{{ \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($wedding->groom_ceremony_date)->format('d/m/Y') }}</p></div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-white/70">Địa điểm</p><p class="font-bold text-white">{{ $wedding->groom_address }}</p></div>
            </div>
        </div>
        @if($wedding->groom_ceremony_map_url)
        <a href="{{ $wedding->groom_ceremony_map_url }}" target="_blank" class="block w-full mt-4 py-3 btn-gold rounded-xl text-center text-sm font-bold uppercase tracking-wider">Xem Bản Đồ</a>
        @endif
        </div>
    </div>
    @endif
</div>
