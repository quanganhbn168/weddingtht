<x-dashboard-layout>
    <x-slot:header>Khách mời RSVP: {{ $wedding->groom_name }} & {{ $wedding->bride_name }}</x-slot:header>

    <!-- Top Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <a href="{{ route('dashboard.weddings.edit', $wedding) }}" class="text-pink-600 hover:text-pink-800 text-sm font-medium">
            ← Quay lại sửa thiệp
        </a>
        <a href="{{ route('dashboard.weddings.rsvps', ['wedding' => $wedding, 'export' => 'csv']) }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Xuất Excel
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 border-b-4 border-blue-500">
            <div class="text-3xl font-bold text-gray-900">{{ $stats['total_guests'] }}</div>
            <div class="text-sm text-gray-500">Tổng khách</div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 border-b-4 border-green-500">
            <div class="text-3xl font-bold text-gray-900">{{ $stats['attending'] }}</div>
            <div class="text-sm text-gray-500">Sẽ đến</div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 border-b-4 border-yellow-500">
            <div class="text-3xl font-bold text-gray-900">{{ $stats['maybe'] }}</div>
            <div class="text-sm text-gray-500">Chưa chắc</div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 border-b-4 border-red-500">
            <div class="text-3xl font-bold text-gray-900">{{ $stats['not_attending'] }}</div>
            <div class="text-sm text-gray-500">Không đến</div>
        </div>
    </div>

    <!-- Side Stats -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
            <span class="text-gray-600 font-medium">🤵 Nhà Trai</span>
            <span class="text-2xl font-bold text-blue-600">{{ $stats['groom_side'] ?? 0 }}</span>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
            <span class="text-gray-600 font-medium">👰 Nhà Gái</span>
            <span class="text-2xl font-bold text-pink-600">{{ $stats['bride_side'] ?? 0 }}</span>
        </div>
    </div>

    <!-- RSVP Table -->
    <div class="bg-white overflow-hidden shadow-sm rounded-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ Tên</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thông tin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tham dự</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách của</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ghi chú</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày gửi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rsvps as $rsvp)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $rsvp->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $rsvp->phone ?: '---' }}</div>
                            <div class="text-xs text-gray-500">{{ $rsvp->guests }} người đi cùng</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($rsvp->attendance === 'yes')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sẽ đến</span>
                            @elseif($rsvp->attendance === 'maybe')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Chưa chắc</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Không đến</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $rsvp->side_text ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $rsvp->note }}">
                            {{ $rsvp->note ?: '---' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $rsvp->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Chưa có ai xác nhận tham dự.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($rsvps->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $rsvps->links() }}
        </div>
        @endif
    </div>
</x-dashboard-layout>
