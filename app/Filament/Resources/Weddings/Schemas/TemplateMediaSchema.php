<?php

namespace App\Filament\Resources\Weddings\Schemas;

use App\Filament\Forms\Components\ImageFocalPointPicker;
use App\Models\Template;
use App\Models\Wedding;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Get;

class TemplateMediaSchema
{
    /** @return array<Section> */
    public static function sections(): array
    {
        $sections = [];

        foreach (config('wedding-template-media', []) as $viewPath => $definition) {
            $fields = [];

            foreach ($definition['fields'] ?? [] as $field) {
                $fields[] = self::imageUpload($field);

                if (! empty($field['focal_point'])) {
                    $fields[] = self::focalPointPicker($field);
                }
            }

            $sections[] = Section::make($definition['label'] ?? 'Ảnh riêng của giao diện')
                ->description($definition['description'] ?? null)
                ->columns((int) ($definition['columns'] ?? 2))
                ->schema($fields)
                ->visible(fn (Get $get): bool => self::isSelectedTemplate($get, $viewPath));
        }

        return $sections;
    }

    /** @param array<string, mixed> $field */
    private static function imageUpload(array $field): SpatieMediaLibraryFileUpload
    {
        $upload = SpatieMediaLibraryFileUpload::make($field['name'])
            ->label($field['label'])
            ->collection($field['collection'])
            ->disk('public')
            ->image()
            ->imageEditor()
            ->helperText($field['helper_text'] ?? null);

        if (! empty($field['aspect_ratio'])) {
            $upload->imageCropAspectRatio($field['aspect_ratio']);
        }

        return $upload;
    }

    /** @param array<string, mixed> $field */
    private static function focalPointPicker(array $field): ImageFocalPointPicker
    {
        $collection = $field['collection'];
        $default = $field['focal_point_default'] ?? ['x' => 50, 'y' => 50];

        return ImageFocalPointPicker::make($field['focal_point'])
            ->label('Vùng ảnh cần ưu tiên')
            ->helperText('Kéo dấu ngắm vào khuôn mặt hoặc vùng quan trọng để giữ vùng đó khi ảnh bị cắt.')
            ->imageUrl(fn (?Wedding $record): ?string => $record?->getTemplateMediaUrl($collection)
                ?? $record?->albumLoveImageUrl())
            ->default($default)
            ->columnSpanFull();
    }

    private static function isSelectedTemplate(Get $get, string $viewPath): bool
    {
        if ($get('template_view') === $viewPath) {
            return true;
        }

        $templateId = $get('template_id');

        return $templateId
            && Template::query()->whereKey($templateId)->value('view_path') === $viewPath;
    }
}
