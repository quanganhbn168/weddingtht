<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DemoContentResource\Pages;
use App\Filament\Resources\DemoContentResource\RelationManagers;
use App\Models\DemoContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DemoContentResource extends Resource
{
    protected static ?string $model = DemoContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Global Demo Assets')
                    ->description('Upload assets here to be used across all Demo Weddings')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên Chia Sẻ')
                            ->default('Global Demo Content')
                            ->required(),
                            
                        Forms\Components\TextInput::make('background_music')
                            ->label('Link Nhạc Nền (URL)')
                            ->placeholder('https://...')
                            ->helperText('Paste link MP3 hoặc để trống nếu muốn upload file nhạc ở từng Demo riêng'),
                            
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                                ->label('Ảnh Bìa (Cover/Thumbnail)')
                                ->collection('cover')
                                ->image(),
                            Forms\Components\SpatieMediaLibraryFileUpload::make('hero')
                                ->label('Ảnh Hero (Banner dọc)')
                                ->collection('hero')
                                ->image(),
                                
                            Forms\Components\SpatieMediaLibraryFileUpload::make('groom_photo')
                                ->label('Ảnh Chú Rể')
                                ->collection('groom_photo')
                                ->image(),
                            Forms\Components\SpatieMediaLibraryFileUpload::make('bride_photo')
                                ->label('Ảnh Cô Dâu')
                                ->collection('bride_photo')
                                ->image(),
                                
                            Forms\Components\SpatieMediaLibraryFileUpload::make('groom_qr')
                                ->label('QR Chú Rể')
                                ->collection('groom_qr')
                                ->image(),
                            Forms\Components\SpatieMediaLibraryFileUpload::make('bride_qr')
                                ->label('QR Cô Dâu')
                                ->collection('bride_qr')
                                ->image(),
                        ]),

                        Forms\Components\SpatieMediaLibraryFileUpload::make('demo_gallery')
                            ->label('Album Ảnh Demo Chung')
                            ->collection('demo_gallery')
                            ->multiple()
                            ->reorderable()
                            ->columnSpanFull(),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->label('Kích hoạt')
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Tên'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Ngày tạo'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDemoContents::route('/'),
            'create' => Pages\CreateDemoContent::route('/create'),
            'edit' => Pages\EditDemoContent::route('/{record}/edit'),
        ];
    }
}
