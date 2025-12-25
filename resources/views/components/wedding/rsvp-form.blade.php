{{-- RSVP Form Component --}}
{{-- Usage: @include('components.wedding.rsvp-form', ['wedding' => $wedding]) --}}

<section id="rsvp" class="py-16 px-4 bg-gradient-to-b from-white to-pink-50">
    <div class="max-w-xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-serif text-gray-800 mb-2">Xác Nhận Tham Dự</h2>
            <p class="text-gray-600">Vui lòng xác nhận để chúng tôi chuẩn bị chu đáo hơn</p>
        </div>
        
        {{-- Success/Error Messages --}}
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg text-center">
            {{ session('error') }}
        </div>
        @endif
        
        <form action="{{ route('wedding.rsvp.store', $wedding->slug) }}" method="POST" 
              class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
            @csrf
            
            {{-- Name --}}
            <div>
                <label for="rsvp_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Họ và Tên <span class="text-red-500">*</span>
                </label>
                <input type="text" id="rsvp_name" name="name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition"
                    placeholder="Nguyễn Văn A">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            {{-- Phone --}}
            <div>
                <label for="rsvp_phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Số điện thoại
                </label>
                <input type="tel" id="rsvp_phone" name="phone"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition"
                    placeholder="0912 345 678">
            </div>
            
            {{-- Attendance --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Bạn có thể tham dự không? <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="relative">
                        <input type="radio" name="attendance" value="yes" required class="peer sr-only" checked>
                        <div class="p-4 text-center border-2 rounded-xl cursor-pointer transition
                                    peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700
                                    hover:border-gray-400">
                            <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm font-medium">Sẽ đến</span>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="attendance" value="maybe" class="peer sr-only">
                        <div class="p-4 text-center border-2 rounded-xl cursor-pointer transition
                                    peer-checked:border-yellow-500 peer-checked:bg-yellow-50 peer-checked:text-yellow-700
                                    hover:border-gray-400">
                            <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium">Chưa chắc</span>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="attendance" value="no" class="peer sr-only">
                        <div class="p-4 text-center border-2 rounded-xl cursor-pointer transition
                                    peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700
                                    hover:border-gray-400">
                            <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span class="text-sm font-medium">Không thể</span>
                        </div>
                    </label>
                </div>
            </div>
            
            {{-- Number of Guests --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="rsvp_guests" class="block text-sm font-medium text-gray-700 mb-2">
                        Số người tham dự
                    </label>
                    <select id="rsvp_guests" name="guests"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }} người</option>
                        @endfor
                    </select>
                </div>
                
                <div>
                    <label for="rsvp_side" class="block text-sm font-medium text-gray-700 mb-2">
                        Khách của
                    </label>
                    <select id="rsvp_side" name="side"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        <option value="both">Cả hai bên</option>
                        <option value="groom">Nhà trai</option>
                        <option value="bride">Nhà gái</option>
                    </select>
                </div>
            </div>
            
            {{-- Note --}}
            <div>
                <label for="rsvp_note" class="block text-sm font-medium text-gray-700 mb-2">
                    Ghi chú (tuỳ chọn)
                </label>
                <textarea id="rsvp_note" name="note" rows="2"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition resize-none"
                    placeholder="Dị ứng thực phẩm, yêu cầu đặc biệt..."></textarea>
            </div>
            
            {{-- Submit --}}
            <button type="submit"
                class="w-full py-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-medium rounded-xl hover:from-pink-600 hover:to-rose-600 transition shadow-lg hover:shadow-xl">
                Gửi Xác Nhận
            </button>
        </form>
    </div>
</section>
