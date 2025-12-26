<x-agent-layout :agent="$agent">
    <div class="p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Thiệp cưới</h1>
            <p class="text-gray-500 mt-1">Quản lý thiệp cưới của khách hàng</p>
        </div>
        
        <!-- Search & Filters -->
        <form class="flex flex-wrap gap-4 mb-6">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Tìm theo tên cô dâu/chú rể..."
                   class="flex-1 min-w-[200px] px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
            <select name="status" onchange="this.form.submit()"
                    class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                <option value="">Tất cả trạng thái</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                <option value="preview" {{ request('status') == 'preview' ? 'selected' : '' }}>Xem trước</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
            </select>
        </form>
        
        <!-- Weddings Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($weddings as $wedding)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                <!-- Cover Image -->
                <div class="aspect-video bg-gradient-to-br from-pink-100 to-rose-100 relative">
                    @if($wedding->getFirstMediaUrl('cover'))
                    <img src="{{ $wedding->getFirstMediaUrl('cover') }}" class="w-full h-full object-cover">
                    @else
                    <div class="absolute inset-0 flex items-center justify-center text-4xl">💒</div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-100 text-gray-600',
                                'preview' => 'bg-yellow-100 text-yellow-700',
                                'published' => 'bg-green-100 text-green-700',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$wedding->status] ?? 'bg-gray-100' }}">
                            {{ $wedding->getStatusLabel() }}
                        </span>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $wedding->user?->name ?? 'N/A' }}
                        </span>
                    </p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">
                            {{ $wedding->event_date?->format('d/m/Y') ?? 'Chưa đặt ngày' }}
                        </span>
                        <a href="/w/{{ $wedding->slug }}" target="_blank" 
                           class="text-sm text-indigo-600 hover:underline flex items-center gap-1">
                            Xem
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <p>Chưa có thiệp cưới nào</p>
            </div>
            @endforelse
        </div>
        
        @if($weddings->hasPages())
        <div class="mt-6">
            {{ $weddings->links() }}
        </div>
        @endif
    </div>
</x-agent-layout>
