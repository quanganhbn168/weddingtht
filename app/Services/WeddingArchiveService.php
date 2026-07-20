<?php

namespace App\Services;

use App\Actions\ResolveWeddingUserAction;
use App\Models\Template;
use App\Models\Wedding;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;
use ZipArchive;

class WeddingArchiveService
{
    private const FORMAT = 'weddingtht.wedding-backup';

    private const VERSION = 1;

    private const MAX_ARCHIVE_FILE_SIZE = 50 * 1024 * 1024;

    /** @return array{path: string, filename: string} */
    public function export(Wedding $wedding): array
    {
        $directory = storage_path('app/private/wedding-exports');
        File::ensureDirectoryExists($directory);

        $filename = sprintf(
            'thiep-cuoi-%s-%s.zip',
            Str::slug($wedding->slug ?: $wedding->groom_name.'-va-'.$wedding->bride_name),
            now()->format('Ymd-His'),
        );
        $path = $directory.DIRECTORY_SEPARATOR.Str::uuid().'.zip';
        $zip = new ZipArchive;

        if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Không thể tạo file ZIP sao lưu thiệp.');
        }

        try {
            $manifest = [
                'format' => self::FORMAT,
                'version' => self::VERSION,
                'exported_at' => now()->toAtomString(),
                'source_slug' => $wedding->slug,
                'template' => [
                    'view_path' => $wedding->template?->view_path ?? $wedding->template_view,
                    'name' => $wedding->template?->name,
                ],
                'wedding' => $this->exportAttributes($wedding),
                'media' => [],
                'background_music' => $this->addBackgroundMusic($zip, $wedding),
                'related' => [
                    'rsvps' => $wedding->rsvps()
                        ->get(['name', 'phone', 'attendance', 'guests', 'side', 'note'])
                        ->map(fn ($rsvp): array => $rsvp->toArray())
                        ->all(),
                    'wishes' => $wedding->wishes()
                        ->get(['name', 'message', 'is_approved'])
                        ->map(fn ($wish): array => $wish->toArray())
                        ->all(),
                ],
            ];

            foreach ($wedding->media()->get() as $index => $media) {
                $sourcePath = $media->getPath();

                if (! is_file($sourcePath)) {
                    throw new RuntimeException("Không tìm thấy file media: {$media->file_name}");
                }

                $archivePath = sprintf(
                    'media/%s/%04d-%s',
                    Str::slug($media->collection_name),
                    $index + 1,
                    $this->safeFileName($media->file_name),
                );

                if (! $zip->addFile($sourcePath, $archivePath)) {
                    throw new RuntimeException("Không thể thêm file vào ZIP: {$media->file_name}");
                }

                $manifest['media'][] = [
                    'source_media_id' => $media->id,
                    'archive_path' => $archivePath,
                    'collection' => $media->collection_name,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'custom_properties' => $media->custom_properties ?? [],
                    'order' => $media->order_column,
                ];
            }

            $json = json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

            if (! $zip->addFromString('wedding.json', $json)) {
                throw new RuntimeException('Không thể ghi thông tin thiệp vào ZIP.');
            }
        } catch (Throwable $exception) {
            $zip->close();
            File::delete($path);

            throw $exception;
        }

        $zip->close();

