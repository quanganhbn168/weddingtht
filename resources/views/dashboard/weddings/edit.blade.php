<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chỉnh sửa Thiệp Cưới') }}
            </h2>
            <a href="/w/{{ $wedding->slug }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Xem trước
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8">
                <form method="POST" action="{{ route('dashboard.weddings.update', $wedding) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="groom_name" class="block text-sm font-medium text-gray-700 mb-2">Tên Chú Rể *</label>
                            <input type="text" name="groom_name" id="groom_name" value="{{ old('groom_name', $wedding->groom_name) }}" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        </div>
                        
                        <div>
                            <label for="bride_name" class="block text-sm font-medium text-gray-700 mb-2">Tên Cô Dâu *</label>
                            <input type="text" name="bride_name" id="bride_name" value="{{ old('bride_name', $wedding->bride_name) }}" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        </div>
                        
                        <div>
                            <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">Ngày Cưới *</label>
                            <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $wedding->event_date?->format('Y-m-d')) }}" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        </div>
                        
                        <div>
                            <label for="template_id" class="block text-sm font-medium text-gray-700 mb-2">Mẫu Thiệp *</label>
                            <select name="template_id" id="template_id" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                @foreach($templates as $template)
                                <option value="{{ $template->id }}" {{ old('template_id', $wedding->template_id) == $template->id ? 'selected' : '' }}>
                                    {{ $template->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                            <select name="status" id="status"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                <option value="draft" {{ $wedding->status === 'draft' ? 'selected' : '' }}>Nháp</option>
                                <option value="preview" {{ $wedding->status === 'preview' ? 'selected' : '' }}>Xem trước</option>
                                <option value="published" {{ $wedding->status === 'published' ? 'selected' : '' }}>Đã đăng</option>
                            </select>
                        </div>
                    </div>
                    
                    <hr class="my-8">
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin Gia đình</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="groom_father" class="block text-sm font-medium text-gray-700 mb-2">Bố Chú Rể</label>
                            <input type="text" name="groom_father" id="groom_father" value="{{ old('groom_father', $wedding->groom_father) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        </div>
                        <div>
                            <label for="groom_mother" class="block text-sm font-medium text-gray-700 mb-2">Mẹ Chú Rể</label>
                            <input type="text" name="groom_mother" id="groom_mother" value="{{ old('groom_mother', $wedding->groom_mother) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        </div>
                        <div>
                            <label for="bride_father" class="block text-sm font-medium text-gray-700 mb-2">Bố Cô Dâu</label>
                            <input type="text" name="bride_father" id="bride_father" value="{{ old('bride_father', $wedding->bride_father) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        </div>
                        <div>
                            <label for="bride_mother" class="block text-sm font-medium text-gray-700 mb-2">Mẹ Cô Dâu</label>
                            <input type="text" name="bride_mother" id="bride_mother" value="{{ old('bride_mother', $wedding->bride_mother) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        </div>
                    </div>
                    
                    <!-- Share Link -->
                    <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link chia sẻ thiệp cưới</label>
                        <div class="flex items-center gap-2">
                            <input type="text" readonly value="{{ url('/w/' . $wedding->slug) }}" 
                                class="flex-1 bg-white border-gray-300 rounded-lg text-gray-600 text-sm">
                            <button type="button" onclick="navigator.clipboard.writeText('{{ url('/w/' . $wedding->slug) }}')" 
                                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm">Copy</button>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex items-center justify-end gap-4">
                        <a href="{{ route('dashboard.weddings.index') }}" class="text-gray-600 hover:text-gray-800">Quay lại</a>
                        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg font-medium">
                            Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
