<?php

namespace App\Filament\Resources\SharedMusicResource\Pages;

use App\Filament\Resources\SharedMusicResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use getID3;

class EditSharedMusic extends EditRecord
{
    protected static string $resource = SharedMusicResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Only re-detect if file changed (file_path differs from current record)
        if (!empty($data['file_path']) && $data['file_path'] !== $this->record->file_path) {
            $fullPath = Storage::disk('public')->path($data['file_path']);

            if (file_exists($fullPath)) {
                $data['file_size'] = filesize($fullPath);

                // Reset duration so it gets re-detected
                $data['duration'] = null;

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
                    // Silently ignore
                }
            }
        }

        return $data;
    }
}
