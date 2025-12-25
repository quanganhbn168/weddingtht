<?php

namespace App\Filament\Widgets;

use App\Models\Wedding;
use App\Models\BusinessCard;
use App\Models\User;
use App\Models\Subscription;
use App\Models\PaymentTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $totalWeddings = Wedding::count();
        $totalCards = BusinessCard::count();
        $totalUsers = User::count();
        $proUsers = Subscription::where('plan', 'pro')->where('status', 'active')->count();
        
        // Revenue this month
        $monthlyRevenue = PaymentTransaction::where('status', 'success')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');
        
        // Growth calculations
        $lastMonthWeddings = Wedding::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $weddingGrowth = $lastMonthWeddings > 0 
            ? round((($totalWeddings - $lastMonthWeddings) / $lastMonthWeddings) * 100, 1)
            : 100;
            
        return [
            Stat::make('👥 Tổng Users', number_format($totalUsers))
                ->description($proUsers . ' Pro users')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
                
            Stat::make('💒 Thiệp Cưới', number_format($totalWeddings))
                ->description(($weddingGrowth >= 0 ? '+' : '') . $weddingGrowth . '% so với tháng trước')
                ->descriptionIcon($weddingGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($weddingGrowth >= 0 ? 'success' : 'danger'),
                
            Stat::make('🪪 Name Cards', number_format($totalCards))
                ->description('Danh thiếp điện tử')
                ->descriptionIcon('heroicon-m-identification')
                ->color('info'),
                
            Stat::make('💰 Doanh thu tháng', number_format($monthlyRevenue) . 'đ')
                ->description('Tháng ' . now()->format('m/Y'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
