<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Hệ thống';
    
    protected static ?string $navigationLabel = 'Người dùng';
    
    protected static ?int $navigationSort = 2;

    /**
     * Hide super_admin from all queries
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('email', '!=', User::SUPER_ADMIN_EMAIL);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin tài khoản')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Họ tên')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('role')
                            ->label('Vai trò')
                            ->options([
                                User::ROLE_ADMIN => '👑 Quản trị viên',
                                User::ROLE_AGENT => '🏪 Đại lý',
                                User::ROLE_CUSTOMER => '💕 Khách hàng',
                            ])
                            ->default(User::ROLE_CUSTOMER)
                            ->required(),
                        Forms\Components\Select::make('agent_id')
                            ->label('Thuộc Đại lý')
                            ->options(function () {
                                return User::where('role', User::ROLE_AGENT)->pluck('name', 'id');
                            })
                            ->searchable()
                            ->visible(fn ($get) => $get('role') === User::ROLE_CUSTOMER),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Ngày xác thực email'),
                        Forms\Components\TextInput::make('password')
                            ->label('Mật khẩu')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Họ tên')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Vai trò')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        User::ROLE_ADMIN => 'danger',
                        User::ROLE_AGENT => 'warning',
                        User::ROLE_CUSTOMER => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        User::ROLE_ADMIN => '👑 Admin',
                        User::ROLE_AGENT => '🏪 Đại lý',
                        User::ROLE_CUSTOMER => '💕 Khách hàng',
                        default => $state ?? 'Chưa xác định',
                    }),
                Tables\Columns\TextColumn::make('managingAgent.name')
                    ->label('Thuộc Đại lý')
                    ->placeholder('--')
                    ->badge()
                    ->color('info')
                    ->visible(fn () => true),
                Tables\Columns\TextColumn::make('weddings_count')
                    ->label('Số thiệp')
                    ->counts('weddings'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Vai trò')
                    ->options([
                        User::ROLE_ADMIN => 'Quản trị viên',
                        User::ROLE_AGENT => 'Đại lý',
                        User::ROLE_CUSTOMER => 'Khách hàng',
                    ]),
                Tables\Filters\SelectFilter::make('agent_id')
                    ->label('Thuộc Đại lý')
                    ->options(function () {
                        return User::where('role', User::ROLE_AGENT)->pluck('name', 'id');
                    })
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('has_agent')
                    ->label('Có đại lý quản lý')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('agent_id'),
                        false: fn ($query) => $query->whereNull('agent_id'),
                    ),
            ])
            ->actions([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}


