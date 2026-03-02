<?php

namespace App\Enums;

enum WeddingStatus: string
{
    case DRAFT = 'draft';
    case PREVIEW = 'preview';
    case PUBLISHED = 'published';
    
    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Nháp',
            self::PREVIEW => 'Xem trước',
            self::PUBLISHED => 'Đã đăng',
        };
    }
    
    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::PREVIEW => 'blue',
            self::PUBLISHED => 'green',
        };
    }
    
    public function badgeClass(): string
    {
        return match($this) {
            self::DRAFT => 'bg-gray-100 text-gray-600',
            self::PREVIEW => 'bg-blue-100 text-blue-800',
            self::PUBLISHED => 'bg-green-100 text-green-800',
        };
    }
    
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray();
    }
}
