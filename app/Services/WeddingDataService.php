<?php

namespace App\Services;

use App\DTOs\WeddingSideData;
use App\Models\Wedding;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WeddingDataService
{
    /**
     * Day-of-week labels tieng Viet.
     */
    private const DOW_LABELS = [
        0 => 'Chủ Nhật',
        1 => 'Thứ Hai',
        2 => 'Thứ Ba',
        3 => 'Thứ Tư',
        4 => 'Thứ Năm',
        5 => 'Thứ Sáu',
        6 => 'Thứ Bảy',
    ];

    /**
     * Ngày hiển thị ở Hero: các ngày diễn ra tiệc và ngày cưới chính.
     * Các section bên dưới vẫn tách riêng tiệc nhà gái/nhà trai và từng lễ.
     *
     * @return Collection<int, Carbon>
     */
    public static function heroDates(Wedding $wedding, WeddingSideData $sideData): Collection
    {
        $dates = $sideData->events
            ->map(fn ($event): Carbon => $event->receptionDate->copy()->timezone(config('app.timezone')));

        if ($wedding->event_date) {
            $dates->push($wedding->event_date->copy()->timezone(config('app.timezone')));
        }

        return $dates
            ->unique(fn (Carbon $date): string => $date->toDateString())
            ->sortBy(fn (Carbon $date): int => $date->getTimestamp())
            ->values();
    }

    /**
     * Chuan bi toan bo data can thiet cho templates.
     * Moi template deu nhan chung 1 tap data nay.
     */
    public static function prepare(Wedding $wedding): array
    {
        $solar = $wedding->event_date ?? now();
        $lunarStr = $wedding->event_date_lunar;
        $lunarDisplay = $wedding->formattedLunarDate();

        // Gallery images + placeholders
        $galleryImages = $wedding->gallery_images;
        $placeholders = [
            'https://images.unsplash.com/photo-1519741497674-611481863552?w=600',
            'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=600',
            'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=600',
            'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=600',
            'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600',
            'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=600',
        ];
        $imgs = $galleryImages->isNotEmpty()
            ? $galleryImages->map(fn ($m) => $m->getUrl())->toArray()
            : $placeholders;
        $albumImages = collect($imgs)->filter()->values();
        $thankYouImage = $wedding->getThankYouUrl();
        $guestName = $wedding->getGuestName();

        // Groom ceremony
        $groomCeremonyCarbon = self::parseTime($wedding->groom_ceremony_time, $wedding->groom_ceremony_date, $solar);
        $groomCeremonyTime = $wedding->groom_ceremony_time
            ? Carbon::parse($wedding->groom_ceremony_time)->format('H:i')
            : null;
        $groomDow = self::DOW_LABELS[$groomCeremonyCarbon->dayOfWeek];

        // Bride ceremony
        $brideCeremonyCarbon = self::parseTime($wedding->bride_ceremony_time, $wedding->bride_ceremony_date, $solar);
        $brideCeremonyTime = $wedding->bride_ceremony_time
            ? Carbon::parse($wedding->bride_ceremony_time)->format('H:i')
            : null;
        $brideDow = self::DOW_LABELS[$brideCeremonyCarbon->dayOfWeek];

        // Groom reception
        $groomReceptionCarbon = self::parseDate($wedding->groom_reception_date, $solar);
        $groomReceptionTime = $wedding->groom_reception_time
            ? Carbon::parse($wedding->groom_reception_time)->format('H:i')
            : null;
        $groomReceptionDow = self::DOW_LABELS[$groomReceptionCarbon->dayOfWeek];
        $groomReceptionTime2 = null;
        $groomReceptionDay2 = null;

        // Bride reception
        $brideReceptionCarbon = self::parseDate($wedding->bride_reception_date, $solar);
        $brideReceptionTime = $wedding->bride_reception_time
            ? Carbon::parse($wedding->bride_reception_time)->format('H:i')
            : null;
        $brideReceptionDow = self::DOW_LABELS[$brideReceptionCarbon->dayOfWeek];
        $brideReceptionTime2 = null;
        $brideReceptionDay2 = null;

        // Day of week (main event)
        $dayOfWeek = self::DOW_LABELS[$solar->dayOfWeek];

        // Calendar data
        $firstOfMonth = $solar->copy()->startOfMonth();
        $daysInMonth = $solar->daysInMonth;
        $eventDay = (int) $solar->format('j');
        $eventDay2 = null;
        if ($wedding->bride_ceremony_date && $wedding->bride_ceremony_date->format('Y-m') === $solar->format('Y-m')) {
            $eventDay2 = (int) $wedding->bride_ceremony_date->format('j');
        }

        $dowLabels = self::DOW_LABELS;

        $calendarDate = $solar->copy();
        $calendarLeadingDays = $calendarDate->copy()->startOfMonth()->isoWeekday() - 1;
        $calendarHighlightedDates = collect([
            $wedding->bride_reception_date,
            $wedding->groom_reception_date,
            $wedding->bride_ceremony_date,
            $wedding->groom_ceremony_date,
            $calendarDate,
        ])
            ->filter()
            ->map(fn (mixed $date): Carbon => Carbon::parse($date))
            ->filter(fn (Carbon $date): bool => $date->isSameMonth($calendarDate))
            ->map(fn (Carbon $date): string => $date->toDateString())
            ->unique()
            ->take(2)
            ->values()
            ->all();
        $calendarCells = collect(array_fill(0, $calendarLeadingDays, null))
            ->concat(collect(range(1, $calendarDate->daysInMonth))->map(fn (int $day): array => [
                'day' => $day,
                'date' => $calendarDate->copy()->day($day)->toDateString(),
            ]));
        $calendarWeeks = $calendarCells
            ->pad((int) (ceil($calendarCells->count() / 7) * 7), null)
            ->chunk(7)
            ->values();
        $calendarMonthLabel = $calendarDate->format('F Y');

        return compact(
            'solar', 'lunarStr', 'lunarDisplay', 'dayOfWeek', 'dowLabels',
            'galleryImages', 'imgs', 'placeholders', 'albumImages', 'thankYouImage', 'guestName',
            'groomCeremonyCarbon', 'groomCeremonyTime', 'groomDow',
            'brideCeremonyCarbon', 'brideCeremonyTime', 'brideDow',
            'groomReceptionCarbon', 'groomReceptionTime', 'groomReceptionDow',
            'groomReceptionTime2', 'groomReceptionDay2',
            'brideReceptionCarbon', 'brideReceptionTime', 'brideReceptionDow',
            'brideReceptionTime2', 'brideReceptionDay2',
            'firstOfMonth', 'daysInMonth', 'eventDay', 'eventDay2',
            'calendarHighlightedDates', 'calendarMonthLabel', 'calendarWeeks'
        );
    }

    private static function parseTime($time, $date, Carbon $fallback): Carbon
    {
        if ($date) {
            return Carbon::parse($date);
        }
        return $fallback->copy();
    }

    private static function parseDate($date, Carbon $fallback): Carbon
    {
        return $date ? Carbon::parse($date) : $fallback->copy();
    }
}
