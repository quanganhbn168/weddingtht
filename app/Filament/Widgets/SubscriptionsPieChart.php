<?php

namespace App\Filament\Widgets;

use App\Models\Subscription;
use Filament\Widgets\ChartWidget;

class SubscriptionsPieChart extends ChartWidget
{
    protected static ?string $heading = '📊 Phân bố gói đăng ký';
    protected static ?int $sort = 6;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $free = Subscription::where('plan', 'free')->count();
        $pro = Subscription::where('plan', 'pro')->where('status', 'active')->count();
        $enterprise = Subscription::where('plan', 'enterprise')->where('status', 'active')->count();
        
        // If no subscriptions, count users without subscriptions as free
        if ($free + $pro + $enterprise === 0) {
            $free = \App\Models\User::count();
        }

        return [
            'datasets' => [
                [
                    'data' => [$free, $pro, $enterprise],
                    'backgroundColor' => [
                        'rgba(156, 163, 175, 0.8)', // gray - free
                        'rgba(139, 92, 246, 0.8)',  // purple - pro
                        'rgba(245, 158, 11, 0.8)',  // amber - enterprise
                    ],
                    'borderColor' => [
                        'rgb(156, 163, 175)',
                        'rgb(139, 92, 246)',
                        'rgb(245, 158, 11)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Free', 'Pro', 'Enterprise'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
