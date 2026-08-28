<?php

namespace App\Services;

use App\Filament\Forms\Components\GalleryMediaUpload;
use App\Models\Template;
use App\Models\Wedding;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Illuminate\Support\Str;

class WeddingTemplateSchemaRegistry
{
    /**
     * Schema is owned by the Template record, so new templates can be configured
     * from Admin without adding a PHP class or changing a config registry.
     */
    public static function forViewPath(?string $viewPath, ?Template $loadedTemplate = null): ?Template
    {
        if (blank($viewPath)) {
            return null;
        }

        if ($loadedTemplate?->view_path === $viewPath) {
            return $loadedTemplate;
        }

        return Template::query()->where('view_path', $viewPath)->first();
    }

    /** @return array<int, array<string, mixed>> */
    public static function fieldsForTemplate(?Template $template): array
    {
        return collect($template?->content_schema ?? [])
            ->filter(fn (mixed $field): bool => is_array($field) && filled($field['key'] ?? null))
            ->map(function (array $field) use ($template): array {
                $type = $field['type'] ?? 'text';
                $allowedTypes = ['text', 'textarea', 'select', 'toggle', 'number', 'url', 'date', 'image', 'images'];

                return [
                    'key' => (string) $field['key'],
                    'label' => filled($field['label'] ?? null) ? (string) $field['label'] : (string) $field['key'],
                    'section' => filled($field['section'] ?? null) ? (string) $field['section'] : 'Dữ liệu riêng',
                    'type' => in_array($type, $allowedTypes, true) ? $type : 'text',
                    'helper_text' => filled($field['helper_text'] ?? null) ? (string) $field['helper_text'] : null,
                    'required' => (bool) ($field['required'] ?? false),
                    'max_length' => filled($field['max_length'] ?? null) ? (int) $field['max_length'] : null,
                    'rows' => filled($field['rows'] ?? null) ? max(2, (int) $field['rows']) : 3,
                    'options' => self::optionsFor($field['options'] ?? []),
                    'collection' => self::mediaCollection($template, (string) $field['key']),
                    'aspect_ratio' => filled($field['aspect_ratio'] ?? null) ? (string) $field['aspect_ratio'] : null,
                    'max_files' => filled($field['max_files'] ?? null) ? max(1, (int) $field['max_files']) : null,
                ];
            })
            ->filter(fn (array $field): bool => preg_match('/^[a-z][a-z0-9_]*$/', $field['key']) === 1)
            ->unique('key')
            ->values()
            ->all();
    }

    public static function contentPath(Template $template): string
    {
        $templateKey = Str::of($template->view_path)
            ->after('templates.')
            ->replace('.', '_')
            ->toString();

        return "templates.{$templateKey}";
    }

    public static function mediaCollection(Template $template, string $fieldKey): string
    {
        $templateKey = Str::of($template->view_path)
            ->after('templates.')
            ->replace('.', '_')
            ->replace('-', '_')
            ->toString();

        return "template_{$templateKey}_{$fieldKey}";
    }

    /** @return array<int, array<string, mixed>> */
    public static function contentFieldsForTemplate(?Template $template): array
    {
        return array_values(array_filter(
            self::fieldsForTemplate($template),
            fn (array $field): bool => ! self::isMediaField($field),
        ));
    }

    /** @return array<string, mixed> */
    public static function mediaForWedding(?Template $template, Wedding $wedding): array
    {
        if (! $template) {
            return [];
        }

        return collect(self::fieldsForTemplate($template))
            ->filter(fn (array $field): bool => self::isMediaField($field))
            ->mapWithKeys(function (array $field) use ($wedding): array {
                $media = $wedding->getMedia($field['collection']);

                return [$field['key'] => $field['type'] === 'images' ? $media : $media->first()];
            })
            ->all();
    }

    /** @return array<int, Section> */
    public static function formSections(): array
    {
        return Template::query()
            ->whereNotNull('content_schema')
            ->get()
            ->flatMap(function (Template $template): array {
                $fields = self::fieldsForTemplate($template);

                if ($fields === []) {
                    return [];
                }

                return collect($fields)
                    ->groupBy('section')
                    ->map(function ($sectionFields, string $section) use ($template): Section {
                        return Section::make("{$template->name} · {$section}")
                            ->columns(1)
                            ->schema(
                                $sectionFields
                                    ->map(fn (array $field): Component => self::formComponent($template, $field))
                                    ->all(),
                            )
                            ->visible(fn (Get $get): bool => self::isSelectedTemplate($get, $template));
                    })
                    ->values()
                    ->all();
            })
            ->all();
    }

    /** @param array<string, mixed> $field */
    private static function formComponent(Template $template, array $field): Component
    {
        if (self::isMediaField($field)) {
            $upload = ($field['type'] === 'images' ? GalleryMediaUpload::make($field['key']) : SpatieMediaLibraryFileUpload::make($field['key']))
                ->label($field['label'])
                ->collection($field['collection'])
                ->disk('public')
                ->image();

            if ($field['type'] === 'images') {
                $upload->multiple()->reorderable();
            }

            if ($field['max_files']) {
                $upload->maxFiles($field['max_files']);
            }

            if ($field['helper_text']) {
                $upload->helperText($field['helper_text']);
            }

            return $upload;
        }

        $path = self::contentPath($template).'.'.$field['key'];

        $component = match ($field['type']) {
            'textarea' => Textarea::make($path)->rows($field['rows']),
            'select' => Select::make($path)->options($field['options'])->native(false),
            'toggle' => Toggle::make($path),
            'number' => TextInput::make($path)->numeric(),
            'url' => TextInput::make($path)->url(),
            'date' => DatePicker::make($path),
            default => TextInput::make($path),
        };

        $component->label($field['label']);

        if ($field['helper_text']) {
            $component->helperText($field['helper_text']);
        }

        if ($field['required']) {
            $component->required();
        }

        if ($field['max_length'] && method_exists($component, 'maxLength')) {
            $component->maxLength($field['max_length']);
        }

        return $component;
    }

    /** @return array<string, string> */
    private static function optionsFor(mixed $options): array
    {
        if (is_array($options)) {
            return collect($options)
                ->mapWithKeys(fn (mixed $label, mixed $key): array => [(string) $key => (string) $label])
                ->all();
        }

        return collect(preg_split('/\R/u', (string) $options) ?: [])
            ->map(fn (string $option): array => array_map(trim(...), explode('|', $option, 2)))
            ->filter(fn (array $option): bool => filled($option[0] ?? null))
            ->mapWithKeys(fn (array $option): array => [$option[0] => $option[1] ?? $option[0]])
            ->all();
    }

    private static function isSelectedTemplate(Get $get, Template $template): bool
    {
        if ($get('template_view') === $template->view_path) {
            return true;
        }

        return (int) $get('template_id') === $template->getKey();
    }

    /** @param array<string, mixed> $field */
    private static function isMediaField(array $field): bool
    {
        return in_array($field['type'], ['image', 'images'], true);
    }
}
