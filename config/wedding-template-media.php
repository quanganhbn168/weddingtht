<?php

return [
    'templates.tht_e_wedding_16' => [
        'label' => 'Ảnh riêng của THT E-Wedding 16',
        'description' => 'Các ảnh này chỉ được dùng bởi mẫu THT E-Wedding 16. Vị trí chưa có ảnh sẽ không hiển thị.',
        'columns' => 3,
        'fields' => [
            [
                'name' => 'tht16_love_image',
                'collection' => 'tht16_love',
                'label' => 'Ảnh trong chữ LOVE',
                'aspect_ratio' => '10:3',
                'helper_text' => 'Ảnh ngang, chủ thể nên nằm gần trung tâm. Tỉ lệ gợi ý 10:3.',
                'focal_point' => 'album_love_focal_point',
                'focal_point_default' => ['x' => 50, 'y' => 20],
            ],
            [
                'name' => 'tht16_torn_photo',
                'collection' => 'tht16_torn_photo',
                'label' => 'Ảnh khung giấy xé',
                'aspect_ratio' => '3:1',
                'helper_text' => 'Ảnh ngang toàn cảnh, dùng ở khung giấy xé. Tỉ lệ gợi ý 3:1.',
            ],
            [
                'name' => 'tht16_forever_anchor',
                'collection' => 'tht16_forever_anchor',
                'label' => 'Ảnh Our Forever Anchor',
                'aspect_ratio' => '4:3',
                'helper_text' => 'Ảnh đôi ngang, chừa khoảng trống phía dưới cho dòng chữ. Tỉ lệ gợi ý 4:3.',
            ],
        ],
    ],
];