        return compact('path', 'filename');
    }

    public function import(string $archivePath, ?string $panel = null, ?int $agentUserId = null): Wedding
    {
        if (! is_file($archivePath)) {
            throw new RuntimeException('Không tìm thấy file ZIP cần nhập.');
        }

        $zip = new ZipArchive;

        if ($zip->open($archivePath) !== true) {
            throw new RuntimeException('File tải lên không phải ZIP hợp lệ.');
        }

        $temporaryDirectory = storage_path('app/private/wedding-imports/'.Str::uuid());
        File::ensureDirectoryExists($temporaryDirectory);
        $wedding = null;

        try {
            $manifest = $this->readManifest($zip);
            $template = $this->resolveTemplate($manifest);
            $data = $this->importAttributes($manifest, $template);

            $data = app(ResolveWeddingUserAction::class)->execute($data, $panel, $agentUserId);
            $wedding = new Wedding;
            $wedding->forceFill($data);
            $wedding->save();

            $mediaIdMap = $this->importMedia($zip, $manifest, $wedding, $temporaryDirectory);
            $this->importBackgroundMusic($zip, $manifest, $wedding, $temporaryDirectory);
            $this->importRelatedData($manifest, $wedding);

            $sourceAlbumImageId = data_get($manifest, 'wedding.album_love_media_id');
            if ($sourceAlbumImageId && isset($mediaIdMap[(string) $sourceAlbumImageId])) {
                $wedding->forceFill(['album_love_media_id' => $mediaIdMap[(string) $sourceAlbumImageId]])->save();
            }

            return $wedding->fresh(['template']);
        } catch (Throwable $exception) {
            if ($wedding?->exists) {
                $wedding->media()->get()->each->delete();
                $wedding->delete();
            }

            throw $exception;
        } finally {
            $zip->close();
            File::deleteDirectory($temporaryDirectory);
        }
    }

    /** @return array<string, mixed> */
    private function exportAttributes(Wedding $wedding): array
    {
        $attributes = Arr::except($wedding->getAttributes(), [
            'id',
            'user_id',
            'agent_id',
            'template_id',
            'template_view',
            'slug',
            'shared_music_id',
            'background_music',
            'album_love_media_id',
            'is_demo',
            'password',
            'edit_token',
            'preview_token',
            'custom_domain',
            'created_at',
            'updated_at',
        ]);

        foreach (['content', 'album_love_focal_point'] as $key) {
            $attributes[$key] = $wedding->getAttribute($key);
        }

        $attributes['album_love_media_id'] = $wedding->album_love_media_id;

        return $attributes;
    }

    /** @return array<string, mixed>|null */
    private function addBackgroundMusic(ZipArchive $zip, Wedding $wedding): ?array
    {
        $musicPath = (string) $wedding->background_music;

        if ($musicPath === '' || ! Storage::disk('public')->exists($musicPath)) {
            return null;
        }

        $archivePath = 'files/background-music-'.$this->safeFileName(basename($musicPath));

        if (! $zip->addFile(Storage::disk('public')->path($musicPath), $archivePath)) {
            throw new RuntimeException('Không thể thêm nhạc nền vào ZIP.');
        }

        return [
            'archive_path' => $archivePath,
            'file_name' => basename($musicPath),
        ];
    }

    /** @return array<string, mixed> */
    private function readManifest(ZipArchive $zip): array
    {
        $json = $zip->getFromName('wedding.json');

        if (! is_string($json)) {
            throw new RuntimeException('ZIP chưa có file wedding.json.');
        }

        try {
            $manifest = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable) {
            throw new RuntimeException('File wedding.json không hợp lệ.');
        }

        if (! is_array($manifest)
            || ($manifest['format'] ?? null) !== self::FORMAT
            || ($manifest['version'] ?? null) !== self::VERSION) {
            throw new RuntimeException('Đây không phải file sao lưu thiệp hợp lệ hoặc phiên bản chưa được hỗ trợ.');
        }

        return $manifest;
    }

    private function resolveTemplate(array $manifest): Template
    {
        $viewPath = data_get($manifest, 'template.view_path');

        if (! is_string($viewPath) || $viewPath === '') {
            throw new RuntimeException('File ZIP thiếu thông tin template.');
        }

        $template = Template::query()
            ->where('type', 'wedding')
            ->where('view_path', $viewPath)
            ->first();

        if (! $template) {
            throw new RuntimeException("Chưa có template {$viewPath} trên hệ thống này.");
        }

        return $template;
    }

    /** @return array<string, mixed> */
    private function importAttributes(array $manifest, Template $template): array
    {
        $data = data_get($manifest, 'wedding');

        if (! is_array($data)) {
            throw new RuntimeException('File ZIP thiếu dữ liệu thiệp.');
        }

        Validator::make($data, [
            'groom_name' => ['required', 'string', 'max:255'],
            'bride_name' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
        ])->validate();

        $data['template_id'] = $template->id;
        $data['template_view'] = $template->view_path;
        $data['type'] = 'wedding';
        $data['is_demo'] = false;
        $data['shared_music_id'] = null;
        $data['background_music'] = null;
        $data['slug'] = $this->nextImportSlug((string) ($manifest['source_slug'] ?? ''));

        return $data;
    }

    /** @return array<string, int> */
    private function importMedia(ZipArchive $zip, array $manifest, Wedding $wedding, string $temporaryDirectory): array
    {
        $mediaIdMap = [];

        foreach (data_get($manifest, 'media', []) as $index => $media) {
            if (! is_array($media)) {
                throw new RuntimeException('Dữ liệu media trong ZIP không hợp lệ.');
            }

            $archivePath = $media['archive_path'] ?? null;
            $collection = $media['collection'] ?? null;

            if (! is_string($archivePath) || ! is_string($collection) || ! $this->isSafeArchivePath($archivePath, 'media/')) {
                throw new RuntimeException('Đường dẫn media trong ZIP không hợp lệ.');
            }

            $temporaryPath = $this->copyArchiveFile($zip, $archivePath, $temporaryDirectory, "media-{$index}");
            $fileName = $this->safeFileName((string) ($media['file_name'] ?? basename($archivePath)));

            $newMedia = $wedding
                ->addMedia($temporaryPath)
                ->usingName((string) ($media['name'] ?? pathinfo($fileName, PATHINFO_FILENAME)))
                ->usingFileName($fileName)
                ->withCustomProperties(is_array($media['custom_properties'] ?? null) ? $media['custom_properties'] : [])
                ->setOrder(isset($media['order']) ? (int) $media['order'] : null)
                ->toMediaCollection($collection, 'public');

            if (isset($media['source_media_id'])) {
                $mediaIdMap[(string) $media['source_media_id']] = $newMedia->id;
            }
        }

        return $mediaIdMap;
    }

    private function importBackgroundMusic(ZipArchive $zip, array $manifest, Wedding $wedding, string $temporaryDirectory): void
    {
        $music = data_get($manifest, 'background_music');

        if (! is_array($music) || ! is_string($music['archive_path'] ?? null)
            || ! $this->isSafeArchivePath($music['archive_path'], 'files/')) {
            return;
        }

        $temporaryPath = $this->copyArchiveFile($zip, $music['archive_path'], $temporaryDirectory, 'background-music');
        $extension = pathinfo((string) ($music['file_name'] ?? $temporaryPath), PATHINFO_EXTENSION) ?: 'mp3';
        $relativePath = 'music/import-'.Str::uuid().'.'.Str::lower($extension);

        $stream = fopen($temporaryPath, 'rb');

        if (! is_resource($stream) || ! Storage::disk('public')->put($relativePath, $stream)) {
            if (is_resource($stream)) {
                fclose($stream);
            }

            throw new RuntimeException('Không thể khôi phục nhạc nền từ ZIP.');
        }

        fclose($stream);
        $wedding->forceFill(['background_music' => $relativePath])->save();
    }

    private function importRelatedData(array $manifest, Wedding $wedding): void
    {
        foreach (data_get($manifest, 'related.rsvps', []) as $rsvp) {
            if (is_array($rsvp) && filled($rsvp['name'] ?? null)) {
                $wedding->rsvps()->create(Arr::only($rsvp, ['name', 'phone', 'attendance', 'guests', 'side', 'note']));
            }
        }

        foreach (data_get($manifest, 'related.wishes', []) as $wish) {
            if (is_array($wish) && filled($wish['name'] ?? null) && filled($wish['message'] ?? null)) {
                $wedding->wishes()->create(Arr::only($wish, ['name', 'message', 'is_approved']));
            }
        }
    }

    private function copyArchiveFile(ZipArchive $zip, string $archivePath, string $temporaryDirectory, string $prefix): string
    {
        $stat = $zip->statName($archivePath);

        if (! $stat || (int) ($stat['size'] ?? 0) > self::MAX_ARCHIVE_FILE_SIZE) {
            throw new RuntimeException("File {$archivePath} không tồn tại hoặc vượt quá 50 MB.");
        }

        $input = $zip->getStream($archivePath);

        if (! is_resource($input)) {
            throw new RuntimeException("Không thể đọc file {$archivePath} trong ZIP.");
        }

        $temporaryPath = $temporaryDirectory.DIRECTORY_SEPARATOR.$prefix.'-'.Str::uuid();
        $output = fopen($temporaryPath, 'wb');

        if (! is_resource($output)) {
            fclose($input);
            throw new RuntimeException('Không thể tạo file tạm để nhập ZIP.');
        }

        stream_copy_to_stream($input, $output);
        fclose($input);
        fclose($output);

        return $temporaryPath;
    }

    private function nextImportSlug(string $sourceSlug): string
    {
        $base = Str::slug($sourceSlug) ?: 'thiep-cuoi';
        $candidate = $base.'-import';
        $counter = 2;

        while (Wedding::query()->where('slug', $candidate)->exists()) {
            $candidate = $base.'-import-'.$counter++;
        }

        return $candidate;
    }

    private function isSafeArchivePath(string $path, string $prefix): bool
    {
        return Str::startsWith($path, $prefix)
            && ! Str::contains($path, ['..', '\\'])
            && $path === ltrim($path, '/');
    }

    private function safeFileName(string $fileName): string
    {
        $fileName = basename($fileName);
        $fileName = preg_replace('/[^A-Za-z0-9._-]/u', '-', $fileName) ?: 'file';

        return trim($fileName, '.-') ?: 'file';
    }
}
