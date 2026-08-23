<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use InvalidArgumentException;
use JsonException;

class WeddingTemplateSchemaTransferService
{
    private const FORMAT_VERSION = 1;

    /** @return array<string, mixed> */
    public function export(): array
    {
        return [
            'format' => 'wedding-template-schemas',
            'version' => self::FORMAT_VERSION,
            'exported_at' => now()->toIso8601String(),
            'templates' => Template::query()
                ->wedding()
                ->orderBy('view_path')
                ->get(['name', 'view_path', 'content_schema'])
                ->map(fn (Template $template): array => [
                    'name' => $template->name,
                    'view_path' => $template->view_path,
                    'content_schema' => $template->content_schema ?? [],
                ])
                ->values()
                ->all(),
        ];
    }

    public function exportJson(): string
    {
        try {
            return json_encode(
                $this->export(),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
            );
        } catch (JsonException $exception) {
            throw new InvalidArgumentException('Không thể tạo file schema JSON.', previous: $exception);
        }
    }

    /** @return array{created: int, updated: int, templates: int} */
    public function importJson(string $json): array
    {
        try {
            $manifest = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new InvalidArgumentException('File schema không phải JSON hợp lệ.', previous: $exception);
        }

        if (! is_array($manifest)
            || ($manifest['format'] ?? null) !== 'wedding-template-schemas'
            || ($manifest['version'] ?? null) !== self::FORMAT_VERSION
            || ! is_array($manifest['templates'] ?? null)) {
            throw new InvalidArgumentException('File không đúng định dạng schema của WeddingTHT.');
        }

        $templates = $this->validateTemplates($manifest['templates']);
        $created = 0;
        $updated = 0;

        DB::transaction(function () use ($templates, &$created, &$updated): void {
            foreach ($templates as $templateData) {
                $template = Template::query()
                    ->where('view_path', $templateData['view_path'])
                    ->first();

                if ($template) {
                    $template->update(['content_schema' => $templateData['content_schema']]);
                    $updated++;

                    continue;
                }

                if (! View::exists($templateData['view_path'])) {
                    throw new InvalidArgumentException("Chưa có file giao diện {$templateData['view_path']} trên máy chủ. Hãy deploy code của mẫu trước.");
                }

                Template::query()->create([
                    'name' => $templateData['name'],
                    'view_path' => $templateData['view_path'],
                    'type' => 'wedding',
                    'is_active' => true,
                    'content_schema' => $templateData['content_schema'],
                ]);
                $created++;
            }
        });

        return [
            'created' => $created,
            'updated' => $updated,
            'templates' => count($templates),
        ];
    }

    /** @param array<mixed> $templates
     *  @return array<int, array{name: string, view_path: string, content_schema: array<mixed>}>
     */
    private function validateTemplates(array $templates): array
    {
        $viewPaths = [];

        return collect($templates)
            ->map(function (mixed $template, int $index) use (&$viewPaths): array {
                if (! is_array($template)) {
                    throw new InvalidArgumentException('Mục template #'.($index + 1).' không hợp lệ.');
                }

                $name = trim((string) ($template['name'] ?? ''));
                $viewPath = trim((string) ($template['view_path'] ?? ''));
                $schema = $template['content_schema'] ?? [];

                if ($name === '' || mb_strlen($name) > 255) {
                    throw new InvalidArgumentException('Tên template trong file schema không hợp lệ.');
                }

                if (! preg_match('/^templates\.[a-zA-Z0-9_.-]+$/', $viewPath)) {
                    throw new InvalidArgumentException("View path {$viewPath} không hợp lệ.");
                }

                if (isset($viewPaths[$viewPath])) {
                    throw new InvalidArgumentException("View path {$viewPath} bị lặp trong file schema.");
                }

                if (! is_array($schema)) {
                    throw new InvalidArgumentException("Schema của {$viewPath} phải là danh sách field.");
                }

                $viewPaths[$viewPath] = true;

                return [
                    'name' => $name,
                    'view_path' => $viewPath,
                    'content_schema' => $this->validateSchema($schema, $viewPath),
                ];
            })
            ->values()
            ->all();
    }

    /** @param array<mixed> $schema
     *  @return array<mixed>
     */
    private function validateSchema(array $schema, string $viewPath): array
    {
        $keys = [];

        return collect($schema)
            ->map(function (mixed $field, int $index) use (&$keys, $viewPath): array {
                if (! is_array($field)) {
                    throw new InvalidArgumentException("Field #".($index + 1)." của {$viewPath} không hợp lệ.");
                }

                $key = trim((string) ($field['key'] ?? ''));
                $label = trim((string) ($field['label'] ?? ''));
                $type = $field['type'] ?? 'text';

                if (! preg_match('/^[a-z][a-z0-9_]*$/', $key)) {
                    throw new InvalidArgumentException("Mã field {$key} của {$viewPath} không hợp lệ.");
                }

                if ($label === '' || mb_strlen($label) > 160) {
                    throw new InvalidArgumentException("Nhãn của field {$key} trong {$viewPath} không hợp lệ.");
                }

                if (! in_array($type, ['text', 'textarea', 'select', 'toggle', 'number', 'url', 'date', 'image', 'images'], true)) {
                    throw new InvalidArgumentException("Kiểu field {$key} trong {$viewPath} không được hỗ trợ.");
                }

                if (isset($keys[$key])) {
                    throw new InvalidArgumentException("Mã field {$key} bị lặp trong {$viewPath}.");
                }

                $keys[$key] = true;

                return $field;
            })
            ->values()
            ->all();
    }
}
