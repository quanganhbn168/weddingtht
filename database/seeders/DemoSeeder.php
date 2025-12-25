<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;
use App\Models\BusinessCard;
use App\Models\Wedding;
use App\Models\User;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds to create demo data for all templates.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting Demo Seeder...');
        
        $this->seedAdminUser();
        $this->seedTemplates();
        $this->seedBusinessCards();
        $this->seedWeddings();
        
        $this->command->info('✅ Demo Seeder completed successfully!');
    }

    /**
     * Seed admin user
     */
    private function seedAdminUser(): void
    {
        $this->command->info('👤 Seeding Admin User...');

        User::updateOrCreate(
            ['email' => 'quanganhadmin@thtmedia.com.vn'],
            [
                'name' => 'Quang Anh Admin',
                'password' => 'admin123@', // Will be auto-hashed by User model
            ]
        );

        $this->command->info('   ✓ Admin user created: quanganhadmin@thtmedia.com.vn');
    }

    /**
     * Seed all templates (wedding + business)
     */
    private function seedTemplates(): void
    {
        $this->command->info('📋 Seeding Templates...');

        // Wedding Templates
        $weddingTemplates = [
            ['name' => 'Modern 01', 'view_path' => 'templates.modern_01', 'type' => 'wedding'],
            ['name' => 'Elegant 02', 'view_path' => 'templates.elegant_02', 'type' => 'wedding'],
            ['name' => 'Minimal 03', 'view_path' => 'templates.minimal_03', 'type' => 'wedding'],
            ['name' => 'Traditional Red', 'view_path' => 'templates.traditional_red', 'type' => 'wedding'],
            ['name' => 'Luxury Gold Wedding', 'view_path' => 'templates.luxury_gold', 'type' => 'wedding'],
        ];

        // Business Card Templates
        $businessTemplates = [
            ['name' => 'CEO Profile', 'view_path' => 'templates.business.ceo_profile', 'type' => 'business'],
            ['name' => 'Luxury Gold', 'view_path' => 'templates.business.luxury_gold', 'type' => 'business'],
            ['name' => 'Minimal White', 'view_path' => 'templates.business.minimal_white', 'type' => 'business'],
            ['name' => 'Corporate Blue', 'view_path' => 'templates.business.corporate_blue', 'type' => 'business'],
            ['name' => 'Creative Dark', 'view_path' => 'templates.business.creative_dark', 'type' => 'business'],
            ['name' => 'Tech Gradient', 'view_path' => 'templates.business.tech_gradient', 'type' => 'business'],
            ['name' => 'Simple Card', 'view_path' => 'templates.business.simple_card', 'type' => 'business'],
        ];

        foreach (array_merge($weddingTemplates, $businessTemplates) as $template) {
            Template::updateOrCreate(
                ['view_path' => $template['view_path']],
                array_merge($template, ['is_active' => true])
            );
        }

        $this->command->info('   ✓ ' . count($weddingTemplates) . ' wedding templates created');
        $this->command->info('   ✓ ' . count($businessTemplates) . ' business templates created');
    }

    /**
     * Seed Business Cards with demo data
     */
    private function seedBusinessCards(): void
    {
        $this->command->info('💼 Seeding Business Cards...');

        $demoCards = [
            // CEO Profile
            [
                'name' => 'Nguyễn Văn An',
                'slug' => 'nguyen-van-an',
                'title' => 'Giám đốc điều hành',
                'company' => 'THT Media',
                'about' => 'Hơn 15 năm kinh nghiệm trong lĩnh vực truyền thông và marketing số. Đam mê xây dựng thương hiệu và phát triển doanh nghiệp bền vững.',
                'phone' => '0965625210',
                'email' => 'an.nguyen@thtmedia.com.vn',
                'website' => 'https://thtmedia.com.vn',
                'address' => 'Tầng 5, Tòa nhà ABC, 123 Nguyễn Huệ, Quận 1, TP.HCM',
                'template_view' => 'templates.business.ceo_profile',
            ],
            // Luxury Gold
            [
                'name' => 'Trần Quang Anh',
                'slug' => 'tran-quang-anh',
                'title' => 'Chủ tịch HĐQT',
                'company' => 'Gold Invest Group',
                'about' => 'Chuyên gia tài chính với hơn 20 năm kinh nghiệm trong lĩnh vực đầu tư và bất động sản cao cấp.',
                'phone' => '0912345678',
                'email' => 'anh.tran@goldinvest.vn',
                'website' => 'https://goldinvest.vn',
                'address' => 'Tầng 28, Landmark 81, Q.Bình Thạnh, TP.HCM',
                'template_view' => 'templates.business.luxury_gold',
            ],
            // Minimal White
            [
                'name' => 'Lê Minh Tú',
                'slug' => 'le-minh-tu',
                'title' => 'Creative Director',
                'company' => 'Studio Minimal',
                'about' => 'Nghệ sĩ thị giác theo đuổi chủ nghĩa tối giản. Tin rằng vẻ đẹp nằm ở sự đơn giản.',
                'phone' => '0901234567',
                'email' => 'tu.le@studiominimal.vn',
                'website' => 'https://studiominimal.vn',
                'address' => '42 Nguyễn Đình Chiểu, Quận 3, TP.HCM',
                'template_view' => 'templates.business.minimal_white',
            ],
            // Corporate Blue
            [
                'name' => 'Phạm Thị Hương',
                'slug' => 'pham-thi-huong',
                'title' => 'Giám đốc Nhân sự',
                'company' => 'BlueCorp Vietnam',
                'about' => 'Chuyên gia HR với 12 năm kinh nghiệm xây dựng văn hóa doanh nghiệp và phát triển nguồn nhân lực.',
                'phone' => '0987654321',
                'email' => 'huong.pham@bluecorp.vn',
                'website' => 'https://bluecorp.vn',
                'address' => 'Tầng 15, Bitexco Tower, Quận 1, TP.HCM',
                'template_view' => 'templates.business.corporate_blue',
            ],
            // Creative Dark
            [
                'name' => 'Đỗ Hoàng Nam',
                'slug' => 'do-hoang-nam',
                'title' => 'Motion Designer',
                'company' => 'Neon Studios',
                'about' => 'Đam mê tạo ra những chuyển động mê hoặc. Từ quảng cáo đến phim ngắn, mỗi khung hình là một câu chuyện.',
                'phone' => '0909888777',
                'email' => 'nam.do@neonstudios.vn',
                'website' => 'https://neonstudios.vn',
                'address' => 'Studio 301, Hẻm Sáng Tạo, 180 Lý Chính Thắng, Q.3',
                'template_view' => 'templates.business.creative_dark',
            ],
            // Tech Gradient
            [
                'name' => 'Vũ Đức Thành',
                'slug' => 'vu-duc-thanh',
                'title' => 'Senior Software Engineer',
                'company' => 'TechVN Solutions',
                'about' => 'Full-stack developer với chuyên môn về AI và Cloud Computing. Đóng góp cho nhiều dự án mã nguồn mở.',
                'phone' => '0977666555',
                'email' => 'thanh.vu@techvn.io',
                'website' => 'https://techvn.io',
                'address' => 'Tầng 10, E.Town Central, 11 Đoàn Văn Bơ, Q.4, TP.HCM',
                'template_view' => 'templates.business.tech_gradient',
            ],
            // Simple Card
            [
                'name' => 'Hoàng Thị Mai',
                'slug' => 'hoang-thi-mai',
                'title' => 'Business Analyst',
                'company' => 'Simple Corp',
                'about' => 'Chuyên phân tích nghiệp vụ và tối ưu hóa quy trình doanh nghiệp.',
                'phone' => '0966777888',
                'email' => 'mai.hoang@simplecorp.vn',
                'website' => 'https://simplecorp.vn',
                'address' => '56 Hai Bà Trưng, Hoàn Kiếm, Hà Nội',
                'template_view' => 'templates.business.simple_card',
            ],
        ];

        // Common content for all business cards
        $commonContent = [
            'services' => [
                ['icon' => 'fas fa-chart-line', 'title' => 'Tư vấn chiến lược', 'description' => 'Xây dựng chiến lược phát triển bền vững cho doanh nghiệp.'],
                ['icon' => 'fas fa-bullhorn', 'title' => 'Marketing số', 'description' => 'Giải pháp marketing toàn diện trên các nền tảng số.'],
                ['icon' => 'fas fa-users', 'title' => 'Đào tạo nhân sự', 'description' => 'Chương trình đào tạo nâng cao năng lực đội ngũ.'],
            ],
            'experience' => [
                ['year' => '2020 - Nay', 'title' => 'Giám đốc điều hành', 'company' => 'Công ty hiện tại', 'description' => 'Lãnh đạo đội ngũ 50+ nhân viên, tăng trưởng doanh thu 200%.'],
                ['year' => '2015 - 2020', 'title' => 'Trưởng phòng kinh doanh', 'company' => 'Công ty ABC', 'description' => 'Quản lý đội sales 20 người, đạt doanh số kỷ lục.'],
                ['year' => '2010 - 2015', 'title' => 'Chuyên viên tư vấn', 'company' => 'Công ty XYZ', 'description' => 'Tư vấn giải pháp cho hơn 100 khách hàng doanh nghiệp.'],
            ],
            'stats' => [
                ['number' => '15+', 'label' => 'Năm kinh nghiệm'],
                ['number' => '200+', 'label' => 'Dự án hoàn thành'],
                ['number' => '50+', 'label' => 'Đối tác tin cậy'],
                ['number' => '98%', 'label' => 'Khách hàng hài lòng'],
            ],
            'quote_text' => 'Thành công không phải là đích đến, mà là hành trình không ngừng vươn lên mỗi ngày.',
            'quote_author' => 'Phương châm sống',
        ];

        $commonSocialLinks = [
            ['platform' => 'facebook', 'url' => 'https://facebook.com', 'label' => 'Facebook'],
            ['platform' => 'linkedin', 'url' => 'https://linkedin.com', 'label' => 'LinkedIn'],
            ['platform' => 'website', 'url' => 'https://thtmedia.com.vn', 'label' => 'Website'],
        ];

        foreach ($demoCards as $cardData) {
            $template = Template::where('view_path', $cardData['template_view'])->first();
            
            if (!$template) {
                $this->command->warn("   ⚠ Template not found: {$cardData['template_view']}");
                continue;
            }

            BusinessCard::updateOrCreate(
                ['slug' => $cardData['slug']],
                [
                    'name' => $cardData['name'],
                    'title' => $cardData['title'],
                    'company' => $cardData['company'],
                    'about' => $cardData['about'],
                    'phone' => $cardData['phone'],
                    'email' => $cardData['email'],
                    'website' => $cardData['website'] ?? null,
                    'address' => $cardData['address'] ?? null,
                    'template_id' => $template->id,
                    'social_links' => $commonSocialLinks,
                    'content' => $commonContent,
                    'is_active' => true,
                ]
            );

            $this->command->info("   ✓ {$cardData['name']} ({$cardData['template_view']})");
        }
    }

    /**
     * Seed Weddings with demo data
     */
    private function seedWeddings(): void
    {
        $this->command->info('💒 Seeding Wedding Invitations...');

        $demoWeddings = [
            // Modern 01
            [
                'groom_name' => 'Minh Quang',
                'bride_name' => 'Thu Hà',
                'slug' => 'minh-quang-thu-ha-2025',
                'template_view' => 'templates.modern_01',
            ],
            // Elegant 02
            [
                'groom_name' => 'Đức Long',
                'bride_name' => 'Ngọc Ánh',
                'slug' => 'duc-long-ngoc-anh-2025',
                'template_view' => 'templates.elegant_02',
            ],
            // Minimal 03
            [
                'groom_name' => 'Hoàng Anh',
                'bride_name' => 'Minh Châu',
                'slug' => 'hoang-anh-minh-chau-2025',
                'template_view' => 'templates.minimal_03',
            ],
            // Traditional Red
            [
                'groom_name' => 'Văn Hùng',
                'bride_name' => 'Thanh Tâm',
                'slug' => 'van-hung-thanh-tam-2025',
                'template_view' => 'templates.traditional_red',
            ],
            // Luxury Gold Wedding
            [
                'groom_name' => 'Quốc Bảo',
                'bride_name' => 'Kim Ngân',
                'slug' => 'quoc-bao-kim-ngan-2025',
                'template_view' => 'templates.luxury_gold',
            ],
        ];

        foreach ($demoWeddings as $weddingData) {
            $template = Template::where('view_path', $weddingData['template_view'])->first();
            
            if (!$template) {
                $this->command->warn("   ⚠ Template not found: {$weddingData['template_view']}");
                continue;
            }

            Wedding::updateOrCreate(
                ['slug' => $weddingData['slug']],
                [
                    'groom_name' => $weddingData['groom_name'],
                    'bride_name' => $weddingData['bride_name'],
                    'template_id' => $template->id,
                    'template_view' => $weddingData['template_view'],
                    'event_date' => now()->addMonths(3)->format('Y-m-d'),
                    'groom_father' => 'Ông Nguyễn Văn A',
                    'groom_mother' => 'Bà Trần Thị B',
                    'bride_father' => 'Ông Lê Văn C',
                    'bride_mother' => 'Bà Phạm Thị D',
                    'groom_address' => 'Số 123, Đường ABC, Quận 1, TP.HCM',
                    'bride_address' => 'Số 456, Đường XYZ, Quận 3, TP.HCM',
                    'groom_ceremony_time' => '10:00:00',
                    'bride_ceremony_time' => '11:00:00',
                    'groom_reception_time' => '18:00:00',
                    'bride_reception_time' => '18:00:00',
                    'groom_reception_venue' => 'Trung tâm Hội nghị Palace',
                    'bride_reception_venue' => 'Nhà hàng Diamond',
                    'groom_reception_address' => '123 Nguyễn Huệ, Quận 1, TP.HCM',
                    'bride_reception_address' => '456 Lê Lợi, Quận 3, TP.HCM',
                    'status' => 'published',
                    'is_active' => true,
                    'content' => [
                        'message' => 'Trân trọng kính mời quý khách đến dự buổi lễ thành hôn của chúng tôi.',
                        'love_story' => 'Chúng tôi gặp nhau trong một buổi họp mặt bạn bè năm 2020. Từ cái nhìn đầu tiên, chúng tôi đã cảm nhận được điều đặc biệt. Sau 4 năm yêu nhau, chúng tôi quyết định về chung một nhà.',
                        'countdown_enabled' => true,
                        'music_enabled' => true,
                    ],
                ]
            );

            $this->command->info("   ✓ {$weddingData['groom_name']} & {$weddingData['bride_name']} ({$weddingData['template_view']})");
        }
    }
}
