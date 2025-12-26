<x-dashboard-layout>
    <x-slot:header>Tạo Name Card Mới</x-slot:header>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl p-8">
            <form method="POST" action="{{ route('dashboard.cards.store') }}">
                @csrf
                
                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ và Tên *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Nguyễn Văn A">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Chức vụ</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Giám đốc điều hành">
                        </div>
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Công ty</label>
                            <input type="text" name="company" id="company" value="{{ old('company') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Công ty ABC">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0912345678">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="email@company.com">
                        </div>
                    </div>
                    
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input type="url" name="website" id="website" value="{{ old('website') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="https://example.com">
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="123 Đường ABC, Quận 1, TP.HCM">
                    </div>
                    
                    <div>
                        <label for="about" class="block text-sm font-medium text-gray-700 mb-2">Giới thiệu</label>
                        <textarea name="about" id="about" rows="4"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Mô tả ngắn về bạn...">{{ old('about') }}</textarea>
                    </div>
                    
                    <div>
                        <label for="template_id" class="block text-sm font-medium text-gray-700 mb-2">Chọn Mẫu *</label>
                        <select name="template_id" id="template_id" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Chọn mẫu --</option>
                            @foreach($templates as $template)
                            <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                {{ $template->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('template_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="mt-8 flex items-center justify-end gap-4">
                    <a href="{{ route('dashboard.cards.index') }}" class="text-gray-600 hover:text-gray-800">Hủy</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                        💼 Tạo Name Card
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
