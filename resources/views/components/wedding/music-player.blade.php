@props(['wedding', 'musicUrl' => null])

@php
    $url = $musicUrl ?? $wedding->music_url;
    
    // 1. Try list_image
    $albumArt = $wedding->list_image;
    
    // 2. Try first image from Gallery (Collection)
    if (!$albumArt && $wedding->gallery_images && $wedding->gallery_images->count() > 0) {
        // Since gallery_images is a Spatie Media Collection, we get the URL directly
        $albumArt = $wedding->gallery_images->first()->getUrl('thumb');
    }

    // 3. Fallback generator
    if (!$albumArt) {
        $albumArt = 'https://ui-avatars.com/api/?name=' . urlencode($wedding->groom_name . '+' . $wedding->bride_name) . '&background=random';
    }

    // Determine final URL (External vs Storage)
    if (\Illuminate\Support\Str::startsWith($albumArt, ['http', 'https'])) {
        $albumArtUrl = $albumArt;
    } else {
        $albumArtUrl = asset('storage/' . $albumArt);
    }
@endphp

@if($url)
<div x-data="{ 
        playing: false, 
        audio: null, 
        showControls: false,
        init() {
            this.audio = new Audio('{{ $url }}');
            this.audio.loop = true;
            
            // Auto-play attempt (muted first if needed, but we try standard play)
            // Browsers block unmuted autoplay, so we wait for interaction
            document.addEventListener('click', () => {
                if(!this.playing && this.audio.paused) {
                    this.audio.play().then(() => {
                         this.playing = true; 
                    }).catch(e => console.log('Autoplay blocked', e));
                }
            }, { once: true });
        },
        toggle() {
            if (this.playing) {
                this.audio.pause();
            } else {
                this.audio.play();
            }
            this.playing = !this.playing;
        }
     }" 
     class="fixed bottom-6 left-6 z-50 flex items-end gap-2 group"
     @mouseenter="showControls = true" 
     @mouseleave="showControls = false">

    {{-- Vinyl Record --}}
    <div class="relative w-16 h-16 md:w-20 md:h-20 cursor-pointer transition-transform duration-500 hover:scale-110"
         @click="toggle()">
        
        {{-- Spinning Disc --}}
        <div class="absolute inset-0 rounded-full bg-gray-900 shadow-2xl border-2 border-gray-800 flex items-center justify-center overflow-hidden"
             :class="{ 'animate-spin-slow': playing }">
            
            {{-- Grooves Effect --}}
            <div class="absolute inset-0 rounded-full opacity-20"
                 style="background: repeating-radial-gradient(#111 0, #111 2px, #333 3px, #333 4px);"></div>

            {{-- Album Art (Center Label) --}}
            <div class="w-1/2 h-1/2 rounded-full overflow-hidden border-2 border-gray-700 relative z-10">
                <img src="{{ $albumArtUrl }}" 
                     class="w-full h-full object-cover" 
                     alt="Music">
            </div>
            
            {{-- Center Hole --}}
            <div class="absolute w-1.5 h-1.5 bg-white rounded-full z-20 shadow-sm"></div>
        </div>

        {{-- Music Notes Animation (When playing) --}}
        <template x-if="playing">
            <div class="absolute -top-4 -right-4">
                <span class="absolute animate-bounce text-rose-500 text-lg" style="animation-delay: 0s">♪</span>
                <span class="absolute animate-bounce text-rose-500 text-sm -top-2 -right-3" style="animation-delay: 0.2s">♫</span>
            </div>
        </template>
    </div>

    {{-- Control Pill (Slide out) --}}
    <div class="h-10 bg-white/90 backdrop-blur-md rounded-full shadow-lg flex items-center px-4 mb-3 transition-all duration-500 origin-left border border-gray-100"
         :class="showControls || !playing ? 'w-auto opacity-100 translate-x-0' : 'w-0 opacity-0 -translate-x-full overflow-hidden'">
        
        <div class="flex items-center gap-3 whitespace-nowrap overflow-hidden">
            <p class="text-xs font-medium text-gray-600 pr-2 border-r border-gray-200 hidden md:block" style="font-family: var(--font-body);">
                Wedding Song
            </p>
            
            <button @click="toggle()" class="text-[var(--color-primary)] hover:scale-110 transition">
                <template x-if="playing">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                </template>
                <template x-if="!playing">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </template>
            </button>
        </div>
    </div>
</div>
@endif
