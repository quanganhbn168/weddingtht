<?php

return [
    'templates.tht_e_wedding_17' => [
        'label' => 'Ảnh riêng của THT E-Wedding 17',
        'description' => 'Cụm album tối đa 5 ảnh hiển thị trước Gallery slider mặc định của mẫu THT E-Wedding 17.',
        'columns' => 1,
        'fields' => [
            [
                'name' => 'before_slider',
                'collection' => 'before_slider',
                'label' => 'Wedding Album trước Slider',
                'helper_text' => 'Tối đa 5 ảnh. Có thể kéo thả để sắp xếp thứ tự hiển thị trước Gallery slider mặc định.',
                'multiple' => true,
                'reorderable' => true,
                'max_files' => 5,
            ],
            [
                'name' => 'celebration_photo',
                'collection' => 'tht17_celebration_photo',
                'label' => 'Ảnh dưới phần Thiệp mời',
                'aspect_ratio' => '6:7',
                'helper_text' => 'Ảnh hiển thị trong phần lịch trình, ngay dưới Thiệp mời. Nếu chưa tải ảnh này, hệ thống sẽ dùng ảnh Hero.',
            ],
        ],
    ],

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
