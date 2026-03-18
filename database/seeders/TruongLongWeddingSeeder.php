<?php

namespace Database\Seeders;

use App\Models\Wedding;
use App\Models\Template;
use Illuminate\Database\Seeder;

class TruongLongWeddingSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure template exists
        $template = Template::firstOrCreate(
            ['view_path' => 'templates.da05_vip'],
            [
                'name' => 'DA05 VIP (MeHappy)',
                'type' => 'wedding',
                'required_tier' => 'pro',
                'is_active' => true,
                'thumbnail_url' => null,
            ]
        );

        // Create or update wedding
        Wedding::updateOrCreate(
            ['slug' => 'truong-long-va-thu-tra-29-03-2026'],
            [
                'user_id' => 1,
                'type' => 'wedding',
                'template_id' => $template->id,
                'groom_name' => 'Trường Long',
                'bride_name' => 'Thu Trà',
                'event_date' => '2026-03-29',
                'event_date_lunar' => '11/02 Bính Ngọ',

                // Groom family
                'groom_father' => 'Hoàng Xuân Giao',
                'groom_mother' => 'Nguyễn Thị Nhẫn',
                'groom_address' => 'Số 63, Tổ dân phố 1, Quế Võ, Bắc Ninh',

                // Groom ceremony & reception
                'groom_ceremony_date' => '2026-03-29',
                'groom_ceremony_time' => '07:30',
                'groom_reception_time' => '09:00',
                'groom_reception_venue' => 'Nhà hàng Hương Núi',
                'groom_reception_address' => 'Quốc lộ 18, Phương Liễu, Quế Võ, Bắc Ninh',
                'groom_map_url' => 'https://maps.app.goo.gl/zR6bwM8r7RUKUzxLA',
                'groom_qr_info' => "MB Bank\n8555556666868\nHoàng Trường Long",

                // Bride family
                'bride_father' => 'Nguyễn Văn Thọ',
                'bride_mother' => 'Nguyễn Thị Hòa',
                'bride_address' => 'Tổ dân phố Yên Lâm, Quế Võ, Bắc Ninh',

                // Bride ceremony & reception
                'bride_ceremony_date' => '2026-03-29',
                'bride_ceremony_time' => '06:30',
                'bride_reception_time' => '15:00',
                'bride_reception_venue' => 'Tư gia nhà gái',
                'bride_reception_address' => 'Tổ dân phố Yên Lâm, Quế Võ, Bắc Ninh',
                'bride_map_url' => 'https://maps.app.goo.gl/r94diqak6VaBidT29',
                'bride_qr_info' => "Vietcombank\n1014222060\nNguyễn Thị Thu Trà",

                // Template & display
                'template_view' => 'templates.da05_vip',
                'status' => 'published',
                'tier' => 'pro',
                'is_demo' => false,
                'falling_effect' => 'hearts',
                'preload_variant' => 'heartbeat',
                'show_invitation_wrapper' => true,
                'show_preload' => false,
                'can_share' => true,
                'is_auto_approve_wishes' => false,
                'is_active' => true,

                // Content (love story, etc.)
                'content' => [
                    'love_story' => [
                        [
                            'year' => '2020',
                            'title' => 'Lần đầu gặp gỡ',
                            'description' => 'Chúng mình gặp nhau lần đầu và ấn tượng ngay từ cái nhìn đầu tiên.',
                        ],
                        [
                            'year' => '2021',
                            'title' => 'Yêu nhau',
                            'description' => 'Từ bạn bè, chúng mình trở thành người yêu và bắt đầu hành trình bên nhau.',
                        ],
                        [
                            'year' => '2024',
                            'title' => 'Cầu hôn',
                            'description' => 'Anh đã cầu hôn và em đã đồng ý! Chúng mình sẽ bên nhau mãi mãi.',
                        ],
                        [
                            'year' => '2025',
                            'title' => 'Đám cưới',
                            'description' => 'Ngày trọng đại đã đến! Cảm ơn mọi người đã đến chung vui cùng chúng mình.',
                        ],
                    ],
                    'blessing_desc' => 'Sự hiện diện và lời chúc phúc của bạn là niềm hạnh phúc lớn nhất của chúng tôi.',
                ],
            ]
        );

        $this->command->info('✅ Wedding "Trường Long & Thu Trà" created/updated successfully!');
    }
}
