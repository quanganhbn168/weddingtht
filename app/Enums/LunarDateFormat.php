<?php

namespace App\Enums;

enum LunarDateFormat: string
{
    case SHORT = 'short';
    case FULL = 'full';

    public function label(): string
    {
        return match ($this) {
            self::SHORT => 'Rút gọn (20/6)',
            self::FULL => 'Đầy đủ (Tức ngày 20 tháng 6 năm Bính Ngọ)',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $format) => [$format->value => $format->label()])
            ->all();
    }
}
