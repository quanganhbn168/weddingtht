<x-dashboard-layout>
    <x-slot:header>Bảng giá Thiệp Cưới</x-slot:header>

    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Chọn gói phù hợp với bạn</h1>
            <p class="text-gray-600">THT Media thiết kế và cài đặt hoàn chỉnh từ A-Z. Chỉ cần gửi ảnh và thông tin!</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Basic Plan -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-200">
                <div class="text-center mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-600 text-2xl mx-auto mb-4"><i class="fas fa-leaf"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ \App\Enums\WeddingTier::BASIC->label() }}</h3>
                    <div class="text-3xl font-bold text-gray-900 mb-1">{{ \App\Models\Setting::formatPrice(\App\Models\Setting::getTierPrice('basic')) }}</div>
                    <div class="text-gray-500 text-sm">VNĐ / trọn gói</div>
                </div>
                
                <ul class="space-y-3 mb-6 text-sm">
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Templates Cơ bản
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ \App\Models\Setting::getTierMaxPhotos('basic') }} ảnh cưới
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Lưu trữ {{ \App\Models\Setting::getTierExpiry('basic') }} tháng
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        RSVP & Guestbook
                    </li>
                    <li class="flex items-center gap-2 text-gray-400">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="line-through">Hiệu ứng rơi</span>
                    </li>
                </ul>
                
                <a href="#contact" class="block w-full py-3 bg-gray-100 text-gray-700 rounded-lg font-medium text-center hover:bg-gray-200 transition">
                    Liên hệ đặt thiệp
                </a>
            </div>
            
            <!-- Standard Plan - Popular -->
            <div class="bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl shadow-xl p-6 text-white transform md:scale-105 relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1 rounded-full">Phổ biến nhất</div>
                <div class="text-center mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-white text-2xl mx-auto mb-4"><i class="fas fa-heart"></i></div>
                    <h3 class="text-xl font-bold mb-2">{{ \App\Enums\WeddingTier::STANDARD->label() }}</h3>
                    <div class="text-3xl font-bold mb-1">{{ \App\Models\Setting::formatPrice(\App\Models\Setting::getTierPrice('standard')) }}</div>
                    <div class="text-blue-200 text-sm">VNĐ / trọn gói</div>
                </div>
                
                <ul class="space-y-3 mb-6 text-sm">
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Templates Tiêu chuẩn
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <strong>{{ \App\Models\Setting::getTierMaxPhotos('standard') }} ảnh cưới</strong>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <strong>Lưu trữ {{ \App\Models\Setting::getTierExpiry('standard') }} tháng</strong>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <strong>Hiệu ứng Tim/Tuyết/Hoa rơi</strong>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Thống kê lượt truy cập
                    </li>
                </ul>
                
                <a href="#contact" class="block w-full py-3 bg-white text-indigo-600 rounded-lg font-bold text-center hover:bg-indigo-50 transition">
                    Đăng ký ngay
                </a>
            </div>
            
            <!-- Pro Plan -->
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl shadow-lg p-6 border-2 border-amber-400 relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold px-4 py-1 rounded-full">⭐ Premium</div>
                <div class="text-center mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 flex items-center justify-center text-white text-2xl mx-auto mb-4"><i class="fas fa-crown"></i></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ \App\Enums\WeddingTier::PRO->label() }}</h3>
                    <div class="text-3xl font-bold text-amber-600 mb-1">{{ \App\Models\Setting::formatPrice(\App\Models\Setting::getTierPrice('pro')) }}</div>
                    <div class="text-gray-500 text-sm">VNĐ / trọn gói</div>
                </div>
                
                <ul class="space-y-3 mb-6 text-sm">
                    <li class="flex items-center gap-2 text-gray-700">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <strong>Kho mẫu Premium</strong>
                    </li>
                    <li class="flex items-center gap-2 text-gray-700">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <strong>Ảnh không giới hạn</strong>
                    </li>
                    <li class="flex items-center gap-2 text-gray-700">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <strong>Lưu trữ vĩnh viễn</strong>
                    </li>
                    <li class="flex items-center gap-2 text-gray-700">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <strong>Màn mở thiệp 3D</strong>
                    </li>
                    <li class="flex items-center gap-2 text-gray-700">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <strong>Ghi tên khách cá nhân hóa</strong>
                    </li>
                </ul>
                
                <a href="#contact" class="block w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg font-bold text-center hover:opacity-90 transition">
                    Đăng ký ngay
                </a>
            </div>
        </div>
        
        <div class="mt-12 text-center text-gray-500 text-sm">
            <p>Có câu hỏi? Liên hệ <a href="tel:0375433678" class="text-pink-600 hover:underline">0375 433 678</a> hoặc <a href="mailto:support@thtmedia.com.vn" class="text-pink-600 hover:underline">support@thtmedia.com.vn</a></p>
        </div>
    </div>
</x-dashboard-layout>

