<x-dashboard-layout>
    <x-slot:header>Tạo Thiệp Cưới Mới</x-slot:header>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl p-8">
            <form method="POST" action="{{ route('dashboard.weddings.store') }}">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Groom Name -->
                    <div>
                        <label for="groom_name" class="block text-sm font-medium text-gray-700 mb-2">Tên Chú Rể *</label>
                        <input type="text" name="groom_name" id="groom_name" value="{{ old('groom_name') }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                            placeholder="Nguyễn Văn A">
                        @error('groom_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Bride Name -->
                    <div>
                        <label for="bride_name" class="block text-sm font-medium text-gray-700 mb-2">Tên Cô Dâu *</label>
                        <input type="text" name="bride_name" id="bride_name" value="{{ old('bride_name') }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500"
                            placeholder="Trần Thị B">
                        @error('bride_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Event Date -->
                    <div>
                        <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">Ngày Cưới *</label>
                        <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        @error('event_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Template -->
                    <div>
                        <label for="template_id" class="block text-sm font-medium text-gray-700 mb-2">Chọn Mẫu Thiệp *</label>
                        <select name="template_id" id="template_id" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                            <option value="">-- Chọn mẫu --</option>
                            @foreach($templates as $template)
                            <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                [{{ $template->tier === 'pro' ? 'Pro' : 'Tiêu chuẩn' }}] {{ $template->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('template_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <hr class="my-8">
                
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin Gia đình (Tùy chọn)</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="groom_father" class="block text-sm font-medium text-gray-700 mb-2">Bố Chú Rể</label>
                        <input type="text" name="groom_father" id="groom_father" value="{{ old('groom_father') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                    </div>
                    <div>
                        <label for="groom_mother" class="block text-sm font-medium text-gray-700 mb-2">Mẹ Chú Rể</label>
                        <input type="text" name="groom_mother" id="groom_mother" value="{{ old('groom_mother') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                    </div>
                    <div>
                        <label for="bride_father" class="block text-sm font-medium text-gray-700 mb-2">Bố Cô Dâu</label>
                        <input type="text" name="bride_father" id="bride_father" value="{{ old('bride_father') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                    </div>
                    <div>
                        <label for="bride_mother" class="block text-sm font-medium text-gray-700 mb-2">Mẹ Cô Dâu</label>
                        <input type="text" name="bride_mother" id="bride_mother" value="{{ old('bride_mother') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                    </div>
                </div>
                
                <div class="mt-8 flex items-center justify-end gap-4">
                    <a href="{{ route('dashboard.weddings.index') }}" class="text-gray-600 hover:text-gray-800">Hủy</a>
                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg font-medium">
                        💒 Tạo Thiệp Cưới
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
