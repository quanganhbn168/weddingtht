<?php

namespace App\Services;

use App\Models\Wedding;

class WeddingTemplateContentService
{
    /** @return array<string, mixed> */
    public static function for(Wedding $wedding): array
    {
        // template_view is stored alongside template_id and is the render source of truth.
        // Prefer it so a preview or a just-switched form never reads stale relation data.
        $viewPath = $wedding->template_view ?: $wedding->template?->view_path;
        $template = WeddingTemplateSchemaRegistry::forViewPath($viewPath, $wedding->template);

        if (! $template) {
            return [];
        }

        $fields = WeddingTemplateSchemaRegistry::contentFieldsForTemplate($template);

        if ($fields === []) {
            return [];
        }

        $storedContent = data_get(
            $wedding->content ?? [],
            WeddingTemplateSchemaRegistry::contentPath($template),
            [],
        );

        $contentKeys = array_flip(array_column($fields, 'key'));
        $storedContent = is_array($storedContent)
            ? array_intersect_key($storedContent, $contentKeys)
            : [];

        return array_replace(array_fill_keys(array_column($fields, 'key'), null), $storedContent);
    }
}
