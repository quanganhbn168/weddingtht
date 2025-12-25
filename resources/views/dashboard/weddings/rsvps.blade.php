<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quản lý Khách mời RSVP') }} - {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('dashboard.weddings.rsvps', ['wedding' => $wedding, 'export' => 'csv']) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Xuất Excel
                </a>
                <a href="{{ route('dashboard.weddings.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Quay lại
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                {{-- Total Guests --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-b-4 border-blue-500">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Tổng khách mời</h3>
                        <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['total_guests'] }}</div>
                    <div class="mt-2 text-xs text-gray-500">Người xác nhận tham dự</div>
                </div>

                {{-- Attending --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-b-4 border-green-500">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Sẽ tham dự</h3>
                        <div class="p-2 bg-green-50 rounded-lg text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['attending'] }}</div>
                    <div class="mt-2 text-xs text-gray-500">Số lượng: {{ $stats['attending'] }} xác nhận</div>
                </div>

                {{-- Maybe --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-b-4 border-yellow-500">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Chưa chắc chắn</h3>
                        <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['maybe'] }}</div>
                    <div class="mt-2 text-xs text-gray-500">Cần liên hệ lại</div>
                </div>

                {{-- Not Attending --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-b-4 border-red-500">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Không thể đến</h3>
                        <div class="p-2 bg-red-50 rounded-lg text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['not_attending'] }}</div>
                    <div class="mt-2 text-xs text-gray-500">Rất tiếc vắng mặt</div>
                </div>
            </div>
            
            {{-- Side Stats --}}
            <div class="grid grid-cols-2 gap-4 mb-8">
                 <div class="bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
                     <span class="text-gray-600 font-medium">Khách Nhà Trai</span>
                     <span class="text-2xl font-bold text-blue-600">{{ $stats['groom_side'] }} <span class="text-sm text-gray-400 font-normal">người</span></span>
                 </div>
                 <div class="bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
                     <span class="text-gray-600 font-medium">Khách Nhà Gái</span>
                     <span class="text-2xl font-bold text-pink-600">{{ $stats['bride_side'] }} <span class="text-sm text-gray-400 font-normal">người</span></span>
                 </div>
            </div>

            {{-- RSVP List --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">Danh sách phản hồi ({{ $rsvps->total() }})</h3>
                </div>
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
                                    {{ $rsvp->side_text }}
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
        </div>
    </div>
</x-app-layout>
