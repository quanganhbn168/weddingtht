{{-- 
    SHARED: Guestbook Component
    Usage: <x-wedding.guestbook :wedding="$wedding" />
    Theming: Uses CSS vars from template's :root
--}}
@props(['wedding'])
@php $wishes = $wedding->approvedWishes()->latest()->take(10)->get(); @endphp

<div class="card-glass p-6 text-center">
    <h2 class="font-script text-4xl text-gold mb-2">{{ $wedding->getContentValue('guestbook_title', 'Sổ Lưu Bút') }}</h2>
    <div class="w-12 h-px bg-gold mx-auto mb-4"></div>
    <p class="text-sm text-gray-500 italic mb-6">{{ $wedding->getContentValue('guestbook_desc', 'Hãy để lại những lời chúc phúc tốt đẹp nhất cho chúng tôi nhé!') }}</p>

    {{-- Wish Slider --}}
    @if($wishes->count() > 0)
    <div class="mb-8 px-4">
        <div class="swiper guestbookSlider pb-8">
            <div class="swiper-wrapper">
                @foreach($wishes as $wish)
                <div class="swiper-slide text-center px-2">
                    <div class="text-4xl font-script text-gold/20 mb-2">"</div>
                    <p class="text-lg text-gray-700 italic font-display leading-relaxed mb-4">{{ $wish->message }}</p>
                    <p class="font-bold text-gold text-sm uppercase tracking-widest">{{ $wish->name }}</p>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    @else
    <p class="text-gray-400 italic mb-6">Chưa có lời chúc nào. Hãy là người đầu tiên!</p>
    @endif

    {{-- Wish Form --}}
    <div x-data="{
        open: false,
        submitting: false,
        success: false,
        error: null,
        formData: { name: '', message: '' },
        async submitWish() {
            this.submitting = true;
            this.error = null;
            try {
                const r = await fetch('{{ route('wedding.wish.store', $wedding->slug) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.formData)
                });
                if (r.ok) {
                    this.success = true;
                    this.formData = { name: '', message: '' };
                    setTimeout(() => { this.success = false; this.open = false; }, 3000);
                } else {
                    const d = await r.json();
                    this.error = d.message || 'Có lỗi xảy ra.';
                }
            } catch(e) { this.error = 'Lỗi kết nối.'; }
            finally { this.submitting = false; }
        }
    }">
        <button @click="open = true" class="btn-gold px-8 py-3 rounded-full text-sm font-bold uppercase tracking-widest">Gửi Lời Chúc</button>

        {{-- Modal --}}
        <div x-show="open" style="display:none" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-md" x-transition.opacity>
            <div class="bg-white rounded-3xl p-6 max-w-md w-full relative shadow-2xl" @click.outside="open = false">
                <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <h3 class="font-display text-2xl text-gold text-center mb-4 font-bold">Viết Lời Chúc</h3>

                <div x-show="success" class="text-center py-6">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="font-bold text-gray-800">Đã Gửi Thành Công!</p>
                </div>

                <form @submit.prevent="submitWish" x-show="!success" class="space-y-4 text-left">
                    <div x-show="error" class="p-3 bg-red-50 text-red-600 text-sm rounded-lg text-center" x-text="error"></div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Tên</label>
                        <input type="text" x-model="formData.name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-1 focus:ring-gold outline-none bg-gray-50/50">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Lời chúc</label>
                        <textarea x-model="formData.message" required rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-1 focus:ring-gold outline-none bg-gray-50/50 resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 btn-gold rounded-xl font-bold uppercase text-sm" :disabled="submitting">
                        <span x-show="!submitting">Gửi Ngay</span>
                        <span x-show="submitting">Đang Gửi...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
