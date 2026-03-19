<?php

namespace App\Enums;

enum BusinessType: string
{
    case PRINT = 'print';
    case PHOTO = 'photo';
    case STUDIO = 'studio';
    case WEDDING_PLANNER = 'wedding_planner';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::PRINT => 'Nhà in',
            self::PHOTO => 'Chụp ảnh',
            self::STUDIO => 'Studio',
            self::WEDDING_PLANNER => 'Wedding Planner',
            self::OTHER => 'Khác',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray();
    }
}
