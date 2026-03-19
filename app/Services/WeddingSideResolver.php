<?php

namespace App\Services;

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

        $isBride = ($side === 'bride');

        return new WeddingSideData(
            side: $side,

            // Name order: bride side -> bride first, groom side or both -> groom first
            firstName: $isBride ? $wedding->bride_name : $wedding->groom_name,
            secondName: $isBride ? $wedding->groom_name : $wedding->bride_name,

            // Photo order
            firstPhoto: $isBride ? $wedding->getBridePhotoUrl() : $wedding->getGroomPhotoUrl(),
            secondPhoto: $isBride ? $wedding->getGroomPhotoUrl() : $wedding->getBridePhotoUrl(),

            // Main ceremony (the side's own ceremony)
            mainCeremonyTime: $isBride
                ? $wedding->bride_ceremony_time
                : $wedding->groom_ceremony_time,
            mainCeremonyDate: $isBride
                ? ($wedding->bride_ceremony_date ? Carbon::parse($wedding->bride_ceremony_date) : null)
                : ($wedding->groom_ceremony_date ? Carbon::parse($wedding->groom_ceremony_date) : null),

            // Main reception
            mainReceptionTime: $isBride
                ? $wedding->bride_reception_time
                : $wedding->groom_reception_time,
            mainReceptionDate: $isBride
                ? ($wedding->bride_reception_date ?? $wedding->event_date)
                : ($wedding->groom_reception_date ?? $wedding->event_date),

            // Venue info
            mainVenue: $isBride
                ? ($wedding->bride_reception_venue ?? $wedding->bride_address)
                : ($wedding->groom_reception_venue ?? $wedding->groom_address),
            mainAddress: $isBride
                ? $wedding->bride_address
                : ($wedding->groom_reception_address ?? $wedding->groom_address),
            mainMapUrl: $isBride
                ? $wedding->bride_map_url
                : $wedding->groom_map_url,

            // Section visibility
            showGroomEvents: ($side !== 'bride'),
            showBrideEvents: ($side !== 'groom'),
        );
    }
}
