<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeddingWishResource\Pages;
use App\Models\WeddingWish;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class WeddingWishResource extends Resource
{
    protected static ?string $model = WeddingWish::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    
    protected static ?string $navigationGroup = 'Quản lý Đám cưới';
    
    protected static ?string $navigationLabel = 'Lời chúc & Sổ lưu bút';

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
                    ->label('Người gửi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->label('Lời chúc')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_approved')
                    ->label('Đã duyệt')
                    ->default(false),
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
                    ->label('Người gửi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->label('Lời chúc')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Đã duyệt')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày gửi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('pending')
                    ->label('Chờ duyệt')
                    ->query(fn (Builder $query): Builder => $query->where('is_approved', false))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Duyệt')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(fn (WeddingWish $record) => $record->approve())
                    ->visible(fn (WeddingWish $record) => !$record->is_approved),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Duyệt đã chọn')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->approve()),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWeddingWishes::route('/'),
        ];
    }
}
