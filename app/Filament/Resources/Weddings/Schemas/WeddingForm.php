<?php

namespace App\Filament\Resources\Weddings\Schemas;

use App\Enums\FallingEffect;
use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Helpers\LunarHelper;
use App\Models\Agent;
use App\Models\SharedMusic;
use App\Models\Template;
use App\Models\User;
use App\Models\Wedding;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

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
                                Section::make('Cô dâu & Chú rể')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('groom_name')
                                            ->label('Tên chú rể')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(debounce: 500)
                                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                                $brideName = $get('bride_name');
                                                $currentSlug = $get('slug');
                                                $eventDate = $get('event_date');
                                                $dateSuffix = $eventDate ? Carbon::parse($eventDate)->format('d-m-Y') : now()->year;
                                                
                                                if ($state && $brideName) {
                                                    $baseSlug = Str::slug("$state-va-$brideName-" . $dateSuffix);
                                                    $newSlug = $baseSlug;

                                                    while (Wedding::where('slug', $newSlug)->where('id', '!=', $get('id'))->exists()) {
                                                        $newSlug = $baseSlug . '-' . Str::lower(Str::random(4));
                                                    }

                                                    if (blank($currentSlug) || str_contains($currentSlug, '-va-')) {
                                                        $set('slug', $newSlug);
                                                    }
                                                }
                                            }),
                                        
                                        TextInput::make('bride_name')
                                            ->label('Tên cô dâu')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(debounce: 500)
                                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                                $groomName = $get('groom_name');
                                                $currentSlug = $get('slug');
                                                $eventDate = $get('event_date');
                                                $dateSuffix = $eventDate ? Carbon::parse($eventDate)->format('d-m-Y') : now()->year;

                                                if ($state && $groomName) {
                                                    $baseSlug = Str::slug("$groomName-va-$state-" . $dateSuffix);
                                                    $newSlug = $baseSlug;

                                                    while (Wedding::where('slug', $newSlug)->where('id', '!=', $get('id'))->exists()) {
                                                        $newSlug = $baseSlug . '-' . Str::lower(Str::random(4));
                                                    }

                                                    if (blank($currentSlug) || str_contains($currentSlug, '-va-')) {
                                                        $set('slug', $newSlug);
                                                    }
                                                }
                                            }),
                                    ]),
                                
                                Section::make('Ngày cưới')
                                    ->columns(2)
                                    ->schema([
                                        DatePicker::make('event_date')
                                            ->label('Ngày cưới chính')
                                            ->required()
                                            ->helperText('Ngày âm lịch sẽ tự động tính')
                                            ->live()
                                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                                if ($state) {
                                                    $set('event_date_lunar', LunarHelper::solarToLunar($state));
                                                }

                                                $groomName = $get('groom_name');
                                                $brideName = $get('bride_name');
                                                
                                                if ($groomName && $brideName && $state) {
                                                    $dateSuffix = Carbon::parse($state)->format('d-m-Y');
                                                    $baseSlug = Str::slug("$groomName-va-$brideName-" . $dateSuffix);
                                                    $newSlug = $baseSlug;

                                                    while (Wedding::where('slug', $newSlug)->where('id', '!=', $get('id'))->exists()) {
                                                        $newSlug = $baseSlug . '-' . Str::lower(Str::random(4));
                                                    }
                                                    
                                                    $currentSlug = $get('slug');
                                                    if (blank($currentSlug) || str_contains($currentSlug, '-va-')) {
                                                        $set('slug', $newSlug);
                                                    }
                                                }
                                            }),
                                        
                                        TextInput::make('event_date_lunar')
                                            ->label('Ngày âm lịch')
                                            ->disabled()
                                            ->dehydrated()
                                            ->helperText('Tự động cập nhật'),
                                    ]),
                                    
                                Section::make('Cài đặt')
                                    ->columns(2)
                                    ->schema([
                                        Hidden::make('type')->default('wedding'),

                                        Select::make('template_id')
                                            ->label('Chọn Mẫu Giao Diện')
                                            ->options(fn () => Template::where('type', 'wedding')
                                                ->where('is_active', true)
                                                ->pluck('name', 'id'))
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function ($state, Set $set) {
                                                if ($state) {
                                                    $template = Template::find($state);
                                                    if ($template) {
                                                        $set('template_view', $template->view_path);
                                                    }
                                                }
                                            }),
                                            
                                        Hidden::make('template_view')->dehydrated(),

                                        TextInput::make('slug')
                                            ->label('URL Slug')
                                            ->placeholder('vd: tung-duong-2024')
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Tự động tạo. Để trống hệ thống sẽ tự sinh.')
                                            ->dehydrated(true)
                                            ->autocomplete('off')
                                            ->extraInputAttributes(['autocomplete' => 'off']),

                                        Select::make('status')
                                            ->label('Trạng thái')
                                            ->options(WeddingStatus::options())
                                            ->default(WeddingStatus::DRAFT->value)
                                            ->required(),
                                        
                                        Toggle::make('is_auto_approve_wishes')
                                            ->label('Tự động duyệt lời chúc')
                                            ->default(false)
                                            ->helperText('Nếu bật, lời chúc sẽ hiện ngay lập tức không cần duyệt'),

                                        TextInput::make('password')
                                            ->label('Mật khẩu xem thiệp')
                                            ->password()
                                            ->autocomplete('new-password')
                                            ->revealable()
                                            ->helperText('Để trống nếu không cần'),
                                    ]),
                            ]),


                        // === TAB 2: NHÀ TRAI ===
                        Tab::make('Nhà Trai')
                            ->icon('heroicon-o-user')
                            ->visible(fn (Get $get) => $get('type') === 'wedding')
                            ->schema([
                                Section::make('Thông tin gia đình nhà trai')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('groom_father')
                                            ->label('Ông (Cha)')
                                            ->placeholder('Nguyễn Văn A'),
                                        TextInput::make('groom_mother')
                                            ->label('Bà (Mẹ)')
                                            ->placeholder('Trần Thị B'),
                                    ]),
                                    
                                Section::make('Lễ Thành Hôn (Nhà trai)')
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
                                            ->label('Địa chỉ hôn lễ')
                                            ->columnSpanFull(),

                                        TextInput::make('groom_ceremony_map_url')
                                            ->label('Link Google Maps hôn lễ')
                                            ->url()
                                            ->columnSpanFull(),

                                    ]),

                                
                                Section::make('Tiệc cưới nhà trai')
                                    ->columns(2)
                                    ->schema([
                                        TimePicker::make('groom_reception_time')
                                            ->label('Giờ tiệc')
                                            ->seconds(false),
                                        
                                        DatePicker::make('groom_reception_date')
                                            ->label('Ngày tiệc (Nếu khác ngày cưới)')
                                            ->displayFormat('d/m/Y'),
                                        
                                        TextInput::make('groom_reception_venue')
                                            ->label('Tên nhà hàng/địa điểm'),
                                        
                                        Textarea::make('groom_reception_address')
                                            ->label('Địa chỉ tiệc')
                                            ->columnSpanFull()
                                            ->hintAction(
                                                \Filament\Forms\Components\Actions\Action::make('copy_from_ceremony')
                                                    ->label('Dùng địa chỉ hôn lễ')
                                                    ->icon('heroicon-o-clipboard-document')
                                                    ->action(function (\Filament\Forms\Set $set, \Filament\Forms\Get $get) {
                                                        $set('groom_reception_address', $get('groom_address'));
                                                        $set('groom_reception_venue', $get('groom_reception_venue') ?: '');
                                                        $set('groom_map_url', $get('groom_ceremony_map_url'));
                                                        $set('groom_map_embed', $get('groom_ceremony_map_embed'));
                                                    })
                                            ),

                                        TextInput::make('groom_map_url')
                                            ->label('Link Google Maps')
                                            ->url()
                                            ->columnSpanFull(),

                                    ]),
                                    
                                Section::make('QR Mừng cưới nhà trai')
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
                                Section::make('Thông tin gia đình nhà gái')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('bride_father')
                                            ->label('Ông (Cha)')
                                            ->placeholder('Lê Văn C'),
                                        TextInput::make('bride_mother')
                                            ->label('Bà (Mẹ)')
                                            ->placeholder('Phạm Thị D'),
                                    ]),
                                    
                                Section::make('Lễ Vu Quy (Nhà gái)')
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
                                            ->label('Địa chỉ hôn lễ')
                                            ->columnSpanFull(),

                                        TextInput::make('bride_ceremony_map_url')
                                            ->label('Link Google Maps hôn lễ')
                                            ->url()
                                            ->columnSpanFull(),

                                    ]),
                                
                                Section::make('Tiệc cưới nhà gái')
                                    ->columns(2)
                                    ->schema([
                                        TimePicker::make('bride_reception_time')
                                            ->label('Giờ tiệc')
                                            ->seconds(false),
                                        
                                        DatePicker::make('bride_reception_date')
                                            ->label('Ngày tiệc (Nếu khác ngày cưới)')
                                            ->displayFormat('d/m/Y'),
                                        
                                        TextInput::make('bride_reception_venue')
                                            ->label('Tên nhà hàng/địa điểm'),
                                        
                                        Textarea::make('bride_reception_address')
                                            ->label('Địa chỉ tiệc')
                                            ->columnSpanFull()
                                            ->hintAction(
                                                \Filament\Forms\Components\Actions\Action::make('copy_bride_ceremony')
                                                    ->label('Dùng địa chỉ hôn lễ')
                                                    ->icon('heroicon-o-clipboard-document')
                                                    ->action(function (\Filament\Forms\Set $set, \Filament\Forms\Get $get) {
                                                        $set('bride_reception_address', $get('bride_address'));
                                                        $set('bride_map_url', $get('bride_ceremony_map_url'));
                                                        $set('bride_map_embed', $get('bride_ceremony_map_embed'));
                                                    })
                                            ),

                                        TextInput::make('bride_map_url')
                                            ->label('Link Google Maps')
                                            ->url()
                                            ->columnSpanFull(),

                                    ]),
                                    
                                Section::make('QR Mừng cưới nhà gái')
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
                                Section::make('Nhạc nền')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('shared_music_id')
                                            ->label('Chọn từ thư viện nhạc')
                                            ->options(fn () => SharedMusic::active()
                                                ->get()
                                                ->mapWithKeys(fn ($m) => [$m->id => $m->getLabel()]))
                                            ->searchable()
                                            ->placeholder('Chọn bài hát...')
                                            ->helperText('Nhạc dùng chung, không tốn dung lượng'),

                                        FileUpload::make('background_music')
                                            ->label('Hoặc upload file riêng')
                                            ->disk('public')
                                            ->directory('music')
                                            ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                                            ->maxSize(10240)
                                            ->helperText('Tối đa 10MB. Ưu tiên thư viện nhạc ở trên'),
                                    ]),
                                    
                                Section::make('Ảnh đại diện')
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

                                Section::make('Album ảnh')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->label('Gallery')
                                            ->collection('gallery')
                                            ->disk('public')
                                            ->image()
                                            ->multiple()
                                            ->reorderable()
                                            ->panelLayout('grid')
                                            ->maxFiles(100),
                                    ]),

                                Section::make('Ảnh Film Strip (ngang)')
                                    ->description('Ảnh landscape riêng cho thanh cuộn phía trên album. Nên dùng ảnh ngang tỉ lệ 3:2 hoặc 16:9.')
                                    ->collapsed()
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('film_gallery')
                                            ->label('Ảnh Film Strip')
                                            ->collection('film_gallery')
                                            ->disk('public')
                                            ->image()
                                            ->multiple()
                                            ->reorderable()
                                            ->panelLayout('grid')
                                            ->maxFiles(10),
                                    ]),
                            ]),
                        
                        // === TAB 5: PRO FEATURES (admin only) ===
                        Tab::make('Pro Features')
                            ->icon('heroicon-o-sparkles')
                            ->badge('PRO')
                            ->visible(fn () => Filament::getCurrentPanel()?->getId() === 'admin')
                            ->schema([
                                Section::make('Tài khoản khách hàng')
                                    ->columns(2)
                                    ->description('Gắn thiệp với tài khoản khách hàng để họ đăng nhập quản lý')
                                    ->schema([
                                        Select::make('user_id')
                                            ->label('Chọn khách hàng hiện có')
                                            ->options(fn () => User::where('role', User::ROLE_CUSTOMER)
                                                ->pluck('name', 'id'))
                                            ->searchable()
                                            ->placeholder('Chọn hoặc tạo mới bên dưới')
                                            ->helperText('Để trống nếu muốn tạo tài khoản mới'),
                                        
                                        TextInput::make('customer_email')
                                            ->label('Email khách hàng mới')
                                            ->email()
                                            ->placeholder('email@example.com')
                                            ->helperText('Nhập email để tạo tài khoản mới (nếu không chọn ở trên)')
                                            ->visible(fn (Get $get) => !$get('user_id')),
                                        
                                        TextInput::make('customer_password')
                                            ->label('Mật khẩu')
                                            ->password()
                                            ->default('12345678')
                                            ->helperText('Mặc định: 12345678')
                                            ->visible(fn (Get $get) => !$get('user_id')),
                                    ]),

                                Section::make('Cài đặt gói dịch vụ')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('tier')
                                            ->label('Gói dịch vụ')
                                            ->options(WeddingTier::options())
                                            ->default(WeddingTier::STANDARD->value)
                                            ->required()
                                            ->live(),
                                        
                                        Toggle::make('is_demo')
                                            ->label('Đây là Demo')
                                            ->helperText('Thiệp demo sẽ có watermark "DEMO"')
                                            ->default(false),
                                        
                                        Toggle::make('can_share')
                                            ->label('Cho phép Share Public')
                                            ->helperText('Bật = ai có link xem được. Tắt = chỉ chủ sở hữu xem')
                                            ->default(true),
                                        
                                        Select::make('agent_id')
                                            ->label('Đại lý tạo')
                                            ->options(fn () => Agent::where('is_active', true)
                                                ->pluck('business_name', 'id'))
                                            ->searchable()
                                            ->placeholder('Chọn đại lý (nếu có)'),
                                        
                                        DatePicker::make('expires_at')
                                            ->label('Ngày hết hạn')
                                            ->helperText('Standard: 1 năm, Pro: để trống (vĩnh viễn)')
                                            ->visible(fn (Get $get) => $get('tier') === 'standard'),
                                    ]),
                                
                                Section::make('Hiệu ứng Premium')
                                    ->columns(2)
                                    ->description('Chỉ áp dụng cho gói Pro')
                                    ->schema([
                                        Toggle::make('show_invitation_wrapper')
                                            ->label('Hiệu ứng Phong bì (Envelope)')
                                            ->default(true)
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->columnSpan('full'),

                                        Toggle::make('show_preload')
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
                                
                                Section::make('Custom Domain')
                                    ->description('Gói Pro hỗ trợ domain riêng')
                                    ->schema([
                                        TextInput::make('custom_domain')
                                            ->label('Domain tuỳ chỉnh')
                                            ->placeholder('cuoi.ten.vn')
                                            ->helperText('Liên hệ admin để thiết lập domain')
                                            ->url(false),
                                    ]),
                            ]),
                        
                        // === TAB 6: LỜI MỜI & LỜI CHÚC ===
                        Tab::make('Lời mời & Lời chúc')
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                Section::make('Lời chúc phúc (Blessing)')
                                    ->description('Hiển thị ở phần Mừng cưới')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('content.blessing_title')
                                            ->label('Tiêu đề')
                                            ->placeholder('Mừng Cưới'),
                                        Textarea::make('content.blessing_desc')
                                            ->label('Nội dung/Thông điệp')
                                            ->placeholder('Cảm ơn bạn đã gửi lời chúc...'),
                                    ]),

                                Section::make('Lời ngỏ (Prologue)')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('content.prologue_title')
                                            ->label('Tiêu đề')
                                            ->placeholder('Lời Ngỏ'),
                                        Textarea::make('content.prologue_desc')
                                            ->label('Nội dung')
                                            ->placeholder('Gặp gỡ, yêu và cưới...'),
                                    ]),
                                
                                Section::make('Xác nhận tham dự (RSVP)')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('content.rsvp_title')
                                            ->label('Tiêu đề')
                                            ->placeholder('Xác Nhận Tham Dự'),
                                        Textarea::make('content.rsvp_desc')
                                            ->label('Lời mời/Thông điệp')
                                            ->placeholder('Sự hiện diện của bạn là niềm vinh hạnh...'),
                                    ]),

                                Section::make('Sổ lưu bút (Guestbook)')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('content.guestbook_title')
                                            ->label('Tiêu đề')
                                            ->placeholder('Sổ Lưu Bút'),
                                        Textarea::make('content.guestbook_desc')
                                            ->label('Lời dẫn/Thông điệp')
                                            ->placeholder('Kỷ niệm đẹp là những gì chúng ta cùng nhau tạo ra...'),
                                    ]),

                                Section::make('Câu chuyện tình yêu (Love Story)')
                                    ->description('Timeline các cột mốc tình yêu, hiển thị trên template DA05 VIP')
                                    ->columns(1)
                                    ->schema([
                                        Repeater::make('content.love_story')
                                            ->label('Các mốc thời gian')
                                            ->schema([
                                                TextInput::make('year')
                                                    ->label('Năm')
                                                    ->placeholder('2021')
                                                    ->maxLength(10),
                                                TextInput::make('title')
                                                    ->label('Tiêu đề')
                                                    ->placeholder('Gặp Gỡ Định Mệnh')
                                                    ->maxLength(255),
                                                Textarea::make('description')
                                                    ->label('Mô tả')
                                                    ->placeholder('Năm ấy, giữa muôn vàn người...')
                                                    ->rows(3),
                                            ])
                                            ->columns(1)
                                            ->collapsible()
                                            ->cloneable()
                                            ->defaultItems(0)
                                            ->addActionLabel('+ Thêm mốc thời gian')
                                            ->itemLabel(fn (array $state): ?string => ($state['year'] ?? '') . ' - ' . ($state['title'] ?? 'Mốc mới')),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
