<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bảng giá & Nâng cấp') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
            @endif
            
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Chọn gói phù hợp với bạn</h1>
                <p class="text-gray-600 text-lg">Nâng cấp để mở khóa tất cả tính năng premium</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Free Plan -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border-2 {{ $currentPlan === 'free' ? 'border-green-500' : 'border-gray-200' }}">
                    @if($currentPlan === 'free')
                    <div class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full inline-block mb-4">Gói hiện tại</div>
                    @endif
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Free</h3>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-900">0đ</span>
                        <span class="text-gray-500">/mãi mãi</span>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            1 Thiệp Cưới
                        </li>
                        <li class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            1 Name Card
                        </li>
                        <li class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Templates cơ bản
                        </li>
                        <li class="flex items-center gap-2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span class="line-through">Premium templates</span>
                        </li>
                        <li class="flex items-center gap-2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span class="line-through">Thống kê chi tiết</span>
                        </li>
                    </ul>
                    
                    @if($currentPlan === 'free')
                    <button disabled class="w-full py-3 bg-gray-100 text-gray-500 rounded-lg font-medium cursor-default">
                        Gói hiện tại
                    </button>
                    @endif
                </div>
                
                <!-- Pro Plan -->
                <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-8 text-white transform scale-105 relative">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1 rounded-full">
                        Phổ biến nhất
                    </div>
                    @if($currentPlan === 'pro')
                    <div class="bg-white text-indigo-600 text-xs font-bold px-3 py-1 rounded-full inline-block mb-4">Gói hiện tại</div>
                    @endif
                    <h3 class="text-2xl font-bold mb-2">Pro</h3>
                    <div class="mb-6">
                        <span class="text-4xl font-bold">199.000đ</span>
                        <span class="text-indigo-200">/tháng</span>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            10 Thiệp Cưới
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            10 Name Card
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Tất cả Premium templates
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Custom domain
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Thống kê chi tiết
                        </li>
                    </ul>
                    
                    @if($currentPlan !== 'pro')
                    <form action="{{ route('payment.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="pro">
                        <button type="submit" class="w-full py-3 bg-white text-indigo-600 rounded-lg font-bold hover:bg-indigo-50 transition flex items-center justify-center gap-2">
                            <img src="https://developers.momo.vn/v3/vi/assets/images/icon-52bd5808cecdb1970e1aeec3c31a3ee1.png" alt="MoMo" class="w-6 h-6">
                            Thanh toán MoMo
                        </button>
                    </form>
                    @else
                    <button disabled class="w-full py-3 bg-white/20 text-white rounded-lg font-medium cursor-default">
                        Gói hiện tại
                    </button>
                    @endif
                </div>
                
                <!-- Enterprise Plan -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border-2 {{ $currentPlan === 'enterprise' ? 'border-green-500' : 'border-gray-200' }}">
                    @if($currentPlan === 'enterprise')
                    <div class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full inline-block mb-4">Gói hiện tại</div>
                    @endif
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-900">Liên hệ</span>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Không giới hạn Thiệp Cưới
                        </li>
                        <li class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Không giới hạn Name Card
                        </li>
                        <li class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            White-label solution
                        </li>
                        <li class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            API Access
                        </li>
                        <li class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Hỗ trợ ưu tiên 24/7
                        </li>
                    </ul>
                    
                    <a href="mailto:contact@thtmedia.com.vn" class="block w-full py-3 bg-gray-100 text-gray-700 rounded-lg font-medium text-center hover:bg-gray-200 transition">
                        Liên hệ tư vấn
                    </a>
                </div>
            </div>
            
            <div class="mt-12 text-center text-gray-500 text-sm">
                <p>Có câu hỏi? Liên hệ <a href="mailto:support@thtmedia.com.vn" class="text-indigo-600 hover:underline">support@thtmedia.com.vn</a></p>
            </div>
        </div>
    </div>
</x-app-layout>
