<?php

namespace App\Filament\Resources\Weddings\Tables;

use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Models\Template;
use App\Models\Wedding;
use BackedEnum;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

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
                
                // Tier badge (PRO/STANDARD)
                TextColumn::make('tier')
                    ->label('Gói')
                    ->badge()
                    ->colors([
                        'primary' => 'standard',
                        'success' => 'pro',
                    ])
                    ->formatStateUsing(fn ($state) => $state instanceof BackedEnum ? strtoupper($state->value) : strtoupper((string) $state)),
                
                // Demo badge
                IconColumn::make('is_demo')
                    ->label('Demo')
                    ->boolean()
                    ->trueIcon('heroicon-o-beaker')
                    ->falseIcon('heroicon-o-user-group')
                    ->trueColor('warning')
                    ->falseColor('success'),
                
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
                    ->formatStateUsing(fn ($state) => match ($state instanceof BackedEnum ? $state->value : $state) {
                        'draft' => 'Nháp',
                        'preview' => 'Preview',
                        'published' => 'Đã xuất bản',
                        'archived' => 'Lưu trữ',
                        default => $state instanceof BackedEnum ? $state->label() : ($state ?? 'N/A'),
                    }),
                
                // Template
                TextColumn::make('template_view')
                    ->label('Template')
                    ->formatStateUsing(function ($state) {
                        $template = Template::where('view_path', (string) $state)->first();
                        return $template?->name ?? str_replace('templates.', '', (string) $state);
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
                // Filter: Demo vs Khách hàng
                TernaryFilter::make('is_demo')
                    ->label('Loại')
                    ->placeholder('Tất cả')
                    ->trueLabel('Demo')
                    ->falseLabel('Khách hàng'),
                
                // Filter: Tier
                SelectFilter::make('tier')
                    ->label('Gói dịch vụ')
                    ->options(WeddingTier::options()),
                
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options(WeddingStatus::options()),
                SelectFilter::make('template_view')
                    ->label('Template')
                    ->options(fn () => Template::where('is_active', true)
                        ->pluck('name', 'view_path')
                        ->toArray()),
            ])
            ->actions([
                ViewAction::make()
                    ->label('Xem')
                    ->url(fn (Wedding $record): string => url($record->slug))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye'),
                EditAction::make()
                    ->label('Sửa'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
    }
}

