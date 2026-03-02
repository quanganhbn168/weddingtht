<?php

namespace App\Filament\Resources\DemoWeddings\Pages;

use App\Filament\Resources\DemoWeddings\DemoWeddingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDemoWedding extends CreateRecord
{
    protected static string $resource = DemoWeddingResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_demo'] = true;
        $data['type'] = 'wedding';
        
        return $data;
    }
}
