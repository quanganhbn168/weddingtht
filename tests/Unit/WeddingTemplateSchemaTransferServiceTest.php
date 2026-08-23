<?php

namespace Tests\Unit;

use App\Services\WeddingTemplateSchemaTransferService;
use Tests\TestCase;

class WeddingTemplateSchemaTransferServiceTest extends TestCase
{
    public function test_schema_import_rejects_malformed_or_unsafe_template_data(): void
    {
        $service = app(WeddingTemplateSchemaTransferService::class);

        $this->expectExceptionMessage('File schema không phải JSON hợp lệ.');
        $service->importJson('{this is not json}');
    }

    public function test_schema_import_requires_the_weddingtht_manifest_format(): void
    {
        $service = app(WeddingTemplateSchemaTransferService::class);

        $this->expectExceptionMessage('File không đúng định dạng schema của WeddingTHT.');
        $service->importJson(json_encode(['templates' => []], JSON_THROW_ON_ERROR));
    }
}
