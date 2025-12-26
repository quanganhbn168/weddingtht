<x-dashboard-layout>
    <x-slot:header>Danh sách Thiệp cưới</x-slot:header>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-pink-100 text-pink-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $weddings->total() }}</h3>
                    <p class="text-sm text-gray-500">Tổng thiệp</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $weddings->where('status', 'published')->count() }}</h3>
                    <p class="text-sm text-gray-500">Đã xuất bản</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $weddings->where('tier', 'pro')->count() }}</h3>
                    <p class="text-sm text-gray-500">Gói Pro</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Wedding List -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        @if($weddings->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($weddings as $wedding)
                <div class="p-4 sm:p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <!-- Wedding Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-semibold text-gray-900 truncate">
                                    {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
                                </h3>
                            </div>
                            <p class="text-sm text-gray-500">
                                {{ $wedding->event_date?->format('d/m/Y') }} • {{ $wedding->template?->name ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Badges -->
                        <div class="flex flex-wrap gap-2">
                            @if($wedding->tier === 'pro')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pro</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">Tiêu chuẩn</span>
                            @endif
                            
                            @if($wedding->can_share)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Công khai</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Riêng tư</span>
                            @endif
                            
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $wedding->status === 'published' ? 'bg-green-100 text-green-800' : 
                                   ($wedding->status === 'preview' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600') }}">
                                {{ $wedding->status === 'published' ? 'Đã đăng' : ($wedding->status === 'preview' ? 'Xem trước' : 'Nháp') }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <a href="/w/{{ $wedding->slug }}" target="_blank"
                               class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100" title="Xem">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('dashboard.weddings.edit', $wedding) }}"
                               class="p-2 text-pink-500 hover:text-pink-700 rounded-lg hover:bg-pink-50" title="Sửa">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('dashboard.weddings.destroy', $wedding) }}" method="POST" 
                                  onsubmit="return confirm('Bạn có chắc muốn xóa thiệp này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-400 hover:text-red-600 rounded-lg hover:bg-red-50" title="Xóa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($weddings->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $weddings->links() }}
            </div>
            @endif
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Chưa có thiệp cưới nào</h3>
                <p class="mt-2 text-sm text-gray-500">Tạo thiệp cưới đầu tiên của bạn ngay!</p>
                <a href="{{ route('dashboard.weddings.create') }}" 
                   class="mt-6 inline-flex items-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white text-sm font-medium rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tạo thiệp mới
                </a>
            </div>
        @endif
    </div>
</x-dashboard-layout>
