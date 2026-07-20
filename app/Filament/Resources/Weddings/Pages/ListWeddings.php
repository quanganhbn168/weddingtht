<?php

namespace App\Filament\Resources\Weddings\Pages;

use App\Filament\Resources\Weddings\WeddingResource;
use App\Services\WeddingArchiveService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ListWeddings extends ListRecords
{
    protected static string $resource = WeddingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('import_archive')
                ->label('Nhập thiệp ZIP')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('gray')
                ->modalHeading('Nhập bản sao lưu thiệp')
                ->modalDescription('Chọn file ZIP đã xuất từ WeddingTHT. Hệ thống sẽ tạo một thiệp mới cùng toàn bộ dữ liệu và hình ảnh trong file.')
                ->modalSubmitActionLabel('Nhập thiệp')
                ->form([
                    FileUpload::make('archive')
                        ->label('File sao lưu ZIP')
                        ->disk('local')
                        ->directory('wedding-imports')
                        ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                        ->maxSize(512000)
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $archive = $data['archive'] ?? null;

                    if (! is_string($archive) || ! Storage::disk('local')->exists($archive)) {
                        Notification::make()
                            ->title('Không tìm thấy file ZIP đã tải lên')
                            ->danger()
                            ->send();

                        return;
                    }

                    try {
                        $wedding = app(WeddingArchiveService::class)->import(
                            Storage::disk('local')->path($archive),
                            Filament::getCurrentPanel()?->getId(),
                            auth()->id(),
                        );
                    } catch (Throwable $exception) {
                        report($exception);

                        Notification::make()
                            ->title('Không thể nhập file ZIP')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();

                        return;
                    } finally {
                        Storage::disk('local')->delete($archive);
                    }

                    Notification::make()
                        ->title('Đã nhập thiệp thành công')
                        ->body('Thiệp mới cùng dữ liệu và media đã được khôi phục.')
                        ->success()
                        ->send();

                    $this->redirect(WeddingResource::getUrl('edit', ['record' => $wedding]));
                }),
            CreateAction::make(),
        ];
    }
}
