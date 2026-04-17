{{-- 
    SHARED: Event Cards Component
    Usage: <x-wedding.event-cards :wedding="$wedding" :side="$side" :groomPhoto="$groomPhoto" :bridePhoto="$bridePhoto" />
    Theming: Uses CSS vars from template's :root
--}}
@props(['wedding', 'side' => 'both', 'groomPhoto', 'bridePhoto'])

@php
    $gallery = $wedding->gallery_images;
    $gallery = $gallery instanceof \Illuminate\Support\Collection ? $gallery : collect($gallery);
    $eventImages = $gallery->take(4)->values();

    $eventImageUrl = function (int $index, string $fallback) use ($eventImages): string {
        $media = $eventImages->get($index);
        if (!$media) {
            return $fallback;
        }

        try {
            return $media->getUrl('gallery_web') ?: $media->getUrl();
        } catch (\Throwable $e) {
            return $fallback;
        }
    };
@endphp

<h2 class="font-script text-5xl text-gold text-center mb-12">Sự Kiện Cưới</h2>
<div class="space-y-6 max-w-sm mx-auto">
    {{-- Tiệc nhà trai --}}
    @if($wedding->groom_reception_time && $side !== 'bride')
    <div class="card-glass p-6" data-aos="fade-right">
        <div class="text-center mb-4">
            <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-gold/40 shadow-md">
                <img src="{{ $eventImageUrl(0, $groomPhoto) }}" class="w-full h-full object-cover object-top">
            </div>
            <h3 class="font-display text-xl text-gold font-bold">Tiệc Mừng Nhà Trai</h3>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p><p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($wedding->groom_reception_time)->format('H:i') }} - {{ ($wedding->groom_reception_date ?? $wedding->event_date)?->format('d/m/Y') }}</p></div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p><p class="font-bold text-gray-700">{{ $wedding->groom_reception_venue }}</p><p class="text-xs italic text-gray-500">{{ $wedding->groom_reception_address }}</p></div>
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
    @endif

    {{-- Tiệc nhà gái --}}
    @if($wedding->bride_reception_time && $side !== 'groom')
    <div class="card-glass p-6" data-aos="fade-left">
        <div class="text-center mb-4">
            <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-rose/40 shadow-md">
                <img src="{{ $eventImageUrl(1, $bridePhoto) }}" class="w-full h-full object-cover object-top">
            </div>
            <h3 class="font-display text-xl text-rose font-bold">Tiệc Cưới Nhà Gái</h3>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-rose/10 rounded-full flex items-center justify-center text-rose shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p><p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($wedding->bride_reception_time)->format('H:i') }} - {{ ($wedding->bride_reception_date ?? $wedding->event_date)?->format('d/m/Y') }}</p></div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-rose/10 rounded-full flex items-center justify-center text-rose shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p><p class="font-bold text-gray-700">{{ $wedding->bride_reception_venue }}</p><p class="text-xs italic text-gray-500">{{ $wedding->bride_reception_address }}</p></div>
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
    @endif

    {{-- Lễ Vu Quy --}}
    @if($wedding->bride_ceremony_date && $side !== 'groom')
    <div class="card-glass p-6" data-aos="fade-left">
        <div class="text-center mb-4">
            <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-rose/40 shadow-md">
                <img src="{{ $eventImageUrl(2, $bridePhoto) }}" class="w-full h-full object-cover object-top rounded-full">
            </div>
            <h3 class="font-display text-xl text-rose font-bold">Lễ Vu Quy</h3>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-rose/10 rounded-full flex items-center justify-center text-rose shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p><p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($wedding->bride_ceremony_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($wedding->bride_ceremony_date)->format('d/m/Y') }}</p></div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-rose/10 rounded-full flex items-center justify-center text-rose shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p><p class="font-bold text-gray-700">{{ $wedding->bride_address }}</p></div>
            </div>
        </div>
        @if($wedding->bride_ceremony_map_url)
        <a href="{{ $wedding->bride_ceremony_map_url }}" target="_blank" class="block w-full mt-4 py-3 btn-gold rounded-xl text-center text-sm font-bold uppercase tracking-wider">Xem Bản Đồ</a>
        @endif
    </div>
    @endif
    @if($wedding->groom_ceremony_date && $side !== 'bride')
    <div class="card-glass p-6" data-aos="fade-right">
        <div class="text-center mb-4">
            <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-gold/40 shadow-md">
                <img src="{{ $eventImageUrl(3, $groomPhoto) }}" class="w-full h-full object-cover object-top rounded-full">
            </div>
            <h3 class="font-display text-xl text-gold font-bold">Lễ Thành Hôn</h3>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-gray-400">Thời gian</p><p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($wedding->groom_ceremony_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($wedding->groom_ceremony_date)->format('d/m/Y') }}</p></div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-gold/10 rounded-full flex items-center justify-center text-gold shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                <div><p class="text-[10px] font-bold uppercase text-gray-400">Địa điểm</p><p class="font-bold text-gray-700">{{ $wedding->groom_address }}</p></div>
            </div>
        </div>
        @if($wedding->groom_ceremony_map_url)
        <a href="{{ $wedding->groom_ceremony_map_url }}" target="_blank" class="block w-full mt-4 py-3 btn-gold rounded-xl text-center text-sm font-bold uppercase tracking-wider">Xem Bản Đồ</a>
        @endif
    </div>
    @endif
</div>
