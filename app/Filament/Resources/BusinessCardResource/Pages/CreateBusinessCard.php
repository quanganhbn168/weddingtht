<?php

namespace App\Filament\Resources\BusinessCardResource\Pages;

use App\Filament\Resources\BusinessCardResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBusinessCard extends CreateRecord
{
    protected static string $resource = BusinessCardResource::class;
}
