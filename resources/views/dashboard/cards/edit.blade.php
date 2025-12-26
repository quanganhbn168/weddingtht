<x-dashboard-layout>
    <x-slot:header>Chỉnh sửa Name Card</x-slot:header>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl p-8">
            <form method="POST" action="{{ route('dashboard.cards.update', $card) }}">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ và Tên *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $card->name) }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Chức vụ</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $card->title) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Công ty</label>
                            <input type="text" name="company" id="company" value="{{ old('company', $card->company) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $card->phone) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $card->email) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input type="url" name="website" id="website" value="{{ old('website', $card->website) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $card->address) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="about" class="block text-sm font-medium text-gray-700 mb-2">Giới thiệu</label>
                        <textarea name="about" id="about" rows="4"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('about', $card->about) }}</textarea>
                    </div>
                    
                    <div>
                        <label for="template_id" class="block text-sm font-medium text-gray-700 mb-2">Mẫu *</label>
                        <select name="template_id" id="template_id" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @foreach($templates as $template)
                            <option value="{{ $template->id }}" {{ old('template_id', $card->template_id) == $template->id ? 'selected' : '' }}>
                                {{ $template->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Share Link -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link chia sẻ</label>
                        <div class="flex items-center gap-2">
                            <input type="text" readonly value="{{ url('/p/' . $card->slug) }}" 
                                class="flex-1 bg-white border-gray-300 rounded-lg text-gray-600 text-sm">
                            <button type="button" onclick="navigator.clipboard.writeText('{{ url('/p/' . $card->slug) }}')" 
                                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm">Copy</button>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex items-center justify-between">
                    <a href="/p/{{ $card->slug }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                        👁 Xem trước
                    </a>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard.cards.index') }}" class="text-gray-600 hover:text-gray-800">Quay lại</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                            💾 Lưu thay đổi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
