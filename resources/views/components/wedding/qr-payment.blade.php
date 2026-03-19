{{-- 
    SHARED: QR Payment Component
    Usage: <x-wedding.qr-payment :wedding="$wedding" :groomPhoto="$groomPhoto" :bridePhoto="$bridePhoto" />
    Theming: Uses CSS vars from template's :root
--}}
@props(['wedding', 'groomPhoto', 'bridePhoto'])

<div x-data="{ activeQr: null }">
    <h2 class="font-script text-5xl text-gold text-center mb-4">Mừng Cưới</h2>
    <p class="text-center text-sm text-gray-500 italic mb-10 max-w-xs mx-auto">
        {{ $wedding->getContentValue('blessing_desc', "Sự hiện diện và lời chúc phúc của bạn là niềm hạnh phúc lớn nhất của chúng tôi.") }}
    </p>

    <div class="grid grid-cols-2 gap-6">
        <div class="text-center" data-aos="fade-right">
            <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-gold/30 shadow-md">
                <img src="{{ $groomPhoto }}" class="w-full h-full object-cover object-top">
            </div>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Chú Rể</p>
            <h3 class="font-display text-lg text-gold font-bold mb-3">{{ $wedding->groom_name }}</h3>
            <button @click="activeQr = 'groom'" class="btn-gold px-6 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest">Mừng Cưới</button>
        </div>
        <div class="text-center" data-aos="fade-left">
            <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden border-3 border-rose/30 shadow-md">
                <img src="{{ $bridePhoto }}" class="w-full h-full object-cover object-top">
            </div>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Cô Dâu</p>
            <h3 class="font-display text-lg text-rose font-bold mb-3">{{ $wedding->bride_name }}</h3>
            <button @click="activeQr = 'bride'" class="btn-gold px-6 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest">Mừng Cưới</button>
        </div>
    </div>

    {{-- QR Modal --}}
    <div x-show="activeQr" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="activeQr = null" class="fixed inset-0 z-[100] bg-black/80 backdrop-blur-md flex items-center justify-center p-6" style="display: none;">
        <div @click.stop class="bg-white rounded-3xl p-8 max-w-xs w-full text-center relative" x-show="activeQr" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="scale-90 translate-y-8" x-transition:enter-end="scale-100 translate-y-0">
            <button @click="activeQr = null" class="absolute top-4 right-4 text-gray-400 hover:text-gold transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>

            <div x-show="activeQr === 'groom'">
                <p class="font-display text-xl text-gold font-bold mb-1">Mừng Cưới Chú Rể</p>
                <p class="text-sm text-gray-500 mb-4">{{ $wedding->groom_name }}</p>
                <div class="bg-gray-50 p-4 rounded-2xl inline-block mb-4"><img src="{{ $wedding->getGroomQrUrl() }}" class="w-48 h-48 object-contain"></div>
                @if($wedding->groom_qr_info)<p class="text-xs text-gray-500 whitespace-pre-line">{{ $wedding->groom_qr_info }}</p>@endif
            </div>
            <div x-show="activeQr === 'bride'">
                <p class="font-display text-xl text-rose font-bold mb-1">Mừng Cưới Cô Dâu</p>
                <p class="text-sm text-gray-500 mb-4">{{ $wedding->bride_name }}</p>
                <div class="bg-gray-50 p-4 rounded-2xl inline-block mb-4"><img src="{{ $wedding->getBrideQrUrl() }}" class="w-48 h-48 object-contain"></div>
                @if($wedding->bride_qr_info)<p class="text-xs text-gray-500 whitespace-pre-line">{{ $wedding->bride_qr_info }}</p>@endif
            </div>
        </div>
    </div>
</div>
