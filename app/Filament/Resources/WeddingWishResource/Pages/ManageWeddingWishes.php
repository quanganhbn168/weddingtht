<?php

namespace App\Filament\Resources\WeddingWishResource\Pages;

use App\Filament\Resources\WeddingWishResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWeddingWishes extends ManageRecords
{
    protected static string $resource = WeddingWishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
