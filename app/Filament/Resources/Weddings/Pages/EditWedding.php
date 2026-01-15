<?php

namespace App\Filament\Resources\Weddings\Pages;

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
        // Check if the record already has a user
        if (!$this->record->user_id) {
            // Same logic as CreateWedding
            $usernameStub = $data['slug'] ?? \Illuminate\Support\Str::slug($data['groom_name'] . '-va-' . $data['bride_name']);
            $email = $usernameStub . '@wedding.com'; 
            
            $password = !empty($data['password']) ? $data['password'] : '12345678';

            $user = \App\Models\User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $data['groom_name'] . ' & ' . $data['bride_name'],
                    'password' => \Illuminate\Support\Facades\Hash::make($password),
                    'role' => \App\Models\User::ROLE_CUSTOMER,
                ]
            );

            $data['user_id'] = $user->id;
        }

        return $data;
    }
}
