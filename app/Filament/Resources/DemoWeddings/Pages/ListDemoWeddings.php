<?php

namespace App\Filament\Resources\DemoWeddings\Pages;

use App\Filament\Resources\DemoWeddings\DemoWeddingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDemoWeddings extends ListRecords
{
    protected static string $resource = DemoWeddingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tạo Demo mới'),
        ];
    }
}
