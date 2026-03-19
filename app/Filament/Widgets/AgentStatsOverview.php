<?php

namespace App\Filament\Widgets;

use App\Models\Wedding;
use App\Models\WeddingRsvp;
use App\Models\WeddingWish;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AgentStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'agent';
    }

    protected function getStats(): array
    {
        $user = auth()->user();
        $agent = $user?->agent;

        if (! $agent) {
            return [
                Stat::make('Trạng thái', 'Chưa đăng ký đại lý')
                    ->description('Liên hệ admin để đăng ký')
                    ->color('warning'),
            ];
        }

        $totalWeddings = Wedding::where('agent_id', $agent->id)->count();
        $publishedWeddings = Wedding::where('agent_id', $agent->id)
            ->where('status', 'published')
            ->count();
        $totalRsvps = WeddingRsvp::whereHas('wedding', fn ($q) => $q->where('agent_id', $agent->id))
            ->count();
        $totalWishes = WeddingWish::whereHas('wedding', fn ($q) => $q->where('agent_id', $agent->id))
            ->count();

        return [
            Stat::make('Tổng thiệp cưới', number_format($totalWeddings))
                ->description($publishedWeddings . ' đã xuất bản')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('RSVP nhận được', number_format($totalRsvps))
                ->description('Tổng số xác nhận')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('info'),

            Stat::make('Lời chúc', number_format($totalWishes))
                ->description('Tổng lời chúc nhận được')
                ->descriptionIcon('heroicon-m-heart')
                ->color('primary'),
        ];
    }
}
