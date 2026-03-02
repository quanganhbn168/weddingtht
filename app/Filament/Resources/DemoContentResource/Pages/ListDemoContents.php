<?php

namespace App\Filament\Resources\DemoContentResource\Pages;

use App\Filament\Resources\DemoContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDemoContents extends ListRecords
{
    protected static string $resource = DemoContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
