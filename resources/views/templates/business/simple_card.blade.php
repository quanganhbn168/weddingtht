@extends('layouts.app')
{{--
Template Name: Simple Card (Cơ bản)
Type: business
--}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $card->name }} - Business Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@extends('layouts.business')

@section('title', $card->name)

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');
    body { font-family: 'Open Sans', sans-serif; background-color: #f3f4f6; }
</style>
@endpush

@section('content')
    <div class="min-h-screen flex justify-center py-10 px-4 bg-gray-100">
        <div class="max-w-md w-full bg-white rounded-xl shadow-md overflow-hidden p-6 text-center border border-gray-200">
            <!-- Avatar -->
            <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-gray-100 mb-4">
                @if($card->hasMedia('avatar'))
                    <img src="{{ $card->getFirstMediaUrl('avatar') }}" class="w-full h-full object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($card->name) }}&background=ddd&color=333" class="w-full h-full object-cover">
                @endif
            </div>

            <h1 class="text-2xl font-bold text-gray-800">{{ $card->name }}</h1>
            <p class="text-gray-500 font-medium mb-1">{{ $card->title }}</p>
            <p class="text-gray-400 text-sm uppercase tracking-wide mb-6">{{ $card->company }}</p>

            <!-- Actions -->
            <div class="grid grid-cols-2 gap-3 mb-8">
                @if($card->phone)
                <a href="tel:{{ $card->phone }}" class="flex items-center justify-center gap-2 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    <i class="fas fa-phone"></i> Gọi điện
                </a>
                @endif
                @if($card->email)
                <a href="mailto:{{ $card->email }}" class="flex items-center justify-center gap-2 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-envelope"></i> Email
                </a>
                @endif
            </div>

            <!-- About -->
            @if($card->about)
            <div class="text-gray-600 text-sm leading-relaxed mb-6 text-left bg-gray-50 p-4 rounded-lg">
                {!! $card->about !!}
            </div>
            @endif

            <!-- Services List -->
            @if(count($services) > 0)
            <div class="text-left mb-6">
                <h3 class="font-bold text-gray-700 mb-3 border-b pb-1">Dịch vụ</h3>
                <ul class="space-y-2">
                    @foreach($services as $svc)
                    <li class="flex items-start gap-3">
                        <i class="{{ $svc['icon'] ?? 'fas fa-check' }} text-blue-500 mt-1"></i>
                        <span class="text-sm text-gray-600">{{ $svc['title'] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Stats -->
            @if(!empty($stats))
            <div class="grid grid-cols-3 gap-2 mb-6 border-t pt-4">
                @foreach(array_slice($stats, 0, 3) as $stat)
                <div>
                    <div class="font-bold text-blue-600 text-lg">{{ $stat['number'] }}</div>
                    <div class="text-[10px] text-gray-400 uppercase">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Social -->
            <div class="flex justify-center gap-4 mt-4">
                @foreach($card->social_links ?? [] as $link)
                <a href="{{ $link['url'] }}" target="_blank" class="text-gray-400 hover:text-blue-600 text-xl transition">
                    <i class="{{ match($link['platform']) { 'facebook' => 'fab fa-facebook-f', 'zalo' => 'fas fa-comment-dots', default => 'fas fa-link' } }}"></i>
                </a>
                @endforeach
            </div>

             <div class="mt-8 text-xs text-gray-400">
                Created with Simple Card
            </div>
        </div>
    </div>
</body>
</html>
