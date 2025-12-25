<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessCardResource\Pages;
use App\Filament\Resources\BusinessCardResource\RelationManagers;
use App\Models\BusinessCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BusinessCardResource extends Resource
{
    protected static ?string $model = BusinessCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Thông tin chính')
                            ->schema([
                                Forms\Components\Section::make('Cá nhân')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Họ tên')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($set, $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('URL Slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Chức vụ / Nghề nghiệp'),
                                        Forms\Components\TextInput::make('company')
                                            ->label('Công ty / Tổ chức'),
                                        Forms\Components\RichEditor::make('about')
                                            ->label('Giới thiệu bản thân')
                                            ->columnSpanFull(),
                                    ]),
                                Forms\Components\Section::make('Hình ảnh')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                                            ->label('Ảnh đại diện')
                                            ->collection('avatar')
                                            ->avatar(),
                                        Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                                            ->label('Ảnh bìa')
                                            ->collection('cover'),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Liên hệ & MXH')
                            ->schema([
                                Forms\Components\Section::make('Thông tin liên hệ')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('phone')->tel()->label('Số điện thoại'),
                                        Forms\Components\TextInput::make('email')->email()->label('Email'),
                                        Forms\Components\TextInput::make('website')->url()->label('Website'),
                                        Forms\Components\TextInput::make('address')->label('Địa chỉ'),
                                    ]),
                                Forms\Components\Repeater::make('social_links')
                                    ->label('Mạng xã hội & Ngân hàng')
                                    ->schema([
                                        Forms\Components\Select::make('platform')
                                            ->options([
                                                'facebook' => 'Facebook',
                                                'zalo' => 'Zalo',
                                                'tiktok' => 'TikTok',
                                                'linkedin' => 'LinkedIn',
                                                'instagram' => 'Instagram',
                                                'youtube' => 'YouTube',
                                                'bank' => 'Tài khoản Ngân hàng',
                                                'custom' => 'Khác',
                                            ])
                                            ->required(),
                                        Forms\Components\TextInput::make('url')
                                            ->label('Link / Số tài khoản')
                                            ->required(),
                                        Forms\Components\TextInput::make('label')
                                            ->label('Nhãn hiển thị (nếu cần)'),
                                    ])
                                    ->grid(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('Nội dung Website')
                            ->schema([
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Section::make('Dịch vụ / Sản phẩm')
                                            ->schema([
                                                Forms\Components\Repeater::make('services')
                                                    ->label('Danh sách dịch vụ')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('title')->label('Tên dịch vụ')->required(),
                                                        Forms\Components\Textarea::make('description')->label('Mô tả ngắn'),
                                                        Forms\Components\TextInput::make('icon')->label('Icon (FontAwesome class)')->placeholder('fas fa-star'),
                                                    ])
                                                    ->grid(2),
                                            ]),
                                        Forms\Components\Section::make('Con số ấn tượng')
                                            ->schema([
                                                Forms\Components\Repeater::make('stats')
                                                    ->label('Danh sách số liệu')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('number')->label('Con số (VD: 10+)')->required(),
                                                        Forms\Components\TextInput::make('label')->label('Mô tả (VD: Năm kinh nghiệm)')->required(),
                                                    ])
                                                    ->grid(4),
                                            ]),
                                        Forms\Components\Section::make('Kinh nghiệm / Dự án')
                                            ->schema([
                                                Forms\Components\Repeater::make('experience')
                                                    ->label('Timeline')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('year')->label('Thời gian')->placeholder('2020 - Nay'),
                                                        Forms\Components\TextInput::make('title')->label('Vị trí / Dự án'),
                                                        Forms\Components\TextInput::make('company')->label('Nơi làm việc / Khách hàng'),
                                                        Forms\Components\Textarea::make('description')->label('Mô tả chi tiết'),
                                                    ])
                                                    ->columns(2),
                                            ]),
                                        Forms\Components\Section::make('Trích dẫn (Quote)')
                                            ->schema([
                                                Forms\Components\Textarea::make('quote_text')->label('Nội dung câu nói'),
                                                Forms\Components\TextInput::make('quote_author')->label('Tác giả / Nguồn'),
                                            ]),
                                    ])
                                    ->statePath('content'), // Map all children to the 'content' JSON column
                            ]),
                        Forms\Components\Tabs\Tab::make('Cấu hình')
                            ->schema([
                                Forms\Components\Select::make('template_id')
                                    ->relationship('template', 'name', fn ($query) => $query->where('type', 'business'))
                                    ->label('Giao diện (Template)')
                                    ->required(),
                                Forms\Components\ColorPicker::make('theme_color')
                                    ->label('Màu chủ đạo'),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->revealable()
                                    ->label('Mật khẩu (Tùy chọn)'),
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Đang hoạt động')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('avatar')
                    ->circular()
                    ->label('Ảnh'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Họ tên'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Chức vụ'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->label('Slug / URL'),
                Tables\Columns\TextColumn::make('template.name')
                    ->label('Giao diện'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Bật/Tắt'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make()
                    ->excludeAttributes(['slug']) // Slug must be unique, so exclude it or let it regenerate
                    ->beforeReplicaSaved(function (\App\Models\BusinessCard $replica) {
                        // Append random string to slug to ensure uniqueness
                        $replica->slug = $replica->slug . '-copy-' . rand(100, 999);
                        $replica->name = $replica->name . ' (Copy)';
                    }),
                Tables\Actions\Action::make('qr_code')
                    ->label('QR Code')
                    ->icon('heroicon-o-qr-code')
                    ->modalHeading(fn (BusinessCard $record) => "QR Code - {$record->name}")
                    ->modalContent(function (BusinessCard $record) {
                        $url = url('/p/' . $record->slug);
                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url);
                        return view('filament.components.qr-code-modal', compact('qrUrl', 'url'));
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Đóng'),
                    
                Tables\Actions\Action::make('view_profile')
                    ->label('Xem')
                    ->icon('heroicon-o-eye')
                    ->url(fn (BusinessCard $record) => url('/p/' . $record->slug))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListBusinessCards::route('/'),
            'create' => Pages\CreateBusinessCard::route('/create'),
            'edit' => Pages\EditBusinessCard::route('/{record}/edit'),
        ];
    }
}
