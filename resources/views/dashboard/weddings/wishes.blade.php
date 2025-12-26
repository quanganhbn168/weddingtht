<x-dashboard-layout>
    <x-slot:header>Lời chúc: {{ $wedding->groom_name }} & {{ $wedding->bride_name }}</x-slot:header>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</div>
            <div class="text-sm text-gray-500">Tổng lời chúc</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
            <div class="text-sm text-gray-500">Chờ duyệt</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['approved'] }}</div>
            <div class="text-sm text-gray-500">Đã duyệt</div>
        </div>
    </div>

    <!-- Top Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <a href="{{ route('dashboard.weddings.edit', $wedding) }}" class="text-pink-600 hover:text-pink-800 text-sm font-medium">
            ← Quay lại sửa thiệp
        </a>
        
        <!-- Filters -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('dashboard.weddings.wishes', ['wedding' => $wedding, 'filter' => 'all']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium {{ $filter === 'all' ? 'bg-pink-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
                Tất cả
            </a>
            <a href="{{ route('dashboard.weddings.wishes', ['wedding' => $wedding, 'filter' => 'pending']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium {{ $filter === 'pending' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
                Chờ duyệt ({{ $stats['pending'] }})
            </a>
            <a href="{{ route('dashboard.weddings.wishes', ['wedding' => $wedding, 'filter' => 'approved']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium {{ $filter === 'approved' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
                Đã duyệt ({{ $stats['approved'] }})
            </a>
        </div>
    </div>

    <!-- Wishes List -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        @forelse($wishes as $wish)
        <div class="p-6 border-b border-gray-100 last:border-0 {{ !$wish->is_approved ? 'bg-yellow-50' : '' }}">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="font-semibold text-gray-900">{{ $wish->name }}</span>
                        @if(!$wish->is_approved)
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Chờ duyệt</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Đã duyệt</span>
                        @endif
                    </div>
                    <p class="text-gray-600">{{ $wish->message }}</p>
                    <p class="text-xs text-gray-400 mt-2">{{ $wish->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @if(!$wish->is_approved)
                    <form method="POST" action="{{ route('dashboard.weddings.wishes.approve', [$wedding, $wish->id]) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg">
                            ✓ Duyệt
                        </button>
                    </form>
                    @endif
                    <form method="POST" action="{{ route('dashboard.weddings.wishes.delete', [$wedding, $wish->id]) }}"
                          onsubmit="return confirm('Bạn có chắc muốn xóa lời chúc này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg">
                            🗑 Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <p class="mt-4">Chưa có lời chúc nào</p>
        </div>
        @endforelse

        <!-- Pagination -->
        @if($wishes->hasPages())
        <div class="p-4 border-t">
            {{ $wishes->links() }}
        </div>
        @endif
    </div>
</x-dashboard-layout>
