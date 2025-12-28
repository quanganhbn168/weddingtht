<?php

namespace App\Filament\Resources\DemoWeddings;

use App\Filament\Resources\DemoWeddings\Pages\CreateDemoWedding;
use App\Filament\Resources\DemoWeddings\Pages\EditDemoWedding;
use App\Filament\Resources\DemoWeddings\Pages\ListDemoWeddings;
use App\Models\Wedding;
use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Enums\FallingEffect;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DemoWeddingResource extends Resource
{
    protected static ?string $model = Wedding::class;

    protected static ?string $slug = 'demo-weddings';

    public static function getNavigationLabel(): string
    {
        return 'Quản lý Demo';
    }

    public static function getModelLabel(): string
    {
        return 'Demo Wedding';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Demo Weddings';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Demo';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-beaker';
    }
    
    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_demo', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', 'wedding')
            ->where('is_demo', true);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Section::make('Thông tin Demo')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('groom_name')
                            ->label('Tên chú rể')
                            ->required(),
                        
                        Forms\Components\TextInput::make('bride_name')
                            ->label('Tên cô dâu')
                            ->required(),
                        
                        Forms\Components\Select::make('template_id')
                            ->label('Template')
                            ->options(function () {
                                return \App\Models\Template::where('type', 'wedding')
                                    ->where('is_active', true)
                                    ->pluck('name', 'id');
                            })
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $template = \App\Models\Template::find($state);
                                    if ($template) {
                                        $set('template_view', $template->view_path);
                                        // Pro templates get pro tier
                                        $set('tier', $template->tier ?? 'standard');
                                    }
                                }
                            }),
                        
                        Forms\Components\TextInput::make('template_view')
                            ->hidden()
                            ->dehydrated(),
                        
                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->placeholder('demo-template-name')
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\Select::make('tier')
                            ->label('Gói dịch vụ')
                            ->options(WeddingTier::options())
                            ->default(WeddingTier::PRO->value),
                        
                        Forms\Components\Select::make('status')
                            ->label('Trạng thái')
                            ->options(WeddingStatus::options())
                            ->default(WeddingStatus::PUBLISHED->value),
                        
                        Forms\Components\Hidden::make('is_demo')
                            ->default(true),
                        
                        Forms\Components\Hidden::make('type')
                            ->default('wedding'),
                    ]),
                
                Forms\Components\Section::make('Pro Features')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Toggle::make('show_preload')
                            ->label('Bật Animation 囍')
                            ->default(true),
                        
                        Forms\Components\Select::make('falling_effect')
                            ->label('Hiệu ứng rơi')
                            ->options(FallingEffect::options())
                            ->default(FallingEffect::HEARTS->value),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->label('')
                    ->collection('cover')
                    ->circular()
                    ->size(45),
                
                Tables\Columns\TextColumn::make('groom_name')
                    ->label('Chú rể')
                    ->weight('bold')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('bride_name')
                    ->label('Cô dâu')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('template_view')
                    ->label('Template')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'templates.modern_01' => 'Modern',
                        'templates.elegant_02' => 'Elegant',
                        'templates.minimal_03' => 'Minimal',
                        'templates.luxury_gold' => 'Luxury Gold',
                        'templates.traditional_red' => 'Traditional',
                        'templates.cherry_blossom' => '🌸 Cherry',
                        'templates.cinematic_story' => '🎬 Cinema',
                        'templates.galaxy_dreams' => '✨ Galaxy',
                        default => $state ?? '-',
                    })
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('tier')
                    ->label('Gói')
                    ->badge()
                    ->colors([
                        'primary' => 'standard',
                        'success' => 'pro',
                    ])
                    ->formatStateUsing(fn ($state): string => strtoupper($state instanceof \App\Enums\WeddingTier ? $state->value : ($state ?? 'standard'))),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Xem')
                    ->url(fn (Wedding $record): string => url($record->slug))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye'),
                Tables\Actions\EditAction::make()
                    ->label('Sửa'),
                Tables\Actions\DeleteAction::make()
                    ->label('Xóa'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Chưa có Demo nào')
            ->emptyStateDescription('Tạo demo để showcase các templates')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tạo Demo đầu tiên'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDemoWeddings::route('/'),
            'create' => CreateDemoWedding::route('/create'),
            'edit' => EditDemoWedding::route('/{record}/edit'),
        ];
    }
}
