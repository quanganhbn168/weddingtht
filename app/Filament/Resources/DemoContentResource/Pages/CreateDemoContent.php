<?php

namespace App\Filament\Resources\DemoContentResource\Pages;

use App\Filament\Resources\DemoContentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDemoContent extends CreateRecord
{
    protected static string $resource = DemoContentResource::class;
}
