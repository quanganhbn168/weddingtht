<?php

namespace App\Services;

use App\Models\Wedding;
use Closure;

final class GuestInviteExportService
{
    public static function txtCallback(Wedding $wedding, ?array $guests = null): Closure
    {
        $guests ??= $wedding->guestInvites();

        return function () use ($guests, $wedding): void {
            $file = fopen('php://output', 'w');

            if ($file === false) {
                return;
            }

            fwrite($file, "\xEF\xBB\xBF");
            fwrite($file, 'DANH SÁCH KHÁCH MỜI'.PHP_EOL);
            fwrite($file, 'Thiệp: '.trim($wedding->groom_name.' & '.$wedding->bride_name).PHP_EOL);
            fwrite($file, str_repeat('=', 60).PHP_EOL.PHP_EOL);

            $position = 0;

            foreach ($guests as $guest) {
                if (! is_array($guest)) {
                    continue;
                }

                $code = Wedding::normalizeGuestCode($guest['code'] ?? null);
                $name = trim(strip_tags((string) ($guest['name'] ?? '')));

                if (! $code || $name === '') {
                    continue;
                }

                $position++;

                fwrite($file, $position.'. ['.$code.'] '.$name.PHP_EOL);
                fwrite($file, '   '.$wedding->guestInvitationUrl($code).PHP_EOL.PHP_EOL);
            }

            fclose($file);
        };
    }

    public static function filename(Wedding $wedding): string
    {
        return 'danh-sach-khach-moi-'.$wedding->slug.'.txt';
    }
}
