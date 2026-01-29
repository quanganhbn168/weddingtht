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

    protected static ?string $slug = 'weddings';

    public static function getNavigationLabel(): string
    {
        $panelId = \Filament\Facades\Filament::getCurrentPanel()?->getId();
        
        if ($panelId === 'app') {
            return 'Thiệp của tôi';
        }

        return 'Khách Hàng';
    }

    public static function getModelLabel(): string
    {
        $panelId = \Filament\Facades\Filament::getCurrentPanel()?->getId();
        
        if ($panelId === 'app') {
            return 'Thiệp';
        }

        return 'Khách Hàng';
    }

    public static function getPluralModelLabel(): string
    {
        $panelId = \Filament\Facades\Filament::getCurrentPanel()?->getId();
        
        if ($panelId === 'app') {
            return 'Thiệp của tôi';
        }

        return 'Khách Hàng';
    }

    public static function getNavigationGroup(): ?string
    {
        $panelId = \Filament\Facades\Filament::getCurrentPanel()?->getId();
        
        if ($panelId === 'app') {
            return null;
        }

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
        $user = auth()->user();
        $panelId = \Filament\Facades\Filament::getCurrentPanel()?->getId();

        $query = parent::getEloquentQuery()
            ->where('is_demo', false);

        if ($panelId === 'admin') {
            return $query->where('type', 'wedding');
        }

        if ($panelId === 'agent') {
            // Agent only sees weddings of their customers
            return $query->whereHas('user', function ($q) use ($user) {
                $q->where('agent_id', $user->id);
            });
        }

        if ($panelId === 'app') {
            // Customer only sees their own weddings
            return $query->where('user_id', $user->id);
        }

        return $query;
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
