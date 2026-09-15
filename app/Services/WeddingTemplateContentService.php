<?php

namespace App\Services;

use App\Models\Wedding;

class WeddingTemplateContentService
{
    /** @return array<string, mixed> */
    public static function for(Wedding $wedding): array
    {
        // Match WeddingController: the selected Template relation owns the rendered view.
        // Fall back to the legacy template_view column for older records without template_id.
        $template = $wedding->template
            ?: WeddingTemplateSchemaRegistry::forViewPath($wedding->template_view);

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
