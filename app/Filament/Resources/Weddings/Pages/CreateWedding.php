<?php

namespace App\Filament\Resources\Weddings\Pages;

use App\Filament\Resources\Weddings\WeddingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWedding extends CreateRecord
{
    protected static string $resource = WeddingResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Determine User Credentials
        // Default to slug if no specific email provided (which is not in form anymore)
        $usernameStub = $data['slug'] ?? \Illuminate\Support\Str::slug($data['groom_name'] . '-va-' . $data['bride_name']);
        
        // Ensure email uniqueness properly?
        // Let's use a fake email domain for these auto-generated accounts
        $email = $usernameStub . '@wedding.com'; 
        
        // Password: Use the view password if set, else default
        $password = !empty($data['password']) ? $data['password'] : '12345678';

        // 2. Find or Create User
        // Check if user exists by email
        $user = \App\Models\User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $data['groom_name'] . ' & ' . $data['bride_name'],
                'password' => \Illuminate\Support\Facades\Hash::make($password),
                'role' => \App\Models\User::ROLE_CUSTOMER,
            ]
        );

        // 3. Assign User to Wedding
        $data['user_id'] = $user->id;

        return $data;
    }
}
