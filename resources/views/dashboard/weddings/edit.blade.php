<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Chỉnh sửa: {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    @if($wedding->tier === 'pro')
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Pro</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">Tiêu chuẩn</span>
                    @endif
                    • {{ $wedding->template?->name ?? 'N/A' }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="/w/{{ $wedding->slug }}" target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Xem trước
                </a>
                <a href="{{ route('dashboard.weddings.rsvps', $wedding) }}"
                   class="inline-flex items-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white text-sm font-medium rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Khách mời
                </a>
                <a href="{{ route('dashboard.weddings.wishes', $wedding) }}"
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Lời chúc
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif
            
            @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('dashboard.weddings.update', $wedding) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Tabs Navigation -->
                <div x-data="{ activeTab: 'basic' }" class="bg-white shadow-sm rounded-xl overflow-hidden">
                    <div class="border-b border-gray-200">
                        <nav class="flex flex-wrap -mb-px" aria-label="Tabs">
                            <button type="button" @click="activeTab = 'basic'" 
                                :class="activeTab === 'basic' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="flex-1 sm:flex-none py-4 px-4 sm:px-6 text-center border-b-2 font-medium text-sm whitespace-nowrap">
                                📋 Cơ bản
                            </button>
                            <button type="button" @click="activeTab = 'groom'" 
                                :class="activeTab === 'groom' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="flex-1 sm:flex-none py-4 px-4 sm:px-6 text-center border-b-2 font-medium text-sm whitespace-nowrap">
                                👔 Nhà Trai
                            </button>
                            <button type="button" @click="activeTab = 'bride'" 
                                :class="activeTab === 'bride' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="flex-1 sm:flex-none py-4 px-4 sm:px-6 text-center border-b-2 font-medium text-sm whitespace-nowrap">
                                👗 Nhà Gái
                            </button>
                            <button type="button" @click="activeTab = 'media'" 
                                :class="activeTab === 'media' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="flex-1 sm:flex-none py-4 px-4 sm:px-6 text-center border-b-2 font-medium text-sm whitespace-nowrap">
                                📸 Media
                            </button>
                            <button type="button" @click="activeTab = 'settings'" 
                                :class="activeTab === 'settings' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="flex-1 sm:flex-none py-4 px-4 sm:px-6 text-center border-b-2 font-medium text-sm whitespace-nowrap">
                                ⚙️ Cài đặt
                            </button>
                        </nav>
                    </div>

                    <div class="p-4 sm:p-6 lg:p-8">
                        <!-- TAB 1: THÔNG TIN CƠ BẢN -->
                        <div x-show="activeTab === 'basic'" x-cloak>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Thông tin cô dâu chú rể</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="groom_name" class="block text-sm font-medium text-gray-700 mb-2">Tên chú rể *</label>
                                    <input type="text" name="groom_name" id="groom_name" 
                                        value="{{ old('groom_name', $wedding->groom_name) }}" required
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Nguyễn Văn A">
                                    @error('groom_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="bride_name" class="block text-sm font-medium text-gray-700 mb-2">Tên cô dâu *</label>
                                    <input type="text" name="bride_name" id="bride_name" 
                                        value="{{ old('bride_name', $wedding->bride_name) }}" required
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Trần Thị B">
                                    @error('bride_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Ngày cưới</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">Ngày cưới chính *</label>
                                    <input type="date" name="event_date" id="event_date" 
                                        value="{{ old('event_date', $wedding->event_date?->format('Y-m-d')) }}" required
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                    <p class="text-xs text-gray-500 mt-1">Ngày âm lịch sẽ tự động tính</p>
                                    @error('event_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ngày âm lịch</label>
                                    <input type="text" value="{{ $wedding->event_date_lunar ?? 'Tự động cập nhật' }}" disabled
                                        class="w-full border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Mẫu thiệp</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="template_id" class="block text-sm font-medium text-gray-700 mb-2">Chọn mẫu *</label>
                                    <select name="template_id" id="template_id" required
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                        @foreach($templates as $template)
                                        <option value="{{ $template->id }}" {{ old('template_id', $wedding->template_id) == $template->id ? 'selected' : '' }}>
                                            [{{ $template->tier === 'pro' ? 'Pro' : 'Tiêu chuẩn' }}] {{ $template->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('template_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                                    <select name="status" id="status"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                        <option value="draft" {{ $wedding->status === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                        <option value="preview" {{ $wedding->status === 'preview' ? 'selected' : '' }}>Xem trước</option>
                                        <option value="published" {{ $wedding->status === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: NHÀ TRAI -->
                        <div x-show="activeTab === 'groom'" x-cloak>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">👔 Thông tin gia đình nhà trai</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="groom_father" class="block text-sm font-medium text-gray-700 mb-2">Ông (Cha)</label>
                                    <input type="text" name="groom_father" id="groom_father" 
                                        value="{{ old('groom_father', $wedding->groom_father) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Nguyễn Văn A">
                                </div>
                                <div>
                                    <label for="groom_mother" class="block text-sm font-medium text-gray-700 mb-2">Bà (Mẹ)</label>
                                    <input type="text" name="groom_mother" id="groom_mother" 
                                        value="{{ old('groom_mother', $wedding->groom_mother) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Trần Thị B">
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-4">💒 Lễ Thành Hôn (Nhà trai)</h3>
                            <p class="text-sm text-gray-500 mb-6">Lễ đón dâu tại nhà trai</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="groom_ceremony_time" class="block text-sm font-medium text-gray-700 mb-2">Giờ làm lễ</label>
                                    <input type="time" name="groom_ceremony_time" id="groom_ceremony_time" 
                                        value="{{ old('groom_ceremony_time', $wedding->groom_ceremony_time?->format('H:i')) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                </div>
                                <div>
                                    <label for="groom_ceremony_date" class="block text-sm font-medium text-gray-700 mb-2">Ngày</label>
                                    <input type="date" name="groom_ceremony_date" id="groom_ceremony_date" 
                                        value="{{ old('groom_ceremony_date', $wedding->groom_ceremony_date?->format('Y-m-d')) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                    <p class="text-xs text-gray-500 mt-1">Nếu khác ngày cưới chính</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="groom_address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                                    <textarea name="groom_address" id="groom_address" rows="2"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố">{{ old('groom_address', $wedding->groom_address) }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="groom_map_url" class="block text-sm font-medium text-gray-700 mb-2">Link Google Maps</label>
                                    <input type="url" name="groom_map_url" id="groom_map_url" 
                                        value="{{ old('groom_map_url', $wedding->groom_map_url) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="https://maps.google.com/...">
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-4">🍽️ Tiệc cưới nhà trai</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="groom_reception_time" class="block text-sm font-medium text-gray-700 mb-2">Giờ tiệc</label>
                                            <input type="time" name="groom_reception_time" id="groom_reception_time" 
                                                value="{{ old('groom_reception_time', $wedding->groom_reception_time?->format('H:i')) }}"
                                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                        </div>
                                        <div>
                                            <label for="groom_reception_date" class="block text-sm font-medium text-gray-700 mb-2">Ngày tiệc</label>
                                            <input type="date" name="groom_reception_date" id="groom_reception_date" 
                                                value="{{ old('groom_reception_date', $wedding->groom_reception_date?->format('Y-m-d')) }}"
                                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                            <p class="text-xs text-gray-500 mt-1">Để trống nếu chung ngày cưới</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="groom_reception_venue" class="block text-sm font-medium text-gray-700 mb-2">Tên nhà hàng/địa điểm</label>
                                    <input type="text" name="groom_reception_venue" id="groom_reception_venue" 
                                        value="{{ old('groom_reception_venue', $wedding->groom_reception_venue) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Nhà hàng ABC">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="groom_reception_address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ tiệc</label>
                                    <textarea name="groom_reception_address" id="groom_reception_address" rows="2"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Địa chỉ nhà hàng">{{ old('groom_reception_address', $wedding->groom_reception_address) }}</textarea>
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-4">💳 QR Mừng cưới nhà trai</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh QR Code</label>
                                    @if($wedding->getFirstMediaUrl('groom_qr'))
                                        <img src="{{ $wedding->getFirstMediaUrl('groom_qr') }}" alt="QR Nhà trai" class="w-32 h-32 object-contain mb-2 border rounded">
                                    @endif
                                    <input type="file" name="groom_qr" accept="image/*"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                </div>
                                <div>
                                    <label for="groom_qr_info" class="block text-sm font-medium text-gray-700 mb-2">Thông tin tài khoản</label>
                                    <textarea name="groom_qr_info" id="groom_qr_info" rows="4"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Ngân hàng: ...&#10;Số TK: ...&#10;Chủ TK: ...">{{ old('groom_qr_info', $wedding->groom_qr_info) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: NHÀ GÁI -->
                        <div x-show="activeTab === 'bride'" x-cloak>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">👗 Thông tin gia đình nhà gái</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="bride_father" class="block text-sm font-medium text-gray-700 mb-2">Ông (Cha)</label>
                                    <input type="text" name="bride_father" id="bride_father" 
                                        value="{{ old('bride_father', $wedding->bride_father) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Lê Văn C">
                                </div>
                                <div>
                                    <label for="bride_mother" class="block text-sm font-medium text-gray-700 mb-2">Bà (Mẹ)</label>
                                    <input type="text" name="bride_mother" id="bride_mother" 
                                        value="{{ old('bride_mother', $wedding->bride_mother) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Phạm Thị D">
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-4">💐 Lễ Vu Quy (Nhà gái)</h3>
                            <p class="text-sm text-gray-500 mb-6">Lễ gả con gái tại nhà gái</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="bride_ceremony_time" class="block text-sm font-medium text-gray-700 mb-2">Giờ làm lễ</label>
                                    <input type="time" name="bride_ceremony_time" id="bride_ceremony_time" 
                                        value="{{ old('bride_ceremony_time', $wedding->bride_ceremony_time?->format('H:i')) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                </div>
                                <div>
                                    <label for="bride_ceremony_date" class="block text-sm font-medium text-gray-700 mb-2">Ngày</label>
                                    <input type="date" name="bride_ceremony_date" id="bride_ceremony_date" 
                                        value="{{ old('bride_ceremony_date', $wedding->bride_ceremony_date?->format('Y-m-d')) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                    <p class="text-xs text-gray-500 mt-1">Nếu khác ngày cưới chính</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="bride_address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                                    <textarea name="bride_address" id="bride_address" rows="2"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố">{{ old('bride_address', $wedding->bride_address) }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="bride_map_url" class="block text-sm font-medium text-gray-700 mb-2">Link Google Maps</label>
                                    <input type="url" name="bride_map_url" id="bride_map_url" 
                                        value="{{ old('bride_map_url', $wedding->bride_map_url) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="https://maps.google.com/...">
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-4">🍽️ Tiệc cưới nhà gái</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="bride_reception_time" class="block text-sm font-medium text-gray-700 mb-2">Giờ tiệc</label>
                                            <input type="time" name="bride_reception_time" id="bride_reception_time" 
                                                value="{{ old('bride_reception_time', $wedding->bride_reception_time?->format('H:i')) }}"
                                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                        </div>
                                        <div>
                                            <label for="bride_reception_date" class="block text-sm font-medium text-gray-700 mb-2">Ngày tiệc</label>
                                            <input type="date" name="bride_reception_date" id="bride_reception_date" 
                                                value="{{ old('bride_reception_date', $wedding->bride_reception_date?->format('Y-m-d')) }}"
                                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                            <p class="text-xs text-gray-500 mt-1">Để trống nếu chung ngày cưới</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="bride_reception_venue" class="block text-sm font-medium text-gray-700 mb-2">Tên nhà hàng/địa điểm</label>
                                    <input type="text" name="bride_reception_venue" id="bride_reception_venue" 
                                        value="{{ old('bride_reception_venue', $wedding->bride_reception_venue) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Nhà hàng XYZ">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="bride_reception_address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ tiệc</label>
                                    <textarea name="bride_reception_address" id="bride_reception_address" rows="2"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Địa chỉ nhà hàng">{{ old('bride_reception_address', $wedding->bride_reception_address) }}</textarea>
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-4">💳 QR Mừng cưới nhà gái</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh QR Code</label>
                                    @if($wedding->getFirstMediaUrl('bride_qr'))
                                        <img src="{{ $wedding->getFirstMediaUrl('bride_qr') }}" alt="QR Nhà gái" class="w-32 h-32 object-contain mb-2 border rounded">
                                    @endif
                                    <input type="file" name="bride_qr" accept="image/*"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                </div>
                                <div>
                                    <label for="bride_qr_info" class="block text-sm font-medium text-gray-700 mb-2">Thông tin tài khoản</label>
                                    <textarea name="bride_qr_info" id="bride_qr_info" rows="4"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Ngân hàng: ...&#10;Số TK: ...&#10;Chủ TK: ...">{{ old('bride_qr_info', $wedding->bride_qr_info) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: MEDIA -->
                        <div x-show="activeTab === 'media'" x-cloak>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">🎵 Nhạc nền</h3>
                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-700 mb-2">File nhạc MP3</label>
                                @if($wedding->background_music)
                                    <p class="text-sm text-gray-500 mb-2">Đã có nhạc: {{ basename($wedding->background_music) }}</p>
                                @endif
                                <input type="file" name="background_music" accept="audio/mpeg,audio/mp3"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                <p class="text-xs text-gray-500 mt-1">Tối đa 10MB, định dạng MP3</p>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-6">📸 Ảnh đại diện</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh chia sẻ (OG Image)</label>
                                    @if($wedding->getFirstMediaUrl('cover'))
                                        <img src="{{ $wedding->getFirstMediaUrl('cover') }}" alt="Cover" class="w-full h-24 object-cover mb-2 border rounded">
                                    @endif
                                    <input type="file" name="cover" accept="image/*"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                    <p class="text-xs text-gray-500 mt-1">1200x630 - Hiện khi chia sẻ FB/Zalo</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh Hero Section</label>
                                    @if($wedding->getFirstMediaUrl('hero'))
                                        <img src="{{ $wedding->getFirstMediaUrl('hero') }}" alt="Hero" class="w-full h-24 object-cover mb-2 border rounded">
                                    @endif
                                    <input type="file" name="hero" accept="image/*"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                    <p class="text-xs text-gray-500 mt-1">9:16 - Ảnh lớn đầu trang</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh Chú rể</label>
                                    @if($wedding->getFirstMediaUrl('groom_photo'))
                                        <img src="{{ $wedding->getFirstMediaUrl('groom_photo') }}" alt="Groom" class="w-full h-24 object-cover mb-2 border rounded">
                                    @endif
                                    <input type="file" name="groom_photo" accept="image/*"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                    <p class="text-xs text-gray-500 mt-1">3:4 - Ảnh chân dung</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh Cô dâu</label>
                                    @if($wedding->getFirstMediaUrl('bride_photo'))
                                        <img src="{{ $wedding->getFirstMediaUrl('bride_photo') }}" alt="Bride" class="w-full h-24 object-cover mb-2 border rounded">
                                    @endif
                                    <input type="file" name="bride_photo" accept="image/*"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                    <p class="text-xs text-gray-500 mt-1">3:4 - Ảnh chân dung</p>
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-6">🖼️ Album ảnh</h3>
                            <div>
                                @if($wedding->getMedia('gallery')->count() > 0)
                                    <div class="grid grid-cols-4 md:grid-cols-6 gap-2 mb-4">
                                        @foreach($wedding->getMedia('gallery') as $media)
                                            <img src="{{ $media->getUrl() }}" alt="Gallery" class="w-full h-20 object-cover border rounded">
                                        @endforeach
                                    </div>
                                @endif
                                <input type="file" name="gallery[]" accept="image/*" multiple
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                <p class="text-xs text-gray-500 mt-1">Tối đa 20 ảnh. Có thể chọn nhiều ảnh cùng lúc.</p>
                            </div>
                        </div>

                        <!-- TAB 5: CÀI ĐẶT -->
                        <div x-show="activeTab === 'settings'" x-cloak>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">⚙️ Cài đặt chung</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">URL Slug</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">/w/</span>
                                        <input type="text" name="slug" id="slug" 
                                            value="{{ old('slug', $wedding->slug) }}"
                                            class="flex-1 border-gray-300 rounded-r-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                            placeholder="ten-cap-doi-2024">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Để trống hệ thống sẽ tự tạo</p>
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu xem thiệp</label>
                                    <input type="password" name="password" id="password" 
                                        value="{{ old('password', $wedding->password) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Để trống nếu không cần">
                                </div>
                            </div>

                            <div class="space-y-4 mb-8">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="is_auto_approve_wishes" value="1" 
                                        {{ $wedding->is_auto_approve_wishes ? 'checked' : '' }}
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                    <span class="text-sm font-medium text-gray-700">Tự động duyệt lời chúc</span>
                                </label>
                                <p class="text-xs text-gray-500 ml-7">Nếu bật, lời chúc sẽ hiện ngay lập tức không cần duyệt</p>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-6">✨ Hiệu ứng Premium</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="flex items-center space-x-3 mb-4">
                                        <input type="checkbox" name="show_preload" value="1" 
                                            {{ $wedding->show_preload ? 'checked' : '' }}
                                            class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                        <span class="text-sm font-medium text-gray-700">Animation mở cửa "囍"</span>
                                    </label>
                                    <p class="text-xs text-gray-500 ml-7">Hiển thị cửa Song Hỷ trượt mở khi vào thiệp</p>
                                </div>
                                <div>
                                    <label for="falling_effect" class="block text-sm font-medium text-gray-700 mb-2">Hiệu ứng rơi</label>
                                    <select name="falling_effect" id="falling_effect"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                        <option value="hearts" {{ $wedding->falling_effect === 'hearts' ? 'selected' : '' }}>💕 Tim rơi</option>
                                        <option value="petals" {{ $wedding->falling_effect === 'petals' ? 'selected' : '' }}>🌸 Cánh hoa</option>
                                        <option value="snow" {{ $wedding->falling_effect === 'snow' ? 'selected' : '' }}>❄️ Tuyết rơi</option>
                                        <option value="leaves" {{ $wedding->falling_effect === 'leaves' ? 'selected' : '' }}>🍂 Lá vàng</option>
                                        <option value="stars" {{ $wedding->falling_effect === 'stars' ? 'selected' : '' }}>⭐ Sao băng</option>
                                        <option value="none" {{ $wedding->falling_effect === 'none' ? 'selected' : '' }}>🚫 Không có</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Share Link -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Link chia sẻ thiệp cưới</label>
                                <div class="flex items-center gap-2">
                                    <input type="text" readonly value="{{ url('/w/' . $wedding->slug) }}" 
                                        class="flex-1 bg-white border-gray-300 rounded-lg text-gray-600 text-sm">
                                    <button type="button" onclick="navigator.clipboard.writeText('{{ url('/w/' . $wedding->slug) }}'); alert('Đã copy link!');" 
                                        class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fixed Bottom Actions -->
                    <div class="sticky bottom-0 bg-white border-t border-gray-200 px-4 sm:px-6 lg:px-8 py-4">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <a href="{{ route('dashboard.weddings.index') }}" class="text-gray-600 hover:text-gray-800">
                                ← Quay lại danh sách
                            </a>
                            <button type="submit" class="w-full sm:w-auto bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-lg font-medium">
                                💾 Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
