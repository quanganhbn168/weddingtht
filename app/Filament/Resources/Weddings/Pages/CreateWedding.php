<?php

namespace App\Filament\Resources\Weddings\Pages;

use App\Filament\Resources\Weddings\WeddingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWedding extends CreateRecord
{
    protected static string $resource = WeddingResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $email = $data['user_email'] ?? null;
        $password = $data['user_password'] ?? null;

        if ($email && $password) {
            // Find or Create User
            $user = \App\Models\User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $data['groom_name'] . ' & ' . $data['bride_name'], // Default name
                    'password' => \Illuminate\Support\Facades\Hash::make($password),
                    'role' => \App\Models\User::ROLE_CUSTOMER,
                ]
            );

            // If user existed but we want to ensure role/password? 
            // Better not touch existing password. Just link.
            
            $data['user_id'] = $user->id;
        }

        // Clean up virtual fields
        unset($data['user_email']);
        unset($data['user_password']);

        return $data;
    }
}
