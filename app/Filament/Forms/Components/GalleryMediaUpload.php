<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Notifications\Notification;

class GalleryMediaUpload extends SpatieMediaLibraryFileUpload
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->multiple()
            ->reorderable()
            ->panelLayout('grid')
            ->hintAction(
                Action::make('clearAll')
                    ->label('Xóa tất cả')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Xóa toàn bộ ảnh?')
                    ->modalDescription('Toàn bộ ảnh trong gallery sẽ được bỏ khỏi album sau khi anh bấm Lưu.')
                    ->modalSubmitActionLabel('Xóa tất cả')
                    ->visible(fn (GalleryMediaUpload $component): bool => ! empty($component->getState()))
                    ->action(function (GalleryMediaUpload $component): void {
                        $component->state([]);

                        Notification::make()
                            ->title('Đã làm trống gallery')
                            ->body('Bấm Lưu để xác nhận xóa các ảnh này khỏi album.')
                            ->success()
                            ->send();
                    }),
            );
    }
}
