<?php

namespace App\Filament\Resources\Weddings\Pages;

use App\Actions\ResolveWeddingUserAction;
use App\Filament\Resources\Weddings\WeddingResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateWedding extends CreateRecord
{
    protected static string $resource = WeddingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return app(ResolveWeddingUserAction::class)->execute(
            data: $data,
            panel: Filament::getCurrentPanel()?->getId(),
            agentUserId: auth()->id(),
        );
    }
}
