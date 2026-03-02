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
        
        <div class="bg-white w-full max-w-sm relative shadow-2xl overflow-y-auto max-h-[90vh]" 
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
                        {{-- Action buttons --}}
                        <div class="flex gap-3 mt-4">
                            @if(!empty($groomInfo['account_number']))
                            <button type="button"
                                x-data="{ copied: false }"
                                @click="navigator.clipboard.writeText('{{ $groomInfo['account_number'] }}'); copied=true; setTimeout(()=>copied=false,2000)"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span x-show="!copied">Sao chép số TK</span>
                                <span x-show="copied" class="text-green-600">✓ Đã sao chép!</span>
                            </button>
                            @endif
                            <button type="button"
                                @click="fetch('{{ $wedding->getGroomQrUrl() }}').then(r=>r.blob()).then(b=>{ const a=document.createElement('a'); a.href=URL.createObjectURL(b); a.download='qr-nha-trai.jpg'; a.click(); })"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Tải QR về
                            </button>
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
                        {{-- Action buttons --}}
                        <div class="flex gap-3 mt-4">
                            @if(!empty($brideInfo['account_number']))
                            <button type="button"
                                x-data="{ copied: false }"
                                @click="navigator.clipboard.writeText('{{ $brideInfo['account_number'] }}'); copied=true; setTimeout(()=>copied=false,2000)"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span x-show="!copied">Sao chép số TK</span>
                                <span x-show="copied" class="text-green-600">✓ Đã sao chép!</span>
                            </button>
                            @endif
                            <button type="button"
                                @click="fetch('{{ $wedding->getBrideQrUrl() }}').then(r=>r.blob()).then(b=>{ const a=document.createElement('a'); a.href=URL.createObjectURL(b); a.download='qr-nha-gai.jpg'; a.click(); })"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Tải QR về
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>
