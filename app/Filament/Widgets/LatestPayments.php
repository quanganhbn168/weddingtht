<?php

namespace App\Filament\Widgets;

use App\Models\PaymentTransaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPayments extends BaseWidget
{
    protected static ?string $heading = '💳 Thanh Toán Gần Đây';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PaymentTransaction::query()->with('user')->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Khách hàng')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Số tiền')
                    ->formatStateUsing(fn ($state) => number_format($state) . 'đ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('gateway')
                    ->label('Cổng TT')
                    ->badge()
                    ->color('info'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'success',
                        'danger' => 'failed',
                        'gray' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Thời gian')
                    ->dateTime('d/m H:i')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
