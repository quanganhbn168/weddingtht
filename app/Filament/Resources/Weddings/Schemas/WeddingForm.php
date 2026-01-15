<?php

namespace App\Filament\Resources\Weddings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Enums\FallingEffect;

class WeddingForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Tabs::make('wedding_tabs')
                    ->columnSpanFull()
                    ->tabs([
                        
                        // === TAB 1: THÔNG TIN CƠ BẢN ===
                        Tab::make('Thông tin cơ bản')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('👤 Tài khoản Khách hàng (Chủ sở hữu)')
                                    ->description('Tạo tài khoản mới hoặc gán vào tài khoản cũ (theo Email)')
                                    ->schema([
                                        TextInput::make('user_email')
                                            ->label('Email đăng nhập')
                                            ->email()
                                            ->required()
                                            ->dehydrated(false) // Not saved to wedding table directly
                                            ->placeholder('VD: codau@example.com'),
                                            
                                        TextInput::make('user_password')
                                            ->label('Mật khẩu')
                                            ->password()
                                            ->revealable()
                                            ->dehydrated(false)
                                            ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                                            ->placeholder('Nhập mật khẩu cho khách'),
                                    ])
                                    ->visible(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord), // Only show on Create

                                Section::make('Cô dâu & Chú rể')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('groom_name')
                                            ->label('Tên chú rể')
                                            ->required(fn (Get $get) => $get('type') === 'wedding')
                                            ->maxLength(255)
                                            ->live(debounce: 500)
                                            ->afterStateUpdated(function ($get, $set, ?string $state) {
                                                $brideName = $get('bride_name');
                                                $currentSlug = $get('slug');
                                                $eventDate = $get('event_date');
                                                $dateSuffix = $eventDate ? \Carbon\Carbon::parse($eventDate)->format('d-m-Y') : now()->year;
                                                
                                                if ($state && $brideName) {
                                                    $baseSlug = Str::slug("$state-va-$brideName-" . $dateSuffix);
                                                    $newSlug = $baseSlug;

                                                    while (\App\Models\Wedding::where('slug', $newSlug)->where('id', '!=', $get('id'))->exists()) {
                                                        $newSlug = $baseSlug . '-' . Str::lower(Str::random(4));
                                                    }

                                                    // Update if empty OR if seemingly auto-generated (contains 'va')
                                                    // This allows correcting typos in names to reflect in slug
                                                    if (blank($currentSlug) || str_contains($currentSlug, '-va-')) {
                                                        $set('slug', $newSlug);
                                                    }
                                                }
                                            }),
                                        
                                        TextInput::make('bride_name')
                                            ->label('Tên cô dâu')
                                            ->required(fn (Get $get) => $get('type') === 'wedding')
                                            ->maxLength(255)
                                            ->live(debounce: 500)
                                            ->afterStateUpdated(function ($get, $set, ?string $state) {
                                                $groomName = $get('groom_name');
                                                $currentSlug = $get('slug');
                                                $eventDate = $get('event_date');
                                                $dateSuffix = $eventDate ? \Carbon\Carbon::parse($eventDate)->format('d-m-Y') : now()->year;

                                                if ($state && $groomName) {
                                                    $baseSlug = Str::slug("$groomName-va-$state-" . $dateSuffix);
                                                    $newSlug = $baseSlug;

                                                    while (\App\Models\Wedding::where('slug', $newSlug)->where('id', '!=', $get('id'))->exists()) {
                                                        $newSlug = $baseSlug . '-' . Str::lower(Str::random(4));
                                                    }

                                                    // Update if empty OR if seemingly auto-generated (contains 'va')
                                                    if (blank($currentSlug) || str_contains($currentSlug, '-va-')) {
                                                        $set('slug', $newSlug);
                                                    }
                                                }
                                            }),
                                    ])
                                    ->visible(fn (Get $get) => $get('type') === 'wedding'),
                                
                                Section::make('Ngày cưới')
                                    ->columns(2)
                                    ->schema([
                                        DatePicker::make('event_date')
                                            ->label('Ngày cưới chính')
                                            ->required(fn (Get $get) => $get('type') === 'wedding')
                                            ->helperText('Ngày âm lịch sẽ tự động tính')
                                            ->live()
                                            ->afterStateUpdated(function ($get, $set, ?string $state) {
                                                // 1. Calculate and set Lunar Date using Helper
                                                if ($state) {
                                                    $lunarDate = \App\Helpers\LunarHelper::solarToLunar($state);
                                                    $set('event_date_lunar', $lunarDate);
                                                }

                                                // 2. Regenerate slug when date changes
                                                $groomName = $get('groom_name');
                                                $brideName = $get('bride_name');
                                                
                                                if ($groomName && $brideName && $state) {
                                                    $dateSuffix = \Carbon\Carbon::parse($state)->format('d-m-Y');
                                                    
                                                    // Always force update when date changes if names are present, 
                                                    // because formatting by DATE is more specific and safer than just year.
                                                    
                                                    $baseSlug = Str::slug("$groomName-va-$brideName-" . $dateSuffix);
                                                    $newSlug = $baseSlug;

                                                     while (\App\Models\Wedding::where('slug', $newSlug)->where('id', '!=', $get('id'))->exists()) {
                                                        $newSlug = $baseSlug . '-' . Str::lower(Str::random(4));
                                                    }
                                                    
                                                    // Update if empty OR if seemingly auto-generated (contains 'va')
                                                    // Or just always update since date changed and user expects it
                                                    $currentSlug = $get('slug');
                                                    if (blank($currentSlug) || str_contains($currentSlug, '-va-')) {
                                                        $set('slug', $newSlug);
                                                    }
                                                }
                                            }),
                                        
                                        TextInput::make('event_date_lunar')
                                            ->label('Ngày âm lịch')
                                            ->disabled()
                                            ->dehydrated() // Ensure it is sent to server if needed, though model hooks also handle it
                                            ->helperText('Tự động cập nhật'),
                                    ])
                                    ->visible(fn (Get $get) => $get('type') === 'wedding'),
                                    
                                Section::make('Cài đặt')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('type')
                                            ->label('Loại trang')
                                            ->options([
                                                'wedding' => 'Đám cưới (Wedding)',
                                                'business' => 'Danh thiếp (Business Card)',
                                                'event' => 'Sự kiện (Event)',
                                            ])
                                            ->default('wedding')
                                            ->live()
                                            ->afterStateUpdated(fn (Set $set) => $set('template_id', null))
                                            ->required()
                                            ->hidden(), // Hidden to enforce Wedding only workflow

                                        Select::make('template_id')
                                            ->label('Chọn Mẫu Giao Diện')
                                            ->options(function (Get $get) {
                                                $type = $get('type') ?? 'wedding';
                                                return \App\Models\Template::where('type', $type)
                                                    ->where('is_active', true)
                                                    ->pluck('name', 'id');
                                            })
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function ($state, Set $set) {
                                                if ($state) {
                                                    $template = \App\Models\Template::find($state);
                                                    if ($template) {
                                                        $set('template_view', $template->view_path);
                                                    }
                                                }
                                            }),
                                            
                                        // Hidden field to store the view path for frontend usage
                                        TextInput::make('template_view')
                                            ->hidden()
                                            ->dehydrated(),

                                        TextInput::make('slug')
                                            ->label('URL Slug')
                                            ->placeholder('vd: tung-duong-2024')
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Tự động tạo. Để trống hệ thống sẽ tự sinh.')
                                            ->dehydrated(true)
                                            ->autocomplete('off') // Prevent browser autofill
                                            ->extraInputAttributes(['autocomplete' => 'off']), // Double enforce

                                        Select::make('status')
                                            ->label('Trạng thái')
                                            ->options(WeddingStatus::options())
                                            ->default(WeddingStatus::DRAFT->value)
                                            ->required(),
                                        


                                        // Legacy template_view hidden or removed as we use template_id now
                                        // keeping it for now but hidden might be better, or just rely on controller fallback
                                        // Select::make('template_view') ...
                                        
                                        \Filament\Forms\Components\Toggle::make('is_auto_approve_wishes')
                                            ->label('Tự động duyệt lời chúc')
                                            ->default(false)
                                            ->helperText('Nếu bật, lời chúc sẽ hiện ngay lập tức không cần duyệt'),

                                        TextInput::make('password')
                                            ->label('Mật khẩu xem thiệp')
                                            ->password()
                                            ->autocomplete('new-password') // Prevent association with previous field
                                            ->revealable()
                                            ->helperText('Để trống nếu không cần'),
                                    ]),
                            ]),


                        // === TAB: BUSINESS ===
                        Tab::make('Thông tin Danh Thiếp')
                            ->icon('heroicon-o-briefcase')
                            ->visible(fn (Get $get) => $get('type') === 'business')
                            ->schema([
                                TextInput::make('content.full_name')->label('Họ tên đầy đủ')->required(),
                                TextInput::make('content.position')->label('Chức vụ/Vị trí'),
                                TextInput::make('content.company')->label('Tên công ty/Tổ chức'),
                                TextInput::make('content.website')->label('Website')->url(),
                                TextInput::make('content.email')->label('Email')->email(),
                                TextInput::make('content.phone')->label('Số điện thoại')->tel(),
                                Textarea::make('content.bio')->label('Giới thiệu ngắn')->rows(3),
                                Textarea::make('content.address')->label('Địa chỉ'),
                                SpatieMediaLibraryFileUpload::make('content.avatar')
                                    ->label('Ảnh đại diện')
                                    ->collection('avatar')
                                    ->disk('public'),
                            ]),

                        // === TAB: EVENT ===
                        Tab::make('Thông tin Sự Kiện')
                            ->icon('heroicon-o-calendar')
                            ->visible(fn (Get $get) => $get('type') === 'event')
                            ->schema([
                                TextInput::make('content.event_name')->label('Tên sự kiện')->required(),
                                TextInput::make('content.organizer')->label('Đơn vị tổ chức'),
                                TextInput::make('content.location')->label('Địa điểm'),
                                DatePicker::make('content.start_date')->label('Ngày bắt đầu'),
                                TimePicker::make('content.start_time')->label('Giờ bắt đầu'),
                                TextInput::make('content.registration_link')->label('Link đăng ký')->url(),
                            ]),

                        // === TAB 2: NHÀ TRAI ===
                        Tab::make('Nhà Trai')
                            ->icon('heroicon-o-user')
                            ->visible(fn (Get $get) => $get('type') === 'wedding')
                            ->schema([
                                Section::make('👔 Thông tin gia đình nhà trai')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('groom_father')
                                            ->label('Ông (Cha)')
                                            ->placeholder('Nguyễn Văn A')
                                            ->required(fn (Get $get) => $get('type') === 'wedding'),
                                        TextInput::make('groom_mother')
                                            ->label('Bà (Mẹ)')
                                            ->placeholder('Trần Thị B')
                                            ->required(fn (Get $get) => $get('type') === 'wedding'),
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
                            ->visible(fn (Get $get) => $get('type') === 'wedding')
                            ->schema([
                                Section::make('👗 Thông tin gia đình nhà gái')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('bride_father')
                                            ->label('Ông (Cha)')
                                            ->placeholder('Lê Văn C')
                                            ->required(fn (Get $get) => $get('type') === 'wedding'),
                                        TextInput::make('bride_mother')
                                            ->label('Bà (Mẹ)')
                                            ->placeholder('Phạm Thị D')
                                            ->required(fn (Get $get) => $get('type') === 'wedding'),
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
                                            ->label('Ảnh chia sẻ (OG Image - 1200x630)')
                                            ->collection('cover')
                                            ->disk('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageCropAspectRatio('1.91:1')
                                            ->helperText('Ảnh hiện khi chia sẻ link lên Facebook/Zalo'),
                                        
                                        SpatieMediaLibraryFileUpload::make('hero')
                                            ->label('Ảnh Hero Section (9:16)')
                                            ->collection('hero')
                                            ->disk('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageCropAspectRatio('9:16')
                                            ->helperText('Ảnh lớn đầu trang web (dọc)'),
                                        
                                        SpatieMediaLibraryFileUpload::make('groom_photo')
                                            ->label('Ảnh chú rể (3:4)')
                                            ->visible(fn (Get $get) => $get('type') === 'wedding')
                                            ->collection('groom_photo')
                                            ->disk('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageCropAspectRatio('3:4'),
                                        
                                        SpatieMediaLibraryFileUpload::make('bride_photo')
                                            ->label('Ảnh cô dâu (3:4)')
                                            ->visible(fn (Get $get) => $get('type') === 'wedding')
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
                        
                        // === TAB 5: PRO FEATURES ===
                        Tab::make('Pro Features')
                            ->icon('heroicon-o-sparkles')
                            ->badge('PRO')
                            ->schema([
                                Section::make('⚙️ Cài đặt gói dịch vụ')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('tier')
                                            ->label('Gói dịch vụ')
                                            ->options(WeddingTier::options())
                                            ->default(WeddingTier::STANDARD->value)
                                            ->required()
                                            ->live(),
                                        
                                        \Filament\Forms\Components\Toggle::make('is_demo')
                                            ->label('Đây là Demo')
                                            ->helperText('Thiệp demo sẽ có watermark "DEMO"')
                                            ->default(false),
                                        
                                        \Filament\Forms\Components\Toggle::make('can_share')
                                            ->label('Cho phép Share Public')
                                            ->helperText('Bật = ai có link xem được. Tắt = chỉ chủ sở hữu xem')
                                            ->default(true),
                                        
                                        Select::make('agent_id')
                                            ->label('Đại lý tạo')
                                            ->options(function () {
                                                return \App\Models\Agent::with('user')
                                                    ->where('is_active', true)
                                                    ->get()
                                                    ->pluck('business_name', 'id');
                                            })
                                            ->searchable()
                                            ->placeholder('Chọn đại lý (nếu có)'),
                                        
                                        DatePicker::make('expires_at')
                                            ->label('Ngày hết hạn')
                                            ->helperText('Standard: 1 năm, Pro: để trống (vĩnh viễn)')
                                            ->visible(fn (Get $get) => $get('tier') === 'standard'),
                                    ]),
                                
                                Section::make('✨ Hiệu ứng Premium')
                                    ->columns(2)
                                    ->description('Chỉ áp dụng cho gói Pro')
                                    ->schema([
                            \Filament\Forms\Components\Toggle::make('show_invitation_wrapper')
                                ->label('Hiệu ứng Phong bì (Envelope)')
                                ->default(true)
                                ->onColor('success')
                                ->offColor('danger')
                                ->columnSpan('full'),

                            \Filament\Forms\Components\Toggle::make('show_preload')
                                ->label('Màn hình chờ (Preload)')
                                ->default(false)
                                ->live()
                                ->onColor('success')
                                ->offColor('danger')
                                ->columnSpan('full'),
                            
                            Select::make('preload_variant')
                                ->label('Kiểu Preload')
                                ->options([
                                    'traditional' => 'Truyền thống (Song Hỷ)',
                                    'heartbeat' => 'Hiện đại (Nhịp tim)',
                                    'rings' => 'Sang trọng (Nhẫn cưới)',
                                ])
                                ->default('heartbeat')
                                ->visible(fn (Get $get) => $get('show_preload'))
                                ->required(fn (Get $get) => $get('show_preload')),
                                        
                                        Select::make('falling_effect')
                                            ->label('Hiệu ứng rơi')
                                            ->options(FallingEffect::options())
                                            ->default(FallingEffect::HEARTS->value),
                                    ]),
                                
                                Section::make('🌐 Custom Domain')
                                    ->description('Gói Pro hỗ trợ domain riêng')
                                    ->schema([
                                        TextInput::make('custom_domain')
                                            ->label('Domain tuỳ chỉnh')
                                            ->placeholder('cuoi.ten.vn')
                                            ->helperText('Liên hệ admin để thiết lập domain')
                                            ->url(false),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
