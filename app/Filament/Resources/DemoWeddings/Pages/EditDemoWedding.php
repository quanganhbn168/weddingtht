<?php

namespace App\Filament\Resources\DemoWeddings\Pages;

use App\Filament\Resources\DemoWeddings\DemoWeddingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDemoWedding extends EditRecord
{
    protected static string $resource = DemoWeddingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view')
                ->label('Xem Demo')
                ->url(fn () => url($this->record->slug))
                ->openUrlInNewTab()
                ->icon('heroicon-o-eye')
                ->color('info'),
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
