{{-- 
    SHARED: RSVP Form Component
    Usage: <x-wedding.rsvp-form :wedding="$wedding" />
    Theming: Uses CSS vars from template's :root (--color-primary, etc.)
    Template wraps this in its own <section> with decorations
--}}
@props(['wedding'])

<div class="card-glass p-6 text-center relative overflow-hidden">
    <h2 class="font-script text-4xl text-gold mb-2">Xác Nhận Tham Dự</h2>
    <div class="w-12 h-px bg-gold mx-auto mb-4"></div>
    <p class="text-sm text-gray-500 italic mb-8">{{ $wedding->getContentValue('rsvp_desc', 'Sự hiện diện của bạn là niềm vinh hạnh của chúng tôi.') }}</p>

    <div x-data="{
        submitting: false,
        success: false,
        error: null,
        formData: {
            name: '{{ $wedding->getGuestName() ? urldecode($wedding->getGuestName()) : '' }}',
            phone: '',
            attendance: 'yes',
            guests: '1',
            side: 'both',
            note: ''
        },
        async submitRsvp() {
            this.submitting = true;
            this.error = null;
            try {
                const r = await fetch('{{ route('wedding.rsvp.store', $wedding->slug) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.formData)
                });
                if (r.ok) { this.success = true; }
                else { const d = await r.json(); this.error = d.message || 'Có lỗi.'; }
            } catch(e) { this.error = 'Lỗi kết nối.'; }
            finally { this.submitting = false; }
        }
    }">
        {{-- Success --}}
        <div x-show="success" class="py-6" style="display:none">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <p class="font-bold text-gray-800">Xác nhận thành công!</p>
        </div>

        {{-- Form --}}
        <form @submit.prevent="submitRsvp" x-show="!success" class="space-y-4 text-left max-w-sm mx-auto">
            <div x-show="error" class="p-3 bg-red-50 text-red-600 text-sm rounded-lg text-center" x-text="error" style="display:none"></div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Họ và tên *</label>
                <input type="text" x-model="formData.name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-1 focus:ring-gold outline-none bg-white/50">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Số điện thoại</label>
                <input type="tel" x-model="formData.phone" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-1 focus:ring-gold outline-none bg-white/50">
            </div>

            <div class="text-center py-2">
                <label class="block text-xs font-bold uppercase text-gray-400 mb-3">Bạn sẽ tham dự chứ?</label>
                <div class="flex justify-center gap-2">
                    <label class="cursor-pointer"><input type="radio" x-model="formData.attendance" value="yes" class="sr-only"><div class="px-5 py-2 border rounded-full text-xs font-bold transition-all" :style="formData.attendance === 'yes' ? 'background: var(--color-primary); color: white; border-color: var(--color-primary);' : ''">Sẽ Tham Dự</div></label>
                    <label class="cursor-pointer"><input type="radio" x-model="formData.attendance" value="maybe" class="sr-only"><div class="px-5 py-2 border rounded-full text-xs font-bold transition-all" :style="formData.attendance === 'maybe' ? 'background: #EAB308; color: white; border-color: #EAB308;' : ''">Chưa Chắc</div></label>
                    <label class="cursor-pointer"><input type="radio" x-model="formData.attendance" value="no" class="sr-only"><div class="px-5 py-2 border rounded-full text-xs font-bold transition-all" :style="formData.attendance === 'no' ? 'background: #57534E; color: white; border-color: #57534E;' : ''">Rất Tiếc</div></label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-xs font-bold uppercase text-gray-400 mb-1">Số Khách</label><select x-model="formData.guests" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold outline-none bg-white/50"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5+</option></select></div>
                <div><label class="block text-xs font-bold uppercase text-gray-400 mb-1">Khách Của</label><select x-model="formData.side" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold outline-none bg-white/50"><option value="both">Bạn Chung</option><option value="groom">Nhà Trai</option><option value="bride">Nhà Gái</option></select></div>
            </div>

            <button type="submit" class="w-full py-3 btn-gold rounded-xl font-bold uppercase text-sm tracking-widest" :disabled="submitting">
                <span x-show="!submitting">Gửi Xác Nhận</span>
                <span x-show="submitting">Đang Gửi...</span>
            </button>
        </form>
    </div>
</div>
