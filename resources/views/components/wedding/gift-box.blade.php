@props(['wedding', 'class' => '', 'style' => 'regular'])
{{-- 
    style: 'regular' (default), 'circle' (for modern), 'card' (for galaxy/cinematic)
    class: Custom Tailwind classes for the container
--}}

<div x-data="{ showQr: null, showWishes: false }" class="{{ $class }}">
    
    {{-- Trigger Buttons Area --}}
    {{ $slot }}

    {{-- Gift Box / QR Modal --}}
    <div x-show="showQr" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" 
         style="display: none;" 
         x-transition.opacity>
        
        <div class="bg-white w-full max-w-sm relative shadow-2xl overflow-hidden" 
             style="border-radius: var(--radius-box, 0.5rem);"
             @click.outside="showQr = null">
            {{-- Close Button --}}
            <button @click="showQr = null" class="absolute top-2 right-2 text-gray-400 hover:text-gray-900 z-10 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            {{-- Header --}}
            <div class="bg-gray-50 p-4 border-b border-gray-100 text-center">
                <h3 class="text-lg font-bold uppercase tracking-wider text-gray-800" 
                    x-text="showQr === 'groom' ? 'Nhà Trai' : 'Nhà Gái'"></h3>
                <p class="text-xs text-gray-500 mt-1">Hộp Mừng Cưới</p>
            </div>
            
            {{-- Content --}}
            <div class="p-6 text-center">
                @php
                    $groomInfo = is_array($wedding->groom_qr_info) ? $wedding->groom_qr_info : [];
                    $brideInfo = is_array($wedding->bride_qr_info) ? $wedding->bride_qr_info : [];
                    $bankNames = [
                        '970436'=>'Vietcombank','970418'=>'BIDV','970405'=>'Agribank',
                        '970407'=>'Techcombank','970422'=>'MB Bank','970432'=>'VPBank',
                        '970416'=>'ACB','970403'=>'Sacombank','970423'=>'TPBank',
                        '970415'=>'VietinBank','970443'=>'SHB','970437'=>'HDBank',
                        '970448'=>'OCB','970426'=>'MSB','970440'=>'SeABank',
                    ];
                @endphp

                <template x-if="showQr === 'groom'">
                    <div>
                        <img src="{{ $wedding->getGroomQrUrl() }}"
                             class="w-56 h-56 object-contain mx-auto mb-4 rounded-xl border border-gray-100 shadow-sm">
                        <div class="text-left bg-gray-50 rounded-xl p-4 space-y-2 text-sm">
                            @if(!empty($groomInfo['bank_bin']))
                            <div class="flex justify-between">
                                <span class="text-gray-500">Ngân hàng</span>
                                <span class="font-bold text-gray-800">{{ $bankNames[$groomInfo['bank_bin']] ?? $groomInfo['bank_bin'] }}</span>
                            </div>
                            @endif
                            @if(!empty($groomInfo['account_number']))
                            <div class="flex justify-between">
                                <span class="text-gray-500">Số tài khoản</span>
                                <span class="font-bold text-gray-800 font-mono tracking-wider">{{ $groomInfo['account_number'] }}</span>
                            </div>
                            @endif
                            @if(!empty($groomInfo['account_name']))
                            <div class="flex justify-between">
                                <span class="text-gray-500">Chủ tài khoản</span>
                                <span class="font-bold text-gray-800">{{ $groomInfo['account_name'] }}</span>
                            </div>
                            @endif
                            @if(!empty($groomInfo['description']))
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nội dung CK</span>
                                <span class="text-gray-700">{{ $groomInfo['description'] }}</span>
                            </div>
                            @endif
                            {{-- Fallback: old plain text --}}
                            @if(empty($groomInfo) && $wedding->groom_qr_info)
                            <p class="whitespace-pre-line text-gray-600">{{ $wedding->groom_qr_info }}</p>
                            @endif
                        </div>
                    </div>
                </template>

                <template x-if="showQr === 'bride'">
                    <div>
                        <img src="{{ $wedding->getBrideQrUrl() }}"
                             class="w-56 h-56 object-contain mx-auto mb-4 rounded-xl border border-gray-100 shadow-sm">
                        <div class="text-left bg-gray-50 rounded-xl p-4 space-y-2 text-sm">
                            @if(!empty($brideInfo['bank_bin']))
                            <div class="flex justify-between">
                                <span class="text-gray-500">Ngân hàng</span>
                                <span class="font-bold text-gray-800">{{ $bankNames[$brideInfo['bank_bin']] ?? $brideInfo['bank_bin'] }}</span>
                            </div>
                            @endif
                            @if(!empty($brideInfo['account_number']))
                            <div class="flex justify-between">
                                <span class="text-gray-500">Số tài khoản</span>
                                <span class="font-bold text-gray-800 font-mono tracking-wider">{{ $brideInfo['account_number'] }}</span>
                            </div>
                            @endif
                            @if(!empty($brideInfo['account_name']))
                            <div class="flex justify-between">
                                <span class="text-gray-500">Chủ tài khoản</span>
                                <span class="font-bold text-gray-800">{{ $brideInfo['account_name'] }}</span>
                            </div>
                            @endif
                            @if(!empty($brideInfo['description']))
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nội dung CK</span>
                                <span class="text-gray-700">{{ $brideInfo['description'] }}</span>
                            </div>
                            @endif
                            @if(empty($brideInfo) && $wedding->bride_qr_info)
                            <p class="whitespace-pre-line text-gray-600">{{ $wedding->bride_qr_info }}</p>
                            @endif
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>
