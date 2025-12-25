<?php

namespace App\Filament\Resources\Weddings;

use App\Filament\Resources\Weddings\Pages\CreateWedding;
use App\Filament\Resources\Weddings\Pages\EditWedding;
use App\Filament\Resources\Weddings\Pages\ListWeddings;
use App\Filament\Resources\Weddings\Schemas\WeddingForm;
use App\Filament\Resources\Weddings\Tables\WeddingsTable;
use App\Models\Wedding;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WeddingResource extends Resource
{
    protected static ?string $model = Wedding::class;

    public static function getNavigationLabel(): string
    {
        return 'Đám Cưới';
    }

    public static function getModelLabel(): string
    {
        return 'Đám Cưới';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Quản lý';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-heart';
    }
    
    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'wedding');
    }

    protected static ?string $recordTitleAttribute = 'groom_name';

    public static function form(Form $form): Form
    {
        return WeddingForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return WeddingsTable::configure($table);
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
            'index' => ListWeddings::route('/'),
            'create' => CreateWedding::route('/create'),
            'edit' => EditWedding::route('/{record}/edit'),
        ];
    }
}
