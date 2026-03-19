<?php

namespace App\Filament\Widgets;

use App\Models\Wedding;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestWeddings extends BaseWidget
{
    protected static ?string $heading = 'Thiệp Cưới Mới Nhất';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;

    public static function canView(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'admin';
    }

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
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn ($state) => match ($state instanceof BackedEnum ? $state->value : $state) {
                        'draft' => 'warning',
                        'preview' => 'info',
                        'published' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state instanceof BackedEnum ? $state->value : $state) {
                        'draft' => 'Nháp',
                        'preview' => 'Preview',
                        'published' => 'Đã xuất bản',
                        default => $state instanceof BackedEnum ? $state->value : ($state ?? 'N/A'),
                    }),
            ])
            ->paginated(false);
    }
}
