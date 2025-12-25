<?php
require 'vendor/autoload.php';

use Carbon\Carbon;
use LucNham\LunarCalendar\LunarDateTime;

function test($dateStr) {
    echo "Input: $dateStr\n";
    try {
        $date = Carbon::parse($dateStr);
        
        // OLD WAY (Incorrect?)
        $lunarOld = new LunarDateTime($date->format('Y-m-d'));
        echo "Constructor Direct: {$lunarOld->day}/{$lunarOld->month} Year: {$lunarOld->year}\n";
        
        // NEW WAY (Expected Fix)
        $lunarNew = LunarDateTime::fromGregorian($date->format('Y-m-d H:i:s'));
        echo "fromGregorian: {$lunarNew->day}/{$lunarNew->month} Year: {$lunarNew->year}\n";
        
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    echo "----------------\n";
}

test('2025-12-30'); // Expected ~ 11/11
test('2026-02-17'); // Expected 01/01
