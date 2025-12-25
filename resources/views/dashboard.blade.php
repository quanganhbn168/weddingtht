<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Subscription Banner -->
            @if($subscription->plan === 'free')
            <div class="mb-6 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold">🚀 Nâng cấp lên Pro</h3>
                        <p class="text-purple-100 text-sm">Tạo không giới hạn thiệp cưới & name card, truy cập tất cả templates!</p>
                    </div>
                    <a href="{{ route('dashboard.pricing') }}" class="bg-white text-purple-600 px-6 py-2 rounded-lg font-semibold hover:bg-purple-50 transition">
                        Xem gói Pro
                    </a>
                </div>
            </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Weddings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Thiệp Cưới</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $weddings->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">
                                Còn lại: {{ Auth::user()->getRemainingWeddings() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Business Cards -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Name Card</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $businessCards->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">
                                Còn lại: {{ Auth::user()->getRemainingBusinessCards() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Plan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Gói hiện tại</p>
                            <p class="text-3xl font-bold text-gray-900 capitalize">{{ $subscription->plan }}</p>
                            @if($subscription->expires_at)
                            <p class="text-xs text-gray-400 mt-1">
                                Hết hạn: {{ $subscription->expires_at->format('d/m/Y') }}
                            </p>
                            @endif
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <a href="{{ route('dashboard.weddings.create') }}" class="bg-white hover:bg-gray-50 overflow-hidden shadow-sm sm:rounded-xl p-6 flex items-center gap-4 transition border-2 border-transparent hover:border-pink-400">
                    <div class="w-16 h-16 bg-pink-500 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Tạo Thiệp Cưới</h3>
                        <p class="text-gray-500 text-sm">Thiết kế thiệp cưới online cho bạn</p>
                    </div>
                </a>
                
                <a href="{{ route('dashboard.cards.create') }}" class="bg-white hover:bg-gray-50 overflow-hidden shadow-sm sm:rounded-xl p-6 flex items-center gap-4 transition border-2 border-transparent hover:border-blue-400">
                    <div class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Tạo Name Card</h3>
                        <p class="text-gray-500 text-sm">Thiết kế danh thiếp điện tử của bạn</p>
                    </div>
                </a>
            </div>

            <!-- Recent Weddings -->
            @if($weddings->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Thiệp Cưới của bạn</h3>
                    <a href="{{ route('dashboard.weddings.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Xem tất cả →</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($weddings->take(3) as $wedding)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                                💕
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</p>
                                <p class="text-sm text-gray-500">{{ $wedding->event_date?->format('d/m/Y') ?? 'Chưa có ngày' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-1 text-xs rounded-full {{ $wedding->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $wedding->status === 'published' ? 'Đã đăng' : 'Nháp' }}
                            </span>
                            <a href="{{ route('dashboard.weddings.edit', $wedding) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Sửa</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recent Cards -->
            @if($businessCards->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Name Card của bạn</h3>
                    <a href="{{ route('dashboard.cards.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Xem tất cả →</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($businessCards->take(3) as $card)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                💼
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $card->name }}</p>
                                <p class="text-sm text-gray-500">{{ $card->title }} @ {{ $card->company }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="/p/{{ $card->slug }}" target="_blank" class="text-gray-500 hover:text-gray-700 text-sm">Xem</a>
                            <a href="{{ route('dashboard.cards.edit', $card) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Sửa</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
