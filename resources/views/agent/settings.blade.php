<x-agent-layout :agent="$agent">
    <div class="p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Cài đặt</h1>
            <p class="text-gray-500 mt-1">Thông tin đại lý và cài đặt tài khoản</p>
        </div>
        
        <div class="max-w-2xl">
            <!-- Business Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Thông tin doanh nghiệp</h2>
                
                <form action="{{ route('agent.settings.update') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên doanh nghiệp</label>
                        <input type="text" name="business_name" value="{{ $agent->business_name }}" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Loại hình</label>
                        <input type="text" value="{{ $agent->getBusinessTypeLabel() }}" disabled
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                        <input type="tel" name="phone" value="{{ $agent->phone }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                        <textarea name="address" rows="2"
                                  class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 resize-none">{{ $agent->address }}</textarea>
                    </div>
                    
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
                        Lưu thay đổi
                    </button>
                </form>
            </div>
            
            <!-- Subscription Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Gói đăng ký</h2>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-500">Gói hiện tại</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $agent->getSubscriptionPlanLabel() }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-500">Trạng thái</p>
                        <p class="text-lg font-semibold {{ $agent->isSubscriptionActive() ? 'text-green-600' : 'text-red-600' }}">
                            {{ $agent->isSubscriptionActive() ? 'Hoạt động' : 'Hết hạn' }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-500">Quota đã dùng</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $agent->quota_used }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm text-gray-500">Quota còn lại</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $agent->getRemainingQuota() }}</p>
                    </div>
                </div>
                
                @if($agent->isOnTrial())
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-yellow-800">
                    <p class="font-medium">⏳ Đang trong thời gian dùng thử</p>
                    <p class="text-sm">Hết hạn: {{ $agent->trial_ends_at?->format('d/m/Y H:i') ?? 'N/A' }}</p>
                </div>
                @endif
                
                @if($agent->subscription_ends_at && !$agent->isOnTrial())
                <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-xl text-indigo-800">
                    <p class="font-medium">📅 Ngày hết hạn</p>
                    <p class="text-sm">{{ $agent->subscription_ends_at->format('d/m/Y H:i') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-agent-layout>
