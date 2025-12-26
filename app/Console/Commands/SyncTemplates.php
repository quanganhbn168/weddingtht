<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\File;

class SyncTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templates:sync {--force : Force refresh all templates}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan template files and sync to database';

    /**
     * Template configurations
     */
    private array $templateConfig = [
        // Wedding templates - Basic
        'templates.modern_01' => [
            'name' => 'Modern Style (Hồng Phấn Hiện Đại)',
            'type' => 'wedding',
            'tier' => 'basic',
        ],
        'templates.elegant_02' => [
            'name' => 'Elegant Classic (Thanh Lịch Cổ Điển)',
            'type' => 'wedding',
            'tier' => 'basic',
        ],
        'templates.minimal_03' => [
            'name' => 'Minimal Editorial (Tối Giản Tạp Chí)',
            'type' => 'wedding',
            'tier' => 'basic',
        ],
        'templates.luxury_gold' => [
            'name' => 'Luxury Gold (Vàng Sang Trọng)',
            'type' => 'wedding',
            'tier' => 'basic',
        ],
        'templates.traditional_red' => [
            'name' => 'Traditional Red (Đỏ Truyền Thống)',
            'type' => 'wedding',
            'tier' => 'basic',
        ],
        
        // Wedding templates - Premium (Pro)
        'templates.cherry_blossom' => [
            'name' => '🌸 Cherry Blossom (Hoa Anh Đào)',
            'type' => 'wedding',
            'tier' => 'pro',
        ],
        'templates.cinematic_story' => [
            'name' => '🎬 Cinematic Story (Phim Điện Ảnh)',
            'type' => 'wedding',
            'tier' => 'pro',
        ],
        'templates.galaxy_dreams' => [
            'name' => '✨ Galaxy Dreams (Ngân Hà Lung Linh)',
            'type' => 'wedding',
            'tier' => 'pro',
        ],
        
        // Business templates
        'templates.business.minimal_white' => [
            'name' => 'Minimal White',
            'type' => 'business',
            'tier' => 'basic',
        ],
        'templates.business.tech_gradient' => [
            'name' => 'Tech Gradient',
            'type' => 'business',
            'tier' => 'basic',
        ],
        'templates.business.creative_dark' => [
            'name' => 'Creative Dark',
            'type' => 'business',
            'tier' => 'basic',
        ],
        'templates.business.corporate_blue' => [
            'name' => 'Corporate Blue',
            'type' => 'business',
            'tier' => 'basic',
        ],
        'templates.business.luxury_gold' => [
            'name' => 'Luxury Gold',
            'type' => 'business',
            'tier' => 'basic',
        ],
        'templates.business.simple_card' => [
            'name' => 'Simple Card',
            'type' => 'business',
            'tier' => 'basic',
        ],
        'templates.business.ceo_profile' => [
            'name' => 'CEO Profile',
            'type' => 'business',
            'tier' => 'basic',
        ],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Syncing templates to database...');
        
        $created = 0;
        $updated = 0;
        $skipped = 0;
        
        foreach ($this->templateConfig as $viewPath => $config) {
            // Check if view file exists
            $bladeFile = str_replace('.', '/', $viewPath) . '.blade.php';
            $fullPath = resource_path('views/' . $bladeFile);
            
            if (!File::exists($fullPath)) {
                $this->warn("⚠️  File not found: {$bladeFile}");
                continue;
            }
            
            // Try to extract name from template comment if available
            $templateName = $this->extractTemplateName($fullPath) ?? $config['name'];
            
            // Check if template exists
            $template = Template::where('view_path', $viewPath)->first();
            
            if ($template) {
                if ($this->option('force')) {
                    $template->update([
                        'name' => $templateName,
                        'type' => $config['type'],
                        'tier' => $config['tier'],
                    ]);
                    $this->line("✏️  Updated: {$templateName}");
                    $updated++;
                } else {
                    // Only update tier if needed
                    if ($template->tier !== $config['tier']) {
                        $template->update(['tier' => $config['tier']]);
                        $this->line("🏷️  Updated tier: {$templateName} -> {$config['tier']}");
                        $updated++;
                    } else {
                        $skipped++;
                    }
                }
            } else {
                Template::create([
                    'name' => $templateName,
                    'view_path' => $viewPath,
                    'type' => $config['type'],
                    'tier' => $config['tier'],
                    'is_active' => true,
                ]);
                $this->line("✅ Created: {$templateName}");
                $created++;
            }
        }
        
        $this->newLine();
        $this->info("📊 Summary: {$created} created, {$updated} updated, {$skipped} skipped");
        $this->info("🎉 Templates sync completed!");
        
        return Command::SUCCESS;
    }
    
    /**
     * Extract template name from blade file comment
     */
    private function extractTemplateName(string $filePath): ?string
    {
        $content = File::get($filePath);
        
        // Look for pattern: {{-- Template Name: Name Here --}}
        if (preg_match('/{{--\s*Template Name:\s*([^-]+)\s*--}}/i', $content, $matches)) {
            return trim($matches[1]);
        }
        
        return null;
    }
}
