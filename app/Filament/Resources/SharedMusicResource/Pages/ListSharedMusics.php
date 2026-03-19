<?php

namespace App\Filament\Resources\SharedMusicResource\Pages;

use App\Filament\Resources\SharedMusicResource;
use Filament\Resources\Pages\ListRecords;

class ListSharedMusics extends ListRecords
{
    protected static string $resource = SharedMusicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
