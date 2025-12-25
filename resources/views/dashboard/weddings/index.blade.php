<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Thiệp Cưới của tôi') }}
            </h2>
            <a href="{{ route('dashboard.weddings.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tạo mới
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
            @endif

            @if($weddings->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="divide-y divide-gray-200">
                    @foreach($weddings as $wedding)
                    <div class="p-6 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-pink-100 rounded-xl flex items-center justify-center text-2xl">
                                💕
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ $wedding->event_date?->format('d/m/Y') ?? 'Chưa có ngày' }}
                                    • {{ $wedding->template?->name ?? 'Chưa chọn mẫu' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $wedding->status === 'published' ? 'bg-green-100 text-green-800' : ($wedding->status === 'preview' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $wedding->status === 'published' ? 'Đã đăng' : ($wedding->status === 'preview' ? 'Xem trước' : 'Nháp') }}
                            </span>
                            <a href="/w/{{ $wedding->slug }}" target="_blank" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm">Xem</a>
                            <a href="{{ route('dashboard.weddings.rsvps', $wedding) }}" class="text-blue-600 hover:text-blue-800 px-3 py-2 text-sm font-medium">Khách mời</a>
                            <a href="{{ route('dashboard.weddings.edit', $wedding) }}" class="text-indigo-600 hover:text-indigo-800 px-3 py-2 text-sm font-medium">Sửa</a>
                            <form method="POST" action="{{ route('dashboard.weddings.destroy', $wedding) }}" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa thiệp này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 px-3 py-2 text-sm">Xóa</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="mt-6">
                {{ $weddings->links() }}
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-12 text-center">
                <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                    💒
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có thiệp cưới nào</h3>
                <p class="text-gray-500 mb-6">Bắt đầu tạo thiệp cưới online đầu tiên của bạn!</p>
                <a href="{{ route('dashboard.weddings.create') }}" class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tạo thiệp cưới đầu tiên
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
