<?php

namespace Tests\Unit;

use App\Models\Template;
use App\Models\Wedding;
use App\Services\WeddingDataService;
use App\Services\WeddingTemplateContentService;
use App\Services\WeddingTemplateSchemaRegistry;
use Carbon\Carbon;
use Tests\TestCase;

class WeddingTemplateContentServiceTest extends TestCase
{
    public function test_admin_defined_template_schema_is_normalized_without_php_registration(): void
    {
        $template = new Template([
            'name' => 'THT E-Wedding 19',
            'view_path' => 'templates.tht_e_wedding_19',
            'content_schema' => [
                [
                    'section' => 'Lời ngỏ',
                    'key' => 'couple_quote',
                    'label' => 'Câu trích dẫn',
                    'type' => 'textarea',
                    'rows' => 4,
                    'required' => true,
                ],
                [
                    'section' => 'Lời ngỏ',
                    'key' => 'guest_tone',
                    'label' => 'Cách xưng hô',
                    'type' => 'select',
                    'options' => "than_mat|Thân mật\ntrang_trong|Trang trọng",
                ],
                ['key' => 'Tên không hợp lệ'],
            ],
        ]);

        $fields = WeddingTemplateSchemaRegistry::fieldsForTemplate($template);

        $this->assertSame('templates.tht_e_wedding_19', WeddingTemplateSchemaRegistry::contentPath($template));
        $this->assertSame(['couple_quote', 'guest_tone'], array_column($fields, 'key'));
        $this->assertSame(['than_mat' => 'Thân mật', 'trang_trong' => 'Trang trọng'], $fields[1]['options']);
    }

    public function test_the_template_18_hero_uses_the_local_assets_supplied_for_it(): void
    {
        $template = file_get_contents(resource_path('views/templates/tht_e_wedding_18.blade.php'));
        $stylesheet = file_get_contents(resource_path('css/templates/tht-e-wedding-18.css'));

        $this->assertStringContainsString('class="tht18-hero__media"', $template);
        $this->assertStringContainsString('src="{{ $heroUrl }}"', $template);
        $this->assertStringNotContainsString('tht18-hero__floral', $template);
        $this->assertStringContainsString("url('/images/templates/tht-e-wedding-18/hero-script.ttf')", $stylesheet);
        $this->assertStringContainsString("url('/images/templates/tht-e-wedding-18/ampersand-script.ttf')", $stylesheet);
        $this->assertStringContainsString('--tht18-red: rgb(80 8 8)', $stylesheet);
    }

    public function test_template_content_keeps_custom_values_without_injecting_display_defaults(): void
    {
        $wedding = new Wedding;
        $wedding->template_view = 'templates.tht_e_wedding_19';
        $wedding->setRelation('template', new Template([
            'view_path' => 'templates.tht_e_wedding_19',
            'content_schema' => [
                ['key' => 'couple_quote', 'label' => 'Câu trích dẫn', 'type' => 'textarea'],
                ['key' => 'guest_tone', 'label' => 'Cách xưng hô', 'type' => 'select'],
            ],
        ]));
        $wedding->content = [
            'templates' => [
                'tht_e_wedding_19' => [
                    'couple_quote' => 'Ngày mình về chung một nhà',
                    'story_title' => 'Không thuộc schema của mẫu',
                ],
            ],
        ];

        $content = WeddingTemplateContentService::for($wedding);

        $this->assertSame('Ngày mình về chung một nhà', $content['couple_quote']);
        $this->assertArrayNotHasKey('story_title', $content);
        $this->assertArrayNotHasKey('hero_kicker', $content);
        $this->assertArrayNotHasKey('hero_layout', $content);
        $this->assertNull($content['guest_tone']);
    }

    public function test_image_fields_are_template_schema_media_not_wedding_content(): void
    {
        $template = new Template([
            'view_path' => 'templates.tht_e_wedding_19',
            'content_schema' => [
                ['key' => 'story_hero', 'label' => 'Ảnh lớn', 'type' => 'image'],
                ['key' => 'story_details', 'label' => 'Ảnh nhỏ', 'type' => 'images', 'max_files' => 4],
                ['key' => 'story_quote', 'label' => 'Lời dẫn', 'type' => 'textarea'],
            ],
        ]);

        $fields = WeddingTemplateSchemaRegistry::fieldsForTemplate($template);
        $contentFields = WeddingTemplateSchemaRegistry::contentFieldsForTemplate($template);

        $this->assertSame('template_tht_e_wedding_19_story_hero', $fields[0]['collection']);
        $this->assertSame(4, $fields[1]['max_files']);
        $this->assertSame(['story_quote'], array_column($contentFields, 'key'));
    }

    public function test_template_18_invitation_uses_shared_families_and_the_real_love_album(): void
    {
        $template = file_get_contents(resource_path('views/templates/tht_e_wedding_18.blade.php'));

        $this->assertStringContainsString('Kính mời tham dự tiệc cưới thân mật', $template);
        $this->assertStringContainsString('$sideData->families', $template);
        $this->assertStringContainsString('$galleryImages->isNotEmpty()', $template);
        $this->assertStringContainsString('src="{{ $groomPhoto }}"', $template);
        $this->assertStringContainsString('src="{{ $bridePhoto }}"', $template);
        $this->assertStringContainsString("\$templateSchemaMedia['love_story_main_image']", $template);
        $this->assertStringContainsString("\$templateSchemaMedia['love_story_detail_images']", $template);
        $this->assertStringContainsString("\$templateSchemaMedia['calendar_background']", $template);
        $this->assertStringContainsString('$thankYouImage', $template);
        $this->assertStringContainsString('$event->receptionMapUrl', $template);
        $this->assertStringContainsString('$event->receptionLunarInWords', $template);
        $this->assertStringNotContainsString('show_love_story', $template);
        $this->assertStringNotContainsString('$templateContent[', $template);
    }

    public function test_template_18_seed_defines_love_story_and_calendar_as_private_schema_media(): void
    {
        $seeder = file_get_contents(database_path('seeders/TemplateSeeder.php'));

        $this->assertStringContainsString("'key' => 'love_story_main_image'", $seeder);
        $this->assertStringContainsString("'key' => 'love_story_detail_images'", $seeder);
        $this->assertStringContainsString("'max_files' => 4", $seeder);
        $this->assertStringContainsString("'key' => 'calendar_background'", $seeder);
    }

    public function test_calendar_data_uses_the_two_reception_dates_as_highlights(): void
    {
        $wedding = new Wedding;
        $wedding->event_date = Carbon::parse('2026-03-07');
        $wedding->bride_reception_date = Carbon::parse('2026-03-06');
        $wedding->groom_reception_date = Carbon::parse('2026-03-07');

        $data = WeddingDataService::prepare($wedding);

        $this->assertSame('March 2026', $data['calendarMonthLabel']);
        $this->assertSame(['2026-03-06', '2026-03-07'], $data['calendarHighlightedDates']);
        $this->assertCount(6, $data['calendarWeeks']);
    }

    public function test_templates_without_admin_defined_fields_do_not_receive_template_specific_content(): void
    {
        $wedding = new Wedding;
        $wedding->template_view = 'templates.tht_e_wedding_17';
        $wedding->setRelation('template', new Template([
            'view_path' => 'templates.tht_e_wedding_17',
            'content_schema' => [],
        ]));

        $this->assertSame([], WeddingTemplateContentService::for($wedding));
    }
}
