<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SharedMusicResource\Pages;
use App\Models\SharedMusic;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SharedMusicResource extends Resource
{
    protected static ?string $model = SharedMusic::class;
    protected static ?string $navigationIcon = 'heroicon-o-musical-note';
    protected static ?string $navigationLabel = 'Thư viện nhạc';
    protected static ?string $navigationGroup = 'Nội dung';
    protected static ?string $modelLabel = 'Bài hát';
    protected static ?string $pluralModelLabel = 'Thư viện nhạc';
    protected static ?int $navigationSort = 5;

    public static function shouldRegisterNavigation(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'admin';
    }

    public static function canAccess(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Thông tin bài hát')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Tên bài hát')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('artist')
                        ->label('Ca sĩ')
                        ->maxLength(255),

                    Forms\Components\Select::make('category')
                        ->label('Thể loại')
                        ->options(SharedMusic::categories())
                        ->default('romantic'),
                        // Not required – defaults to 'romantic'

                    Forms\Components\FileUpload::make('file_path')
                        ->label('File nhạc')
                        ->disk('public')
                        ->directory('shared-music')
                        ->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg'])
                        ->maxSize(15360) // 15MB
                        ->required(),

                    Forms\Components\Placeholder::make('duration_note')
                        ->label('Thời lượng')
                        ->content('Tự động đọc từ file nhạc sau khi lưu'),
                        // duration is auto-populated from audio metadata, no manual input needed

                    Forms\Components\Toggle::make('is_active')
                        ->label('Đang hoạt động')
                        ->default(true),
                ])->columns(['default' => 2]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tên bài hát')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('artist')
                    ->label('Ca sĩ')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Thể loại')
                    ->formatStateUsing(fn (string $state) => SharedMusic::categories()[$state] ?? $state)
                    ->badge(),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Thời lượng'),

                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Số lần dùng')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Trạng thái')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Thể loại')
                    ->options(SharedMusic::categories()),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Trạng thái'),
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
            'index' => Pages\ListSharedMusics::route('/'),
            'create' => Pages\CreateSharedMusic::route('/create'),
            'edit' => Pages\EditSharedMusic::route('/{record}/edit'),
        ];
    }
}
