<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Name Card của tôi') }}
            </h2>
            <a href="{{ route('dashboard.cards.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tạo mới
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
            @endif

            @if($cards->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($cards as $card)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-2xl">
                                💼
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $card->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $card->title }}</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">{{ $card->company }}</p>
                        <p class="text-xs text-gray-400 mb-4">{{ $card->template?->name ?? 'Chưa chọn mẫu' }}</p>
                        
                        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                            <a href="/p/{{ $card->slug }}" target="_blank" class="flex-1 text-center py-2 text-gray-600 hover:text-gray-800 text-sm border border-gray-200 rounded-lg hover:bg-gray-50">Xem</a>
                            <a href="{{ route('dashboard.cards.edit', $card) }}" class="flex-1 text-center py-2 text-indigo-600 hover:text-white text-sm border border-indigo-200 rounded-lg hover:bg-indigo-600">Sửa</a>
                            <form method="POST" action="{{ route('dashboard.cards.destroy', $card) }}" class="flex-shrink-0" onsubmit="return confirm('Bạn có chắc muốn xóa Name Card này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $cards->links() }}
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-12 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                    🪪
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có Name Card nào</h3>
                <p class="text-gray-500 mb-6">Bắt đầu tạo danh thiếp điện tử đầu tiên của bạn!</p>
                <a href="{{ route('dashboard.cards.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tạo Name Card đầu tiên
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
