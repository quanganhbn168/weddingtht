<?php

namespace App\Filament\Widgets;

use App\Models\Wedding;
use App\Models\WeddingRsvp;
use App\Models\WeddingWish;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'app';
    }

    protected function getStats(): array
    {
        $user = auth()->user();
        
        $totalWeddings = Wedding::where('user_id', $user?->id)->count();
        $publishedWeddings = Wedding::where('user_id', $user?->id)
            ->where('status', 'published')
            ->count();
        $totalRsvps = WeddingRsvp::whereHas('wedding', fn ($q) => $q->where('user_id', $user?->id))
            ->count();
        $pendingWishes = WeddingWish::whereHas('wedding', fn ($q) => $q->where('user_id', $user?->id))
            ->where('is_approved', false)
            ->count();

        return [
            Stat::make('Thiệp cưới của bạn', number_format($totalWeddings))
                ->description($publishedWeddings . ' đã xuất bản')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Xác nhận tham dự', number_format($totalRsvps))
                ->description('Khách đã xác nhận')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Lời chúc chờ duyệt', number_format($pendingWishes))
                ->description('Cần duyệt')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingWishes > 0 ? 'warning' : 'success'),
        ];
    }
}
