<?php

namespace App\Filament\Resources\Weddings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class WeddingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('wedding_tabs')
                    ->columnSpanFull()
                    ->tabs([
                        
                        // === TAB 1: THÔNG TIN CƠ BẢN ===
                        Tab::make('Thông tin cơ bản')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Cô dâu & Chú rể')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('groom_name')
                                            ->label('Tên chú rể')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(debounce: 500)
                                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                                $brideName = $get('bride_name');
                                                if (($state || $brideName) && !$get('slug')) {
                                                    $set('slug', Str::slug(($state ?? 'chu-re') . '-va-' . ($brideName ?? 'co-dau') . '-' . now()->year));
                                                }
                                            }),
                                        
                                        TextInput::make('bride_name')
                                            ->label('Tên cô dâu')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(debounce: 500)
                                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                                $groomName = $get('groom_name');
                                                if (($state || $groomName) && !$get('slug')) {
                                                    $set('slug', Str::slug(($groomName ?? 'chu-re') . '-va-' . ($state ?? 'co-dau') . '-' . now()->year));
                                                }
                                            }),
                                    ]),
                                
                                Section::make('Ngày cưới')
                                    ->columns(2)
                                    ->schema([
                                        DatePicker::make('event_date')
                                            ->label('Ngày cưới chính')
                                            ->required()
                                            ->helperText('Ngày âm lịch sẽ tự động tính'),
                                        
                                        TextInput::make('event_date_lunar')
                                            ->label('Ngày âm lịch')
                                            ->disabled()
                                            ->helperText('Tự động cập nhật'),
                                    ]),
                                    
                                Section::make('Cài đặt')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('slug')
                                            ->label('URL Slug')
                                            ->placeholder('vd: tung-duong-2024')
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Tự động tạo. Để trống hệ thống sẽ tự sinh.')
                                            ->dehydrated(true),
                                        
                                        Select::make('status')
                                            ->label('Trạng thái')
                                            ->options([
                                                'draft' => 'Bản nháp',
                                                'preview' => 'Xem trước',
                                                'published' => 'Đã xuất bản',
                                                'archived' => 'Lưu trữ',
                                            ])
                                            ->default('draft')
                                            ->required(),
                                        
                                        Select::make('template_view')
                                            ->label('Mẫu giao diện')
                                            ->options(function () {
                                                $files = \Illuminate\Support\Facades\File::files(resource_path('views/templates'));
                                                $options = [];
                                                foreach ($files as $file) {
                                                    $filename = $file->getFilenameWithoutExtension();
                                                    if (str_ends_with($filename, '.blade')) {
                                                        $name = substr($filename, 0, -6);
                                                        
                                                        // Tự động đọc tên từ trong file (Template Name: ...)
                                                        $content = \Illuminate\Support\Facades\File::get($file->getPathname());
                                                        if (preg_match('/{{\s*--\s*Template Name:\s*(.*?)\s*--\s*}}/', $content, $matches)) {
                                                            $options["templates.{$name}"] = $matches[1];
                                                        } else {
                                                            // Fallback nếu không có tên
                                                            $options["templates.{$name}"] = \Illuminate\Support\Str::headline($name);
                                                        }
                                                    }
                                                }
                                                return $options;
                                            })
                                            ->default('templates.modern_01')
                                            ->required(),
                                        
                                        TextInput::make('password')
                                            ->label('Mật khẩu xem thiệp')
                                            ->password()
                                            ->helperText('Để trống nếu không cần'),
                                    ]),
                            ]),

                        // === TAB 2: NHÀ TRAI ===
                        Tab::make('Nhà Trai')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('👔 Thông tin gia đình nhà trai')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('groom_father')
                                            ->label('Ông (Cha)')
                                            ->placeholder('Nguyễn Văn A')
                                            ->required(),
                                        TextInput::make('groom_mother')
                                            ->label('Bà (Mẹ)')
                                            ->placeholder('Trần Thị B')
                                            ->required(),
                                    ]),
                                    
                                Section::make('💒 Lễ Thành Hôn (Nhà trai)')
                                    ->columns(2)
                                    ->description('Lễ đón dâu tại nhà trai')
                                    ->schema([
                                        TimePicker::make('groom_ceremony_time')
                                            ->label('Giờ làm lễ')
                                            ->seconds(false),
                                        
                                        DatePicker::make('groom_ceremony_date')
                                            ->label('Ngày')
                                            ->helperText('Nếu khác ngày cưới chính'),
                                        
                                        Textarea::make('groom_address')
                                            ->label('Địa chỉ')
                                            ->columnSpanFull(),
                                        
                                        TextInput::make('groom_map_url')
                                            ->label('Link Google Maps')
                                            ->url()
                                            ->columnSpanFull(),
                                    ]),
                                
                                Section::make('🍽️ Tiệc cưới nhà trai')
                                    ->columns(2)
                                    ->schema([
                                        TimePicker::make('groom_reception_time')
                                            ->label('Giờ tiệc')
                                            ->seconds(false),
                                        
                                        TextInput::make('groom_reception_venue')
                                            ->label('Tên nhà hàng/địa điểm'),
                                        
                                        Textarea::make('groom_reception_address')
                                            ->label('Địa chỉ tiệc')
                                            ->columnSpanFull(),
                                    ]),
                                    
                                Section::make('💳 QR Mừng cưới nhà trai')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('groom_qr')
                                            ->label('Ảnh QR Code')
                                            ->collection('groom_qr')
                                            ->disk('public')
                                            ->image(),
                                        
                                        Textarea::make('groom_qr_info')
                                            ->label('Thông tin tài khoản')
                                            ->placeholder("Ngân hàng: ...\nSố TK: ...\nChủ TK: ..."),
                                    ]),
                            ]),

                        // === TAB 3: NHÀ GÁI ===
                        Tab::make('Nhà Gái')
                            ->icon('heroicon-o-heart')
                            ->schema([
                                Section::make('👗 Thông tin gia đình nhà gái')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('bride_father')
                                            ->label('Ông (Cha)')
                                            ->placeholder('Lê Văn C')
                                            ->required(),
                                        TextInput::make('bride_mother')
                                            ->label('Bà (Mẹ)')
                                            ->placeholder('Phạm Thị D')
                                            ->required(),
                                    ]),
                                    
                                Section::make('💐 Lễ Vu Quy (Nhà gái)')
                                    ->columns(2)
                                    ->description('Lễ gả con gái tại nhà gái')
                                    ->schema([
                                        TimePicker::make('bride_ceremony_time')
                                            ->label('Giờ làm lễ')
                                            ->seconds(false),
                                        
                                        DatePicker::make('bride_ceremony_date')
                                            ->label('Ngày')
                                            ->helperText('Nếu khác ngày cưới chính'),
                                        
                                        Textarea::make('bride_address')
                                            ->label('Địa chỉ')
                                            ->columnSpanFull(),
                                        
                                        TextInput::make('bride_map_url')
                                            ->label('Link Google Maps')
                                            ->url()
                                            ->columnSpanFull(),
                                    ]),
                                
                                Section::make('🍽️ Tiệc cưới nhà gái')
                                    ->columns(2)
                                    ->schema([
                                        TimePicker::make('bride_reception_time')
                                            ->label('Giờ tiệc')
                                            ->seconds(false),
                                        
                                        TextInput::make('bride_reception_venue')
                                            ->label('Tên nhà hàng/địa điểm'),
                                        
                                        Textarea::make('bride_reception_address')
                                            ->label('Địa chỉ tiệc')
                                            ->columnSpanFull(),
                                    ]),
                                    
                                Section::make('💳 QR Mừng cưới nhà gái')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('bride_qr')
                                            ->label('Ảnh QR Code')
                                            ->collection('bride_qr')
                                            ->disk('public')
                                            ->image(),
                                        
                                        Textarea::make('bride_qr_info')
                                            ->label('Thông tin tài khoản')
                                            ->placeholder("Ngân hàng: ...\nSố TK: ...\nChủ TK: ..."),
                                    ]),
                            ]),

                        // === TAB 4: HÌNH ẢNH & NHẠC ===
                        Tab::make('Media')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('🎵 Nhạc nền')
                                    ->schema([
                                        FileUpload::make('background_music')
                                            ->label('File nhạc MP3')
                                            ->disk('public')
                                            ->directory('music')
                                            ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                                            ->maxSize(10240)
                                            ->helperText('Tối đa 10MB, định dạng MP3'),
                                    ]),
                                    
                                Section::make('📸 Ảnh đại diện')
                                    ->columns(3)
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('cover')
                                            ->label('Ảnh bìa (16:9)')
                                            ->collection('cover')
                                            ->disk('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageCropAspectRatio('16:9'),
                                        
                                        SpatieMediaLibraryFileUpload::make('groom_photo')
                                            ->label('Ảnh chú rể (3:4)')
                                            ->collection('groom_photo')
                                            ->disk('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageCropAspectRatio('3:4'),
                                        
                                        SpatieMediaLibraryFileUpload::make('bride_photo')
                                            ->label('Ảnh cô dâu (3:4)')
                                            ->collection('bride_photo')
                                            ->disk('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageCropAspectRatio('3:4'),
                                    ]),

                                Section::make('🖼️ Album ảnh')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->label('Gallery')
                                            ->collection('gallery')
                                            ->disk('public')
                                            ->image()
                                            ->multiple()
                                            ->reorderable()
                                            ->maxFiles(20),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
