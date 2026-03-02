<?php

namespace App\Filament\Widgets;

use App\Models\Wedding;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestWeddings extends BaseWidget
{
    protected static ?string $heading = '💒 Thiệp Cưới Mới Nhất';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Wedding::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('groom_name')
                    ->label('Chú rể')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bride_name')
                    ->label('Cô dâu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->label('Ngày cưới')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->colors([
                        'warning' => 'draft',
                        'info' => 'preview',
                        'success' => 'published',
                    ]),
            ])
            ->paginated(false);
    }
}
