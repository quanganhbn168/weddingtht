<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateResource\Pages;
use App\Models\Template;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-rectangle-stack';
    }

    public static function getNavigationLabel(): string
    {
        return 'Kho Giao diện';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Cài đặt';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return \Filament\Facades\Filament::getCurrentPanel()->getId() === 'admin';
    }

    public static function canAccess(): bool
    {
        return \Filament\Facades\Filament::getCurrentPanel()->getId() === 'admin' 
            && (auth()->user()->isSuperAdmin() || auth()->user()->isAdmin());
    }

    // Query filter removed to allow showing all template types

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên mẫu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('view_path')
                    ->label('Đường dẫn file (View Path)')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Ví dụ: templates.modern_01'),
                Forms\Components\Select::make('type')
                    ->label('Loại')
                    ->options([
                        'wedding' => 'Wedding',
                    ])
                    ->default('wedding')
                    ->required(),
                Forms\Components\FileUpload::make('thumbnail_url')
                    ->label('Ảnh đại diện')
                    ->image()
                    ->disk('public')
                    ->directory('templates'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Kích hoạt')
                    ->required(),

                Forms\Components\Section::make('Schema dữ liệu riêng')
                    ->description('Chỉ khai báo nội dung riêng của mẫu này. Không thêm tên đôi, gia đình, lịch tiệc/lễ, Album tình yêu, RSVP, QR, khách mời riêng hay Thank You vì chúng là dữ liệu dùng chung.')
                    ->schema([
                        Forms\Components\Repeater::make('content_schema')
                            ->label('Các trường nhập riêng')
                            ->schema([
                                Forms\Components\TextInput::make('section')
                                    ->label('Nhóm hiển thị trong form thiệp')
                                    ->maxLength(100)
                                    ->placeholder('Ví dụ: Câu chuyện'),
                                Forms\Components\TextInput::make('key')
                                    ->label('Mã field')
                                    ->required()
                                    ->maxLength(80)
                                    ->regex('/^[a-z][a-z0-9_]*$/')
                                    ->helperText('Chỉ dùng chữ thường, số và dấu gạch dưới; ví dụ: couple_quote.'),
                                Forms\Components\TextInput::make('label')
                                    ->label('Nhãn hiển thị')
                                    ->required()
                                    ->maxLength(160)
                                    ->placeholder('Ví dụ: Câu trích dẫn'),
                                Forms\Components\Select::make('type')
                                    ->label('Kiểu nhập')
                                    ->options([
                                        'text' => 'Một dòng',
                                        'textarea' => 'Nhiều dòng',
                                        'select' => 'Danh sách chọn',
                                        'toggle' => 'Bật / tắt',
                                        'number' => 'Số',
                                        'url' => 'Đường dẫn',
                                        'date' => 'Ngày',
                                        'image' => 'Một ảnh',
                                        'images' => 'Nhiều ảnh',
                                    ])
                                    ->default('text')
                                    ->required()
                                    ->native(false),
                                Forms\Components\Textarea::make('helper_text')
                                    ->label('Gợi ý nhập liệu')
                                    ->rows(2)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('options')
                                    ->label('Lựa chọn')
                                    ->rows(3)
                                    ->helperText('Mỗi dòng: ma|Nhãn hiển thị. Chỉ dùng khi kiểu là Danh sách chọn.')
                                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'select')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('max_length')
                                    ->label('Độ dài tối đa')
                                    ->numeric()
                                    ->minValue(1)
                                    ->visible(fn (Forms\Get $get): bool => in_array($get('type'), ['text', 'textarea'], true)),
                                Forms\Components\TextInput::make('rows')
                                    ->label('Số dòng')
                                    ->numeric()
                                    ->minValue(2)
                                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'textarea'),
                                Forms\Components\TextInput::make('aspect_ratio')
                                    ->label('Tỉ lệ gợi ý (không crop ảnh)')
                                    ->maxLength(20)
                                    ->placeholder('Ví dụ: 4:5')
                                    ->helperText('Chỉ để người nhập tham khảo; hệ thống luôn giữ nguyên ảnh gốc.')
                                    ->visible(fn (Forms\Get $get): bool => in_array($get('type'), ['image', 'images'], true)),
                                Forms\Components\TextInput::make('max_files')
                                    ->label('Số ảnh tối đa')
                                    ->numeric()
                                    ->minValue(1)
                                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'images'),
                                Forms\Components\Toggle::make('required')
                                    ->label('Bắt buộc nhập'),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->cloneable()
                            ->reorderable()
                            ->defaultItems(0)
                            ->addActionLabel('+ Thêm field riêng')
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? $state['key'] ?? 'Field mới'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Ảnh')
                    ->defaultImageUrl('https://placehold.co/100x100?text=No+Image')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên giao diện')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Template $record) => $record->view_path),
                Tables\Columns\TextColumn::make('type')
                    ->label('Phân loại')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'wedding' => 'success',
                        'business' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Bật/Tắt'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'wedding' => 'Wedding',
                        'business' => 'Business',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('sync')
                    ->label('Sync Templates')
                    ->action(function () {
                        \Artisan::call('templates:sync');
                        \Filament\Notifications\Notification::make()
                            ->title('Templates synced!')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Sync Templates')
                    ->modalDescription('Scan template files and sync to database?')
                    ->color('success'),
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
            'index' => Pages\ListTemplates::route('/'),
            'create' => Pages\CreateTemplate::route('/create'),
            'edit' => Pages\EditTemplate::route('/{record}/edit'),
        ];
    }
}
