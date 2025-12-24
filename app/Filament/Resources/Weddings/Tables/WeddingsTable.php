<?php

namespace App\Filament\Resources\Weddings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Models\Wedding;

class WeddingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Ảnh bìa nhỏ gọn
                SpatieMediaLibraryImageColumn::make('cover')
                    ->label('')
                    ->collection('cover')
                    ->circular()
                    ->size(45),
                
                // Tên cô dâu chú rể
                TextColumn::make('groom_name')
                    ->label('Chú rể')
                    ->weight('bold')
                    ->searchable(),
                
                TextColumn::make('bride_name')
                    ->label('Cô dâu')
                    ->searchable(),
                
                // Ngày cưới + âm lịch
                TextColumn::make('event_date')
                    ->label('Ngày cưới')
                    ->date('d/m/Y')
                    ->description(fn (Wedding $record) => $record->event_date_lunar)
                    ->sortable(),
                
                // Status badge
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'preview',
                        'success' => 'published',
                        'danger' => 'archived',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Nháp',
                        'preview' => 'Preview',
                        'published' => 'Đã xuất bản',
                        'archived' => 'Lưu trữ',
                        default => $state,
                    }),
                
                // Template
                TextColumn::make('template_view')
                    ->label('Template')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'templates.modern_01' => 'Modern',
                        'templates.elegant_02' => 'Elegant',
                        'templates.minimal_03' => 'Minimal',
                        default => $state,
                    })
                    ->badge()
                    ->color('info'),
                
                // Ngày tạo
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'draft' => 'Bản nháp',
                        'preview' => 'Xem trước',
                        'published' => 'Đã xuất bản',
                        'archived' => 'Đã lưu trữ',
                    ]),
                SelectFilter::make('template_view')
                    ->label('Template')
                    ->options([
                        'templates.modern_01' => 'Modern',
                        'templates.elegant_02' => 'Elegant',
                        'templates.minimal_03' => 'Minimal',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Xem')
                    ->url(fn (Wedding $record): string => url($record->slug))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye'),
                EditAction::make()
                    ->label('Sửa'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
    }
}
