<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeddingRsvpResource\Pages;
use App\Models\WeddingRsvp;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class WeddingRsvpResource extends Resource
{
    protected static ?string $model = WeddingRsvp::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationGroup = 'Quản lý Đám cưới';
    
    protected static ?string $navigationLabel = 'Khách mời RSVP';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('wedding_id')
                    ->relationship('wedding', 'slug')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->groom_name . ' & ' . $record->bride_name)
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->label('Tên khách')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('Số điện thoại')
                    ->tel()
                    ->maxLength(20),
                Forms\Components\Select::make('attendance')
                    ->label('Tham dự')
                    ->options([
                        'yes' => 'Sẽ tham dự',
                        'no' => 'Không thể đến',
                        'maybe' => 'Chưa chắc chắn',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('guests')
                    ->label('Số lượng')
                    ->numeric()
                    ->default(1)
                    ->required(),
                Forms\Components\Select::make('side')
                    ->label('Khách của')
                    ->options([
                        'groom' => 'Nhà trai',
                        'bride' => 'Nhà gái',
                        'both' => 'Cả hai',
                    ])
                    ->default('both'),
                Forms\Components\Textarea::make('note')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('wedding.groom_name')
                    ->label('Đám cưới')
                    ->description(fn ($record) => 'Dâu: ' . $record->wedding->bride_name)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên khách')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('SĐT')
                    ->searchable(),
                Tables\Columns\TextColumn::make('attendance')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'yes' => 'success',
                        'no' => 'danger',
                        'maybe' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'yes' => 'Sẽ đến',
                        'no' => 'Không đến',
                        'maybe' => 'Chưa chắc',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('guests')
                    ->label('Số lượng')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('side')
                    ->label('Phía')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'groom' => 'Nhà trai',
                        'bride' => 'Nhà gái',
                        'both' => 'Cả hai',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày gửi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('attendance')
                    ->label('Trạng thái')
                    ->options([
                        'yes' => 'Sẽ tham dự',
                        'no' => 'Không thể đến',
                        'maybe' => 'Chưa chắc chắn',
                    ]),
                SelectFilter::make('side')
                    ->label('Phía')
                    ->options([
                        'groom' => 'Nhà trai',
                        'bride' => 'Nhà gái',
                        'both' => 'Cả hai',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWeddingRsvps::route('/'),
        ];
    }
}
