<?php

namespace App\Filament\Resources\Weddings\Tables;

use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Models\Wedding;
use App\Services\WeddingArchiveService;
use BackedEnum;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Facades\Filament;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
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
                TextColumn::make('template.name')
                    ->label('Template')
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
                SelectFilter::make('template_id')
                    ->label('Template')
                    ->relationship('template', 'name'),
            ])
            ->actions([
                Action::make('export_archive')
                    ->label('Xuất ZIP')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(function (Wedding $record) {
                        $archive = app(WeddingArchiveService::class)->export($record);

                        return response()
                            ->download($archive['path'], $archive['filename'], ['Content-Type' => 'application/zip'])
                            ->deleteFileAfterSend(true);
                    }),
                Action::make('guests')
    ->label('Khách mời')
    ->icon('heroicon-o-user-group')
    ->color('success')
    ->visible(
        fn (): bool =>
            Filament::getCurrentPanel()?->getId() === 'app'
    )
    ->modalHeading(
        fn (Wedding $record): string =>
            'Khách mời · '.$record->groom_name.' & '.$record->bride_name
    )
    ->modalDescription(
        'Nhập khách mời và chọn khách thuộc nhà trai hoặc nhà gái. '
        .'Sau khi lưu, hệ thống sẽ tạo link thiệp riêng cho từng người.'
    )
    ->modalWidth('5xl')
    ->fillForm(
        fn (Wedding $record): array => [
            'guests' => $record->guestInvites(),
        ]
    )
    ->form([
        Repeater::make('guests')
            ->label('Danh sách khách mời')
            ->schema([

                TextInput::make('name')
                    ->label('Tên khách mời')
                    ->placeholder('VD: Gia đình anh Nguyễn Văn A')
                    ->required()
                    ->maxLength(255),

                Select::make('side')
                    ->label('Khách của')
                    ->options([
                        'groom' => 'Nhà trai',
                        'bride' => 'Nhà gái',
                        'both' => 'Khách chung',
                    ])
                    ->default('both')
                    ->required()
                    ->native(false)
                    ->live(),

                TextInput::make('code')
                    ->label('Mã khách')
                    ->disabled()
                    ->dehydrated(),

                Placeholder::make('invite_link')
                    ->label('Link thiệp riêng')
                    ->content(function (
                        Get $get,
                        ?Wedding $record
                    ): string {
                        if (! $record) {
                            return 'Lưu khách mời để tạo link.';
                        }

                        $code = Wedding::normalizeGuestCode(
                            $get('code')
                        );

                        if (! $code) {
                            return 'Lưu khách mời để tạo link.';
                        }

                        return $record->guestInvitationUrl(
                            $code,
                            $get('side') ?: 'both',
                        );
                    })
                    ->columnSpanFull(),
            ])
            ->columns(3)
            ->defaultItems(0)
            ->reorderable()
            ->collapsible()
            ->cloneable()
            ->addActionLabel('+ Thêm khách mời')
            ->itemLabel(
                fn (array $state): string =>
                    $state['name'] ?? 'Khách mới'
            ),
    ])
    ->action(function (
        array $data,
        Wedding $record
    ): void {
        $guests = [];

        foreach ($data['guests'] ?? [] as $guest) {
            $name = trim(
                strip_tags((string) ($guest['name'] ?? ''))
            );

            if ($name === '') {
                continue;
            }

            $code = Wedding::normalizeGuestCode(
                $guest['code'] ?? null
            );

            if (! $code) {
                $code = Wedding::nextGuestCode($guests);
            }

            $side = in_array(
                $guest['side'] ?? null,
                ['groom', 'bride', 'both'],
                true
            )
                ? $guest['side']
                : 'both';

            $guests[] = [
                'code' => $code,
                'name' => $name,
                'side' => $side,
            ];
        }

        $content = $record->content ?? [];

        $content['invited_guests'] = $guests;

        $record->update([
            'content' => $content,
        ]);

        Notification::make()
            ->title('Đã lưu khách mời')
            ->body('Hiện có '.count($guests).' khách mời.')
            ->success()
            ->send();
    }),
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
