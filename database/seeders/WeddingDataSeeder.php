<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;
use App\Models\Wedding;
use App\Enums\WeddingTier;
use App\Enums\WeddingStatus;
use App\Enums\FallingEffect;

class WeddingDataSeeder extends Seeder
{
    public function run(): void
    {
        $eventDate = now()->addDays(60)->format('Y-m-d');

        $weddings = [
            ['groom_name' => 'Minh Quang', 'bride_name' => 'Thu Hà',   'slug' => 'minh-quang-thu-ha-2025',   'view' => 'templates.modern_01',       'tier' => WeddingTier::STANDARD, 'effect' => FallingEffect::HEARTS],
            ['groom_name' => 'Đức Long',   'bride_name' => 'Ngọc Ánh', 'slug' => 'duc-long-ngoc-anh-2025',   'view' => 'templates.elegant_02',      'tier' => WeddingTier::STANDARD, 'effect' => FallingEffect::HEARTS],
            ['groom_name' => 'Hoàng Anh',  'bride_name' => 'Minh Châu','slug' => 'hoang-anh-minh-chau-2025', 'view' => 'templates.minimal_03',      'tier' => WeddingTier::STANDARD, 'effect' => FallingEffect::HEARTS],
            ['groom_name' => 'Văn Hùng',   'bride_name' => 'Thanh Tâm','slug' => 'van-hung-thanh-tam-2025',  'view' => 'templates.traditional_red', 'tier' => WeddingTier::STANDARD, 'effect' => FallingEffect::HEARTS],
            ['groom_name' => 'Quốc Bảo',   'bride_name' => 'Kim Ngân', 'slug' => 'quoc-bao-kim-ngan-2025',   'view' => 'templates.luxury_gold',     'tier' => WeddingTier::PRO,      'effect' => FallingEffect::STARS],
            ['groom_name' => 'Nhật Minh',  'bride_name' => 'Thảo Nhi', 'slug' => 'nhat-minh-thao-nhi-2025', 'view' => 'templates.cherry_blossom',  'tier' => WeddingTier::PRO,      'effect' => FallingEffect::PETALS],
            ['groom_name' => 'Tuấn Kiệt',  'bride_name' => 'Phương Thảo','slug' => 'tuan-kiet-phuong-thao-2025','view' => 'templates.galaxy_dreams','tier' => WeddingTier::PRO,   'effect' => FallingEffect::SHOOTING_STARS],
            ['groom_name' => 'Anh Tú',     'bride_name' => 'Thu Ngần', 'slug' => 'anh-tu-thu-ngan-2025',     'view' => 'templates.romantic_scroll', 'tier' => WeddingTier::PRO,      'effect' => FallingEffect::HEARTS],
        ];

        foreach ($weddings as $w) {
            $template = Template::where('view_path', $w['view'])->first();
            if (!$template) {
                $this->command->warn("⚠ Template not found: {$w['view']}");
                continue;
            }

            Wedding::updateOrCreate(
                ['slug' => $w['slug']],
                [
                    'groom_name'            => $w['groom_name'],
                    'bride_name'            => $w['bride_name'],
                    'template_id'           => $template->id,
                    'template_view'         => $w['view'],
                    'tier'                  => $w['tier'],
                    'falling_effect'        => $w['effect'],
                    'event_date'            => $eventDate,
                    'groom_father'          => 'Ông Nguyễn Văn Hùng',
                    'groom_mother'          => 'Bà Lê Thị Lan',
                    'groom_address'         => 'Số 123, Phố Huế, Hai Bà Trưng, Hà Nội',
                    'groom_ceremony_time'   => '09:00:00',
                    'groom_reception_time'  => '11:00:00',
                    'groom_reception_venue' => 'Nhà hàng Riverside Palace, Hà Nội',
                    'groom_map_url'         => 'https://maps.google.com',
                    'bride_father'          => 'Ông Trần Văn Minh',
                    'bride_mother'          => 'Bà Phạm Thị Huệ',
                    'bride_address'         => 'Số 456, Đường Láng, Đống Đa, Hà Nội',
                    'bride_ceremony_time'   => '09:00:00',
                    'bride_reception_time'  => '11:00:00',
                    'bride_reception_venue' => 'Khách sạn Mường Thanh Grand, Hà Nội',
                    'bride_map_url'         => 'https://maps.google.com',
                    'status'                => WeddingStatus::PUBLISHED,
                    'is_active'             => true,
                    'is_demo'               => true,
                    'show_preload'          => true,
                    'content'               => [
                        'message'           => 'Trân trọng kính mời Quý khách tham dự tiệc cưới.',
                        'countdown_enabled' => true,
                        'music_enabled'     => true,
                    ],
                ]
            );

            $this->command->info("✓ {$w['groom_name']} & {$w['bride_name']}");
        }

        $this->command->info('✅ Wedding data seeded!');
    }
}
