<?php

namespace App\Filament\Resources\WeddingRsvpResource\Pages;

use App\Filament\Resources\WeddingRsvpResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWeddingRsvps extends ManageRecords
{
    protected static string $resource = WeddingRsvpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
