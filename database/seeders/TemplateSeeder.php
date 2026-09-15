<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'THT E-Wedding 19 (Olive Memories)',
                'view_path' => 'templates.tht_e_wedding_19',
                'type' => 'wedding',
                'is_active' => true,
                'content_schema' => [
                    [
                        'key' => 'save_the_date_image',
                        'type' => 'image',
                        'label' => 'Ảnh Save the date',
                        'section' => 'Ảnh riêng của THT19',
                        'required' => false,
                        'helper_text' => 'Ảnh lớn giữa lời mời và thông tin gia đình. Để trống sẽ ẩn khối ảnh; không lấy ảnh hero/gallery thay thế.',
                        'aspect_ratio' => '6:5',
                    ],
                    [
                        'key' => 'timeline_image',
                        'type' => 'image',
                        'label' => 'Ảnh đầu phần Timeline',
                        'section' => 'Ảnh riêng của THT19',
                        'required' => false,
                        'helper_text' => 'Ảnh ngang hoặc vuông phía trên lịch trình. Để trống chỉ ẩn khối ảnh.',
                        'aspect_ratio' => '1:1',
                    ],
                    [
                        'key' => 'bride_portrait_note',
                        'type' => 'text',
                        'label' => 'Dòng phụ dưới tên cô dâu',
                        'section' => 'Chân dung',
                        'required' => false,
                        'max_length' => 100,
                    ],
                    [
                        'key' => 'groom_portrait_note',
                        'type' => 'text',
                        'label' => 'Dòng phụ dưới tên chú rể',
                        'section' => 'Chân dung',
                        'required' => false,
                        'max_length' => 100,
                    ],
                    [
                        'key' => 'hero_position',
                        'type' => 'select',
                        'label' => 'Vị trí lấy nét ảnh bìa',
                        'section' => 'Khung ảnh',
                        'options' => [
                            'top' => 'Ưu tiên phần trên',
                            'bottom' => 'Ưu tiên phần dưới',
                            'center' => 'Căn giữa',
                        ],
                    ],
                    [
                        'key' => 'bride_position',
                        'type' => 'select',
                        'label' => 'Vị trí lấy nét ảnh cô dâu',
                        'section' => 'Khung ảnh',
                        'options' => [
                            'top' => 'Ưu tiên phần trên',
                            'bottom' => 'Ưu tiên phần dưới',
                            'center' => 'Căn giữa',
                        ],
                    ],
                    [
                        'key' => 'groom_position',
                        'type' => 'select',
                        'label' => 'Vị trí lấy nét ảnh chú rể',
                        'section' => 'Khung ảnh',
                        'options' => [
                            'top' => 'Ưu tiên phần trên',
                            'bottom' => 'Ưu tiên phần dưới',
                            'center' => 'Căn giữa',
                        ],
                    ],
                    [
                        'key' => 'bride_welcome_time',
                        'type' => 'text',
                        'label' => 'Giờ bắt đầu đón khách nhà gái',
                        'section' => 'Timeline',
                        'required' => false,
                        'max_length' => 5,
                    ],
                    [
                        'key' => 'groom_welcome_time',
                        'type' => 'text',
                        'label' => 'Giờ bắt đầu đón khách nhà trai',
                        'section' => 'Timeline',
                        'required' => false,
                        'max_length' => 5,
                    ],
                    [
                        'key' => 'album_note',
                        'rows' => 4,
                        'type' => 'textarea',
                        'label' => 'Lời dẫn cho bố cục Our memories',
                        'section' => 'Album',
                        'required' => false,
                        'max_length' => 1000,
                    ],
                ],
            ],
            [
                'name' => 'THT E-Wedding 18 (Linen Editorial)',
                'view_path' => 'templates.tht_e_wedding_18',
                'type' => 'wedding',
                'is_active' => true,
                'content_schema' => [
                    [
                        'section' => 'Love Story',
                        'key' => 'love_story_main_image',
                        'label' => 'Ảnh Love Story lớn',
                        'type' => 'image',
                        'helper_text' => 'Ảnh lớn ở đầu phần Love Story, giữ nguyên tỷ lệ gốc.',
                    ],
                    [
                        'section' => 'Love Story',
                        'key' => 'love_story_detail_images',
                        'label' => '4 ảnh nhỏ Love Story',
                        'type' => 'images',
                        'max_files' => 4,
                    ],
                    [
                        'section' => 'Lịch cưới',
                        'key' => 'calendar_background',
                        'label' => 'Ảnh nền dưới lịch',
                        'type' => 'image',
                        'aspect_ratio' => '4:3',
                        'helper_text' => 'Ảnh nền của lịch; hai ngày tiệc lấy từ dữ liệu nhà gái và nhà trai sẽ tự đánh dấu bằng tim.',
                    ],
                ],
            ],
            [
                'name' => 'THT E-Wedding 17',
                'view_path' => 'templates.tht_e_wedding_17',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Modern 01',
                'view_path' => 'templates.modern_01',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Traditional Red (Truyền Thống)',
                'view_path' => 'templates.traditional_red',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Minimal 03 (Tạp Chí)',
                'view_path' => 'templates.minimal_03',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Luxury Gold (Vàng Hoàng Gia)',
                'view_path' => 'templates.luxury_gold',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Elegant 02 (Sang Trọng Cổ Điển)',
                'view_path' => 'templates.elegant_02',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Cherry Blossom (Mùa Valentine)',
                'view_path' => 'templates.cherry_blossom',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Galaxy Dreams (Ngân Hà Lung Linh)',
                'view_path' => 'templates.galaxy_dreams',
                'type' => 'wedding',
                'is_active' => true,
            ],
            [
                'name' => 'Simple Card (Danh Thiếp Đơn Giản)',
                'view_path' => 'templates.business.simple_modern',
                'type' => 'business',
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            $createdTemplate = \App\Models\Template::updateOrCreate(
                ['view_path' => $template['view_path']],
                $template
            );
            
            // Link existing weddings that match this view_path (Only for weddings)
            if ($createdTemplate->type === 'wedding') {
                 \App\Models\Wedding::where('template_view', $template['view_path'])
                    ->update(['template_id' => $createdTemplate->id, 'type' => 'wedding']);
            }
        }
    }
}
