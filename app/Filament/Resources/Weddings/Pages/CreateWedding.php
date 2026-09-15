<?php

namespace App\Filament\Resources\Weddings\Pages;

use App\Actions\ResolveWeddingUserAction;
use App\Filament\Resources\Weddings\WeddingResource;
use App\Models\Template;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateWedding extends CreateRecord
{
    protected static string $resource = WeddingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = app(ResolveWeddingUserAction::class)->execute(
            data: $data,
            panel: Filament::getCurrentPanel()?->getId(),
            agentUserId: auth()->id(),
        );

        if (! empty($data['template_id'])) {
            $data['template_view'] = Template::query()
                ->whereKey($data['template_id'])
                ->value('view_path') ?: ($data['template_view'] ?? null);
        }

        return $data;
    }
}
