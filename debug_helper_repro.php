<?php
require 'vendor/autoload.php';

use Carbon\Carbon;
use LucNham\LunarCalendar\LunarDateTime;

class LunarHelper
{
    protected static array $thienCan = [
        'Giáp', 'Ất', 'Bính', 'Đinh', 'Mậu', 'Kỷ', 'Canh', 'Tân', 'Nhâm', 'Quý'
    ];

    protected static array $diaChi = [
        'Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'
    ];

    public static function solarToLunar($solarDate): ?string
    {
        if (empty($solarDate)) {
            return null;
        }

        try {
            echo "Input: " . $solarDate . "\n";
            $date = $solarDate instanceof Carbon ? $solarDate : Carbon::parse($solarDate);
            echo "Parsed Carbon: " . $date->format('Y-m-d H:i:s') . "\n";
            
            // Create LunarDateTime from solar date string
            $lunar = new LunarDateTime($date->format('Y-m-d'));
            
            // Properties: day, month, year (không phải d, m, y)
            $lunarDay = $lunar->day;
            $lunarMonth = $lunar->month;
            $lunarYear = $lunar->year;
            
            echo "Lunar Object: Day=$lunarDay, Month=$lunarMonth, Year=$lunarYear\n";

            // Tính Can Chi của năm
            $canIndex = ($lunarYear + 6) % 10;
            $chiIndex = ($lunarYear + 8) % 12;
            
            $canChi = self::$thienCan[$canIndex] . ' ' . self::$diaChi[$chiIndex];
            
            // Format ngày âm
            $lunarDayStr = str_pad($lunarDay, 2, '0', STR_PAD_LEFT);
            $lunarMonthStr = str_pad($lunarMonth, 2, '0', STR_PAD_LEFT);
            
            return "{$lunarDayStr}/{$lunarMonthStr} {$canChi}";
            
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

// Test cases
echo "Result 1: " . LunarHelper::solarToLunar('2025-12-30') . "\n";
echo "Result 2: " . LunarHelper::solarToLunar('30-12-2025') . "\n";
echo "Result 3: " . LunarHelper::solarToLunar('30/12/2025') . "\n"; // Slashes
echo "Result 4: " . LunarHelper::solarToLunar('2026-02-17') . "\n"; // Lunar New Year 2026
