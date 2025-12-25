<?php

namespace App\Filament\Widgets;

use App\Models\Wedding;
use App\Models\BusinessCard;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CreationsChart extends ChartWidget
{
    protected static ?string $heading = '📈 Thiệp & Name Card mới (7 ngày qua)';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $days = collect(range(6, 0))->map(function ($daysAgo) {
            return Carbon::now()->subDays($daysAgo)->format('Y-m-d');
        });

        $weddingData = $days->map(function ($date) {
            return Wedding::whereDate('created_at', $date)->count();
        });

        $cardData = $days->map(function ($date) {
            return BusinessCard::whereDate('created_at', $date)->count();
        });

        $labels = $days->map(function ($date) {
            return Carbon::parse($date)->format('d/m');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Thiệp Cưới',
                    'data' => $weddingData->toArray(),
                    'backgroundColor' => 'rgba(236, 72, 153, 0.5)',
                    'borderColor' => 'rgb(236, 72, 153)',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Name Card',
                    'data' => $cardData->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
