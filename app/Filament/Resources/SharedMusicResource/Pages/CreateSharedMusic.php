<?php

namespace App\Filament\Resources\SharedMusicResource\Pages;

use App\Filament\Resources\SharedMusicResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use getID3;

class CreateSharedMusic extends CreateRecord
{
    protected static string $resource = SharedMusicResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = $this->fillAudioMeta($data);
        return $data;
    }

    protected function fillAudioMeta(array $data): array
    {
        if (empty($data['file_path'])) {
            return $data;
        }

        $fullPath = Storage::disk('public')->path($data['file_path']);

        if (!file_exists($fullPath)) {
            return $data;
        }

        // Auto file size
        $data['file_size'] = filesize($fullPath);

        // Auto duration via getID3
        if (empty($data['duration'])) {
            try {
                $getId3 = new getID3();
                $info = $getId3->analyze($fullPath);

                if (!empty($info['playtime_seconds'])) {
                    $seconds = (int) $info['playtime_seconds'];
                    $minutes = floor($seconds / 60);
                    $secs = $seconds % 60;
                    $data['duration'] = sprintf('%d:%02d', $minutes, $secs);
                }
            } catch (\Throwable $e) {
                // Silently ignore if getID3 fails
            }
        }

        return $data;
    }
}
