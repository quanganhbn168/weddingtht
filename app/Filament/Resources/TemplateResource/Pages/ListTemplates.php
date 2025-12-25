<?php

namespace App\Filament\Resources\TemplateResource\Pages;

use App\Filament\Resources\TemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTemplates extends ListRecords
{
    protected static string $resource = TemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('scan')
                ->label('Quét giao diện (Scan)')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->action(function () {
                    $path = resource_path('views/templates');
                    $files = \Illuminate\Support\Facades\File::allFiles($path);
                    $count = 0;

                    foreach ($files as $file) {
                        $content = $file->getContents();
                        // Regex to find Template Name and optional Type
                        if (preg_match('/Template Name:\s*(.*?)[\r\n]/', $content, $nameMatch)) {
                            $name = trim($nameMatch[1]);
                            
                            $type = 'wedding'; // Default
                            if (preg_match('/Type:\s*(.*?)[\r\n]/', $content, $typeMatch)) {
                                $type = trim($typeMatch[1]);
                            }

                            // Calculate view path relative to resources/views
                            $relativePath = $file->getRelativePathname();
                            $viewPath = 'templates.' . str_replace(['/', '.blade.php'], ['.', ''], $relativePath);

                            \App\Models\Template::updateOrCreate(
                                ['view_path' => $viewPath],
                                [
                                    'name' => $name,
                                    'type' => $type,
                                    'is_active' => true,
                                ]
                            );
                            $count++;
                        }
                    }

                    \Filament\Notifications\Notification::make()
                        ->title("Đã đồng bộ {$count} giao diện!")
                        ->success()
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }
}
