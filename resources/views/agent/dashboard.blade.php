<x-agent-layout :agent="$agent">
    <div class="p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-500 mt-1">Xin chào, {{ $agent->business_name }}</p>
        </div>
        
        <!-- Subscription Info -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 text-white mb-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold">{{ $stats['subscription_plan'] }}</h2>
                    @if($stats['is_trial'])
                    <p class="text-indigo-100 text-sm">
                        Dùng thử - Hết hạn: {{ $stats['trial_ends_at']?->format('d/m/Y') ?? 'N/A' }}
                    </p>
                    @elseif($stats['subscription_ends_at'])
                    <p class="text-indigo-100 text-sm">
                        Hết hạn: {{ $stats['subscription_ends_at']->format('d/m/Y') }}
                    </p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold">{{ $stats['quota_used'] }} / {{ is_numeric($stats['quota_remaining']) ? ($stats['quota_used'] + $stats['quota_remaining']) : '∞' }}</p>
                    <p class="text-indigo-100 text-sm">Thiệp đã tạo</p>
                </div>
            </div>
        </div>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_customers'] }}</p>
                        <p class="text-gray-500 text-sm">Khách hàng</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_weddings'] }}</p>
                        <p class="text-gray-500 text-sm">Thiệp cưới</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ is_numeric($stats['quota_remaining']) ? $stats['quota_remaining'] : '∞' }}</p>
                        <p class="text-gray-500 text-sm">Quota còn lại</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Items -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Customers -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Khách hàng gần đây</h3>
                    <a href="{{ route('agent.customers') }}" class="text-sm text-indigo-600 hover:underline">Xem tất cả →</a>
                </div>
                @forelse($recentCustomers as $customer)
                <div class="flex items-center gap-3 py-3 border-b border-gray-50 last:border-0">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 font-medium">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 truncate">{{ $customer->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $customer->email }}</p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Chưa có khách hàng</p>
                @endforelse
            </div>
            
            <!-- Recent Weddings -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Thiệp cưới gần đây</h3>
                    <a href="{{ route('agent.weddings') }}" class="text-sm text-indigo-600 hover:underline">Xem tất cả →</a>
                </div>
                @forelse($recentWeddings as $wedding)
                <div class="flex items-center gap-3 py-3 border-b border-gray-50 last:border-0">
                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                        💒
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 truncate">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</p>
                        <p class="text-sm text-gray-500">{{ $wedding->user?->name ?? 'N/A' }}</p>
                    </div>
                    <a href="/w/{{ $wedding->slug }}" target="_blank" class="text-indigo-600 hover:underline text-sm">Xem</a>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Chưa có thiệp cưới</p>
                @endforelse
            </div>
        </div>
    </div>
</x-agent-layout>
