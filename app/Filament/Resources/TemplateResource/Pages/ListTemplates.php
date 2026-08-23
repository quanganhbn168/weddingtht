<?php

namespace App\Filament\Resources\TemplateResource\Pages;

use App\Filament\Resources\TemplateResource;
use App\Services\WeddingTemplateSchemaTransferService;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ListTemplates extends ListRecords
{
    protected static string $resource = TemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_schemas')
                ->label('Xuất schema JSON')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $json = app(WeddingTemplateSchemaTransferService::class)->exportJson();

                    return response()->streamDownload(
                        static fn () => print($json),
                        'wedding-template-schemas-'.now()->format('Ymd-His').'.json',
                        ['Content-Type' => 'application/json; charset=utf-8'],
                    );
                }),
            Actions\Action::make('import_schemas')
                ->label('Nhập schema JSON')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('gray')
                ->modalHeading('Nhập schema giao diện')
                ->modalDescription('File xuất từ WeddingTHT local sẽ cập nhật schema của các mẫu tương ứng. Schema hiện có của những mẫu trong file sẽ bị thay thế.')
                ->modalSubmitActionLabel('Nhập schema')
                ->form([
                    FileUpload::make('schema_file')
                        ->label('File schema JSON')
                        ->disk('local')
                        ->directory('template-schema-imports')
                        ->acceptedFileTypes(['application/json', 'text/json'])
                        ->maxSize(1024)
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $path = $data['schema_file'] ?? null;

                    if (! is_string($path) || ! Storage::disk('local')->exists($path)) {
                        Notification::make()
                            ->title('Không tìm thấy file schema đã tải lên')
                            ->danger()
                            ->send();

                        return;
                    }

                    try {
                        $result = app(WeddingTemplateSchemaTransferService::class)
                            ->importJson(Storage::disk('local')->get($path));
                    } catch (Throwable $exception) {
                        report($exception);

                        Notification::make()
                            ->title('Không thể nhập schema')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();

                        return;
                    } finally {
                        Storage::disk('local')->delete($path);
                    }

                    Notification::make()
                        ->title('Đã nhập schema giao diện')
                        ->body("Đã cập nhật {$result['updated']} mẫu và tạo {$result['created']} mẫu mới.")
                        ->success()
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }
}
