<x-dashboard-layout>
    <x-slot:header>Danh thiếp của tôi</x-slot:header>

    @if($cards->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cards as $card)
        <div class="bg-white overflow-hidden shadow-sm rounded-xl hover:shadow-lg transition">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-2xl">💼</div>
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $card->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $card->title }}</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">{{ $card->company }}</p>
                <p class="text-xs text-gray-400 mb-4">{{ $card->template?->name ?? 'Chưa chọn mẫu' }}</p>
                
                <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                    <a href="/p/{{ $card->slug }}" target="_blank" class="flex-1 text-center py-2 text-gray-600 hover:text-gray-800 text-sm border border-gray-200 rounded-lg hover:bg-gray-50">Xem</a>
                    <a href="{{ route('dashboard.cards.edit', $card) }}" class="flex-1 text-center py-2 text-blue-600 hover:text-white text-sm border border-blue-200 rounded-lg hover:bg-blue-600">Sửa</a>
                    <form method="POST" action="{{ route('dashboard.cards.destroy', $card) }}" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg">🗑</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-6">{{ $cards->links() }}</div>
    @else
    <div class="bg-white rounded-xl p-12 text-center">
        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">🪪</div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có Name Card nào</h3>
        <p class="text-gray-500 mb-6">Bắt đầu tạo danh thiếp điện tử đầu tiên của bạn!</p>
        <a href="{{ route('dashboard.cards.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            + Tạo Name Card đầu tiên
        </a>
    </div>
    @endif
</x-dashboard-layout>
