<?php

namespace App\Filament\Resources\Weddings\Pages;

use App\Actions\ResolveWeddingUserAction;
use App\Filament\Resources\Weddings\WeddingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWedding extends EditRecord
{
    protected static string $resource = WeddingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Chỉ resolve user nếu chưa có user_id
        if (empty($data['user_id']) && !$this->record->user_id) {
            return app(ResolveWeddingUserAction::class)->execute(
                data: $data,
                panel: null,
                agentUserId: null,
            );
        }

        // Đã có user_id → chỉ cleanup
        unset($data['customer_email'], $data['customer_password']);
        return $data;
    }
}
