<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Actions\Action;

class PricingSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Bảng giá';
    protected static ?string $title = 'Cài đặt Bảng giá';
    protected static ?string $navigationGroup = 'Cài đặt';
    protected static ?int $navigationSort = 10;
    
    protected static string $view = 'filament.pages.pricing-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            // Retail pricing
            'price_basic' => Setting::get('price_basic', 198000),
            'price_standard' => Setting::get('price_standard', 299000),
            'price_pro' => Setting::get('price_pro', 499000),
            
            // Agent pricing
            'agent_price_basic' => Setting::get('agent_price_basic', 199000),
            'agent_price_standard' => Setting::get('agent_price_standard', 499000),
            'agent_price_enterprise' => Setting::get('agent_price_enterprise', 999000),
            
            // Agent quotas
            'agent_quota_basic' => Setting::get('agent_quota_basic', 10),
            'agent_quota_standard' => Setting::get('agent_quota_standard', 30),
            
            // Tier limits
            'photos_basic' => Setting::get('photos_basic', 20),
            'photos_standard' => Setting::get('photos_standard', 40),
            'expires_basic' => Setting::get('expires_basic', 6),
            'expires_standard' => Setting::get('expires_standard', 12),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('💒 Giá Thiệp Cưới (Khách lẻ)')
                    ->description('Giá bán trọn gói cho khách hàng cá nhân')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('price_basic')
                                    ->label('Gói Cơ bản (VNĐ)')
                                    ->numeric()
                                    ->required()
                                    ->prefix('₫')
                                    ->helperText('6 tháng, 20 ảnh'),
                                Forms\Components\TextInput::make('price_standard')
                                    ->label('Gói Tiêu chuẩn (VNĐ)')
                                    ->numeric()
                                    ->required()
                                    ->prefix('₫')
                                    ->helperText('1 năm, 40 ảnh, hiệu ứng'),
                                Forms\Components\TextInput::make('price_pro')
                                    ->label('Gói Pro (VNĐ)')
                                    ->numeric()
                                    ->required()
                                    ->prefix('₫')
                                    ->helperText('Vĩnh viễn, ∞ ảnh, full features'),
                            ]),
                    ]),
                    
                Forms\Components\Section::make('🏢 Giá Đại lý (Thuê theo tháng)')
                    ->description('Giá thuê hàng tháng cho đại lý/studio')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('agent_price_basic')
                                    ->label('Gói Cơ bản (VNĐ/tháng)')
                                    ->numeric()
                                    ->required()
                                    ->prefix('₫'),
                                Forms\Components\TextInput::make('agent_price_standard')
                                    ->label('Gói Tiêu chuẩn (VNĐ/tháng)')
                                    ->numeric()
                                    ->required()
                                    ->prefix('₫'),
                                Forms\Components\TextInput::make('agent_price_enterprise')
                                    ->label('Gói Doanh nghiệp (VNĐ/tháng)')
                                    ->numeric()
                                    ->required()
                                    ->prefix('₫'),
                            ]),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('agent_quota_basic')
                                    ->label('Quota Cơ bản')
                                    ->numeric()
                                    ->required()
                                    ->suffix('thiệp/tháng'),
                                Forms\Components\TextInput::make('agent_quota_standard')
                                    ->label('Quota Tiêu chuẩn')
                                    ->numeric()
                                    ->required()
                                    ->suffix('thiệp/tháng'),
                                Forms\Components\Placeholder::make('agent_quota_enterprise')
                                    ->label('Quota Doanh nghiệp')
                                    ->content('Không giới hạn'),
                            ]),
                    ]),
                    
                Forms\Components\Section::make('📊 Giới hạn theo gói')
                    ->description('Số ảnh và thời hạn cho từng gói')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('photos_basic')
                                    ->label('Số ảnh Cơ bản')
                                    ->numeric()
                                    ->required()
                                    ->suffix('ảnh'),
                                Forms\Components\TextInput::make('photos_standard')
                                    ->label('Số ảnh Tiêu chuẩn')
                                    ->numeric()
                                    ->required()
                                    ->suffix('ảnh'),
                                Forms\Components\TextInput::make('expires_basic')
                                    ->label('Thời hạn Cơ bản')
                                    ->numeric()
                                    ->required()
                                    ->suffix('tháng'),
                                Forms\Components\TextInput::make('expires_standard')
                                    ->label('Thời hạn Tiêu chuẩn')
                                    ->numeric()
                                    ->required()
                                    ->suffix('tháng'),
                            ]),
                        Forms\Components\Placeholder::make('pro_info')
                            ->label('')
                            ->content('Gói Pro: Ảnh không giới hạn, lưu trữ vĩnh viễn'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value, 'integer');
            }
        }

        Setting::clearCache();

        Notification::make()
            ->title('Đã lưu cài đặt!')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('💾 Lưu cài đặt')
                ->submit('save'),
        ];
    }
}
