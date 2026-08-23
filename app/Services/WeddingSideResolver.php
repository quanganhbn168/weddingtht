<?php

namespace App\Services;

use App\DTOs\WeddingEventData;
use App\DTOs\WeddingFamilyData;
use App\DTOs\WeddingSideData;
use App\Models\Wedding;
use Carbon\Carbon;

class WeddingSideResolver
{
    /**
     * Resolve side-specific data for a wedding invitation
     *
     * @param Wedding $wedding
     * @param string $side 'groom' | 'bride' | 'both'
     * @return WeddingSideData
     */
    public static function resolve(Wedding $wedding, string $side = 'both'): WeddingSideData
    {
        // Validate side parameter
        if (!in_array($side, ['groom', 'bride', 'both'])) {
            $side = 'both';
        }

        $groomFamily = new WeddingFamilyData(
            side: 'groom',
            label: 'Nhà Trai',
            father: $wedding->groom_father,
            mother: $wedding->groom_mother,
            address: $wedding->groom_address,
        );

        $brideFamily = new WeddingFamilyData(
            side: 'bride',
            label: 'Nhà Gái',
            father: $wedding->bride_father,
            mother: $wedding->bride_mother,
            address: $wedding->bride_address,
        );

        $groomEvent = self::groomEvent($wedding);
        $brideEvent = self::brideEvent($wedding);

        // Bản tổng theo thiết kế: nhà gái/cô dâu trước. Bản riêng ưu tiên đúng phía.
        [$firstName, $secondName, $firstPhoto, $secondPhoto, $families, $events] = match ($side) {
            'groom' => [
                $wedding->groom_name,
                $wedding->bride_name,
                $wedding->getGroomPhotoUrl(),
                $wedding->getBridePhotoUrl(),
                collect([$groomFamily, $brideFamily]),
                collect([$groomEvent]),
            ],
            'bride' => [
                $wedding->bride_name,
                $wedding->groom_name,
                $wedding->getBridePhotoUrl(),
                $wedding->getGroomPhotoUrl(),
                collect([$brideFamily, $groomFamily]),
                collect([$brideEvent]),
            ],
            default => [
                $wedding->bride_name,
                $wedding->groom_name,
                $wedding->getBridePhotoUrl(),
                $wedding->getGroomPhotoUrl(),
                collect([$brideFamily, $groomFamily]),
                collect([$brideEvent, $groomEvent]),
            ],
        };

        return new WeddingSideData(
            side: $side,
            firstName: $firstName,
            secondName: $secondName,
            firstPhoto: $firstPhoto,
            secondPhoto: $secondPhoto,
            families: $families,
            events: $events,
            showGroomEvents: ($side !== 'bride'),
            showBrideEvents: ($side !== 'groom'),
        );
    }

    private static function groomEvent(Wedding $wedding): WeddingEventData
    {
        $receptionDate = self::date($wedding->groom_reception_date, $wedding);
        $ceremonyDate = self::date($wedding->groom_ceremony_date, $wedding);

        return new WeddingEventData(
            side: 'groom',
            receptionTitle: 'Bữa cơm thân mật nhà trai',
            receptionDate: $receptionDate,
            receptionLunarDisplay: $wedding->formattedLunarDateFor($receptionDate),
            receptionLunarInWords: $wedding->fullLunarDateFor($receptionDate),
            receptionTime: self::time($wedding->groom_reception_time ?? $wedding->groom_ceremony_time),
            receptionVenue: $wedding->groom_reception_venue ?: 'Tư gia nhà trai',
            receptionAddress: $wedding->groom_reception_address ?: $wedding->groom_address,
            receptionMapUrl: $wedding->groom_map_url,
            receptionMapEmbed: $wedding->groom_map_embed,
            ceremonyTitle: 'Lễ Thành Hôn',
            ceremonyDate: $ceremonyDate,
            ceremonyLunarDisplay: $wedding->formattedLunarDateFor($ceremonyDate),
            ceremonyLunarInWords: $wedding->fullLunarDateFor($ceremonyDate),
            ceremonyTime: self::time($wedding->groom_ceremony_time),
            ceremonyVenue: $wedding->groom_ceremony_venue ?: 'Tư gia nhà trai',
            ceremonyAddress: $wedding->groom_address,
            ceremonyMapUrl: $wedding->groom_ceremony_map_url ?: $wedding->groom_map_url,
            ceremonyMapEmbed: $wedding->groom_ceremony_map_embed ?: $wedding->groom_map_embed,
        );
    }

    private static function brideEvent(Wedding $wedding): WeddingEventData
    {
        $receptionDate = self::date($wedding->bride_reception_date, $wedding);
        $ceremonyDate = self::date($wedding->bride_ceremony_date, $wedding);

        return new WeddingEventData(
            side: 'bride',
            receptionTitle: 'Bữa cơm thân mật nhà gái',
            receptionDate: $receptionDate,
            receptionLunarDisplay: $wedding->formattedLunarDateFor($receptionDate),
            receptionLunarInWords: $wedding->fullLunarDateFor($receptionDate),
            receptionTime: self::time($wedding->bride_reception_time ?? $wedding->bride_ceremony_time),
            receptionVenue: $wedding->bride_reception_venue ?: 'Tư gia nhà gái',
            receptionAddress: $wedding->bride_reception_address ?: $wedding->bride_address,
            receptionMapUrl: $wedding->bride_map_url,
            receptionMapEmbed: $wedding->bride_map_embed,
            ceremonyTitle: 'Lễ Vu Quy',
            ceremonyDate: $ceremonyDate,
            ceremonyLunarDisplay: $wedding->formattedLunarDateFor($ceremonyDate),
            ceremonyLunarInWords: $wedding->fullLunarDateFor($ceremonyDate),
            ceremonyTime: self::time($wedding->bride_ceremony_time),
            ceremonyVenue: $wedding->bride_ceremony_venue ?: 'Tư gia nhà gái',
            ceremonyAddress: $wedding->bride_address,
            ceremonyMapUrl: $wedding->bride_ceremony_map_url ?: $wedding->bride_map_url,
            ceremonyMapEmbed: $wedding->bride_ceremony_map_embed ?: $wedding->bride_map_embed,
        );
    }

    private static function date(mixed $date, Wedding $wedding): Carbon
    {
        return Carbon::parse($date ?? $wedding->event_date);
    }

    private static function time(mixed $time): ?Carbon
    {
        return $time ? Carbon::parse($time) : null;
    }
}
