<?php

namespace App\Filament\Resources;

use App\Enums\BusinessType;
use App\Filament\Resources\AgentResource\Pages;
use App\Filament\Resources\AgentResource\RelationManagers;
use App\Models\Agent;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AgentResource extends Resource
{
    protected static ?string $model = Agent::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    
    protected static ?string $navigationGroup = 'Hệ thống';
    
    protected static ?string $navigationLabel = 'Đại lý';
    
    protected static ?string $modelLabel = 'Đại lý';
    
    protected static ?string $pluralModelLabel = 'Đại lý';
    
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'admin';
    }

    public static function canAccess(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'admin' 
            && (auth()->user()?->isSuperAdmin() || auth()->user()?->isAdmin());
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin tài khoản')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Tài khoản User')
                            ->options(function () {
                                return User::where('role', User::ROLE_AGENT)
                                    ->orWhereDoesntHave('agentProfile')
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Họ tên')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->unique('users', 'email'),
                                Forms\Components\TextInput::make('password')
                                    ->label('Mật khẩu')
                                    ->password()
                                    ->required()
                                    ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
                            ])
                            ->createOptionUsing(function (array $data) {
                                $user = User::create([
                                    'name' => $data['name'],
                                    'email' => $data['email'],
                                    'password' => $data['password'],
                                    'role' => User::ROLE_AGENT,
                                ]);
                                return $user->id;
                            }),
                    ]),
                
                Forms\Components\Section::make('Thông tin doanh nghiệp')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('business_name')
                            ->label('Tên doanh nghiệp')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Select::make('business_type')
                            ->label('Loại hình')
                            ->options(BusinessType::options())
                            ->default(BusinessType::OTHER->value)
                            ->required(),
                        
                        Forms\Components\TextInput::make('phone')
                            ->label('Số điện thoại')
                            ->tel()
                            ->maxLength(20),
                        
                        Forms\Components\TextInput::make('tax_code')
                            ->label('Mã số thuế')
                            ->maxLength(20),
                        
                        Forms\Components\Textarea::make('address')
                            ->label('Địa chỉ')
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Gói dịch vụ & Quota')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('subscription_plan')
                            ->label('Gói dịch vụ')
                            ->options([
                                Agent::PLAN_STANDARD => 'Standard (20 thiệp)',
                                Agent::PLAN_PRO => 'Pro (Không giới hạn)',
                            ])
                            ->default(Agent::PLAN_STANDARD)
                            ->required(),
                        
                        Forms\Components\TextInput::make('quota_weddings')
                            ->label('Quota cho phép')
                            ->numeric()
                            ->default(20),
                        
                        Forms\Components\TextInput::make('quota_used')
                            ->label('Đã dùng')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                        
                        Forms\Components\DateTimePicker::make('subscription_ends_at')
                            ->label('Hết hạn gói'),
                    ]),
                
                Forms\Components\Section::make('Trạng thái')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Hoạt động')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('is_verified')
                            ->label('Đã xác minh')
                            ->default(false),
                        
                        Forms\Components\Textarea::make('notes')
                            ->label('Ghi chú nội bộ')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('business_name')
                    ->label('Doanh nghiệp')
                    ->searchable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('business_type')
                    ->label('Loại hình')
                    ->badge()
                    ->formatStateUsing(fn ($state) => BusinessType::tryFrom($state)?->label() ?? $state),
                
                Tables\Columns\TextColumn::make('subscription_plan')
                    ->label('Gói')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'standard' => 'gray',
                        'pro' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => strtoupper($state)),
                
                Tables\Columns\TextColumn::make('quota_used')
                    ->label('Quota')
                    ->formatStateUsing(fn ($state, $record) => $state . '/' . $record->quota_weddings),
                
                Tables\Columns\IconColumn::make('is_verified')
                    ->label('Xác minh')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Hoạt động')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('business_type')
                    ->label('Loại hình')
                    ->options(BusinessType::options()),
                Tables\Filters\SelectFilter::make('subscription_plan')
                    ->label('Gói dịch vụ')
                    ->options([
                        Agent::PLAN_STANDARD => 'Standard',
                        Agent::PLAN_PRO => 'Pro',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Hoạt động'),
                Tables\Filters\TernaryFilter::make('is_verified')
                    ->label('Đã xác minh'),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Xác minh')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->action(fn (Agent $record) => $record->update(['is_verified' => true]))
                    ->visible(fn (Agent $record) => !$record->is_verified)
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('upgrade_pro')
                    ->label('Nâng cấp Pro')
                    ->icon('heroicon-o-arrow-up-circle')
                    ->color('warning')
                    ->action(fn (Agent $record) => $record->upgradeToPro())
                    ->visible(fn (Agent $record) => $record->subscription_plan !== Agent::PLAN_PRO)
                    ->requiresConfirmation(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CustomersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'edit' => Pages\EditAgent::route('/{record}/edit'),
        ];
    }
}
