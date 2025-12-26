<?php

namespace App\Filament\Resources\AgentResource\Pages;

use App\Filament\Resources\AgentResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateAgent extends CreateRecord
{
    protected static string $resource = AgentResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function afterCreate(): void
    {
        // Set user role to agent
        $user = User::find($this->record->user_id);
        if ($user) {
            $user->update(['role' => User::ROLE_AGENT]);
        }
        
        // Start trial if no dates set
        if (!$this->record->trial_ends_at && $this->record->subscription_plan === 'trial') {
            $this->record->startTrial();
        }
    }
}
