<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Cài đặt trang web';
    protected static ?string $title = 'Cài đặt trang web';
    protected static ?string $slug = 'site-settings';
    protected static ?int $navigationSort = 99;
    protected static ?string $navigationGroup = 'Hệ thống';

    protected static string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name'   => Setting::get('site_name', config('app.name')),
            'site_tagline'=> Setting::get('site_tagline', ''),
            'site_logo'   => Setting::get('site_logo', ''),
            'site_favicon'=> Setting::get('site_favicon', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin chung')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Tên trang web')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('site_tagline')
                            ->label('Khẩu hiệu (tagline)')
                            ->maxLength(200)
                            ->placeholder('Thiệp cưới online đẹp nhất Việt Nam'),
                    ])->columns(2),

                Section::make('Logo & Favicon')
                    ->icon('heroicon-o-photo')
                    ->description('Logo hiển thị trên header. Favicon hiển thị trên tab trình duyệt.')
                    ->schema([
                        FileUpload::make('site_logo')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('site')
                            ->acceptedFileTypes(['image/png', 'image/svg+xml', 'image/webp', 'image/jpeg'])
                            ->maxSize(2048)
                            ->imagePreviewHeight('80')
                            ->helperText('PNG, SVG, WebP — tối đa 2MB. Nên dùng PNG nền trong suốt.')
                            ->columnSpan(1),

                        FileUpload::make('site_favicon')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('site')
                            ->acceptedFileTypes(['image/png', 'image/x-icon', 'image/ico', 'image/vnd.microsoft.icon'])
                            ->maxSize(512)
                            ->imagePreviewHeight('80')
                            ->helperText('ICO hoặc PNG 32×32px — tối đa 512KB.')
                            ->columnSpan(1),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('site_name',    $data['site_name']);
        Setting::set('site_tagline', $data['site_tagline'] ?? '');

        if (!empty($data['site_logo'])) {
            Setting::set('site_logo', $data['site_logo']);
        }
        if (!empty($data['site_favicon'])) {
            Setting::set('site_favicon', $data['site_favicon']);
        }

        // Clear all setting cache after save
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
                ->label('Lưu cài đặt')
                ->submit('save')
                ->icon('heroicon-o-check')
                ->color('primary'),
        ];
    }
}
