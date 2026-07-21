<?php

namespace Tests\Feature;

use Tests\TestCase;

class WeddingTemplateStandardTest extends TestCase
{
    public function test_v17_contract_templates_keep_the_shared_wedding_baseline(): void
    {
        $templateFiles = glob(resource_path('views/templates/*.blade.php')) ?: [];
        $contractTemplates = [];

        foreach ($templateFiles as $templateFile) {
            $contents = file_get_contents($templateFile);

            if (! str_contains($contents, 'Contract: v17')) {
                continue;
            }

            $template = basename($templateFile, '.blade.php');
            $contractTemplates[] = $template;
            $stylesheet = str_replace('_', '-', $template);

            $this->assertStringContainsString('{{-- Template Name:', $contents, "{$template} needs template metadata.");
            $this->assertStringContainsString('{{-- Type: wedding --}}', $contents, "{$template} must be a wedding template.");
            $this->assertStringContainsString("resources/css/templates/{$stylesheet}.css", $contents, "{$template} must load its own CSS.");
            $this->assertFileExists(resource_path("css/templates/{$stylesheet}.css"), "{$template} CSS file is missing.");

            $this->assertStringContainsString('$sideData->firstName', $contents, "{$template} must use side-aware names.");
            $this->assertStringContainsString('$sideData->events', $contents, "{$template} must use side-aware events.");
            $this->assertStringContainsString('$event->receptionDate', $contents, "{$template} must render reception dates from the event DTO.");
            $this->assertStringContainsString('$event->ceremonyDate', $contents, "{$template} must render ceremony dates from the event DTO.");
            $this->assertStringContainsString('$wedding->event_date', $contents, "{$template} must use the primary wedding date.");
            $this->assertTrue(
                str_contains($contents, "<x-wedding.rsvp-form :wedding=\"\$wedding\" />")
                || str_contains($contents, "route('wedding.rsvp.store', \$wedding->slug)"),
                "{$template} must include an RSVP form."
            );
            $this->assertStringContainsString('<x-wedding.countdown-script />', $contents, "{$template} must include the shared countdown script.");

            $this->assertStringNotContainsString('@php', $contents, "{$template} cannot prepare data in Blade.");
            $this->assertStringNotContainsString('now()', $contents, "{$template} cannot use the current time as wedding data.");
            $this->assertStringNotContainsString('$solar', $contents, "{$template} cannot use legacy date data.");
            $this->assertStringNotContainsString('$imgs', $contents, "{$template} cannot use legacy gallery data.");
            $this->assertStringNotContainsString('$placeholders', $contents, "{$template} cannot use placeholder images.");

            $this->assertNotEmpty(config("wedding-themes.{$template}"), "{$template} needs a theme definition.");
        }

        $this->assertNotEmpty($contractTemplates, 'At least one template must exercise the v17 contract.');

        $viteConfig = file_get_contents(base_path('vite.config.js'));
        $templateSeeder = file_get_contents(database_path('seeders/TemplateSeeder.php'));

        foreach ($contractTemplates as $template) {
            $stylesheet = str_replace('_', '-', $template);
            $viewPath = "templates.{$template}";

            $this->assertStringContainsString("resources/css/templates/{$stylesheet}.css", $viteConfig, "{$template} CSS must be a Vite entry.");
            $this->assertStringContainsString($viewPath, $templateSeeder, "{$template} must be available in a fresh database.");
        }
    }

    public function test_v17_before_slider_is_a_five_image_template_media_collection(): void
    {
        $mediaSchemas = config('wedding-template-media', []);
        $fields = collect($mediaSchemas['templates.tht_e_wedding_17']['fields'] ?? []);
        $beforeSlider = $fields->firstWhere('collection', 'before_slider');

        $this->assertNotNull($beforeSlider);
        $this->assertTrue($beforeSlider['multiple']);
        $this->assertTrue($beforeSlider['reorderable']);
        $this->assertSame(5, $beforeSlider['max_files']);
    }

    public function test_v17_footer_uses_the_dedicated_thank_you_image(): void
    {
        $contents = file_get_contents(resource_path('views/templates/tht_e_wedding_17.blade.php'));

        $this->assertStringContainsString('@if($thankYouImage)', $contents);
        $this->assertStringContainsString('<img src="{{ $thankYouImage }}"', $contents);
    }
}
