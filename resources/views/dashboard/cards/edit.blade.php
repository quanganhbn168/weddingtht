<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chỉnh sửa Name Card') }}
            </h2>
            <a href="/p/{{ $card->slug }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm flex items-center gap-1">
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
                <form method="POST" action="{{ route('dashboard.cards.update', $card) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ và Tên *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $card->name) }}" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Chức vụ</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $card->title) }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Company -->
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Công ty</label>
                                <input type="text" name="company" id="company" value="{{ old('company', $card->company) }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $card->phone) }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $card->email) }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                            <input type="url" name="website" id="website" value="{{ old('website', $card->website) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $card->address) }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <!-- About -->
                        <div>
                            <label for="about" class="block text-sm font-medium text-gray-700 mb-2">Giới thiệu bản thân</label>
                            <textarea name="about" id="about" rows="4"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('about', $card->about) }}</textarea>
                        </div>
                        
                        <!-- Template -->
                        <div>
                            <label for="template_id" class="block text-sm font-medium text-gray-700 mb-2">Mẫu Name Card *</label>
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
                    
                    <div class="mt-8 flex items-center justify-end gap-4">
                        <a href="{{ route('dashboard.cards.index') }}" class="text-gray-600 hover:text-gray-800">Quay lại</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                            Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
