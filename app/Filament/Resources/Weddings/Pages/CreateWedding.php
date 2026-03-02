<?php

namespace App\Filament\Resources\Weddings\Pages;

use App\Filament\Resources\Weddings\WeddingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWedding extends CreateRecord
{
    protected static string $resource = WeddingResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $currentPanel = \Filament\Facades\Filament::getCurrentPanel()->getId();
        $currentUser = auth()->user();

        // If in App panel (Customer), always assign to self
        if ($currentPanel === 'app') {
            $data['user_id'] = $currentUser->id;
            return $data;
        }

        // If in Agent panel, might want to assign to a customer or create one
        // For now, let's keep the legacy logic for admin/agent or improve it
        
        // 1. Determine User Credentials
        $usernameStub = $data['slug'] ?? \Illuminate\Support\Str::slug($data['groom_name'] . '-va-' . $data['bride_name']);
        $email = $usernameStub . '@wedding.com'; 
        $password = !empty($data['password']) ? $data['password'] : '12345678';

        // 2. Find or Create User
        $user = \App\Models\User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $data['groom_name'] . ' & ' . $data['bride_name'],
                'password' => \Illuminate\Support\Facades\Hash::make($password),
                'role' => \App\Models\User::ROLE_CUSTOMER,
                'agent_id' => $currentPanel === 'agent' ? $currentUser->id : null,
            ]
        );

        // 3. Assign User to Wedding
        $data['user_id'] = $user->id;

        return $data;
    }
}
