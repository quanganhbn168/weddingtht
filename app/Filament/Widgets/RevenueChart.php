<?php

namespace App\Filament\Widgets;

use App\Models\PaymentTransaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = '💰 Doanh thu 30 ngày qua';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(function ($daysAgo) {
            return Carbon::now()->subDays($daysAgo)->format('Y-m-d');
        });

        $revenueData = $days->map(function ($date) {
            return PaymentTransaction::where('status', 'success')
                ->whereDate('paid_at', $date)
                ->sum('amount') / 1000; // Convert to thousands VND for readability
        });

        $labels = $days->map(function ($date) {
            return Carbon::parse($date)->format('d/m');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Doanh thu (nghìn đồng)',
                    'data' => $revenueData->toArray(),
                    'fill' => true,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
