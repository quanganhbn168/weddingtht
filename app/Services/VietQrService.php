<?php

namespace App\Services;

use Illuminate\Support\Str;

class VietQrService
{
    /** @return array<string, string> */
    public static function bankOptions(): array
    {
        return config('vietqr.banks', []);
    }

    public static function quickLink(
        ?string $bankId,
        ?string $accountNumber,
        ?string $accountName = null,
        ?string $amount = null,
        ?string $addInfo = null,
    ): ?string {
        $bankId = trim((string) $bankId);
        $accountNumber = preg_replace('/\D+/', '', (string) $accountNumber) ?: '';

        if ($bankId === '' || $accountNumber === '') {
            return null;
        }

        $template = config('vietqr.template', 'compact2');
        $url = sprintf(
            'https://img.vietqr.io/image/%s-%s-%s.png',
            rawurlencode($bankId),
            rawurlencode($accountNumber),
            rawurlencode($template),
        );

        $amount = preg_replace('/\D+/', '', (string) $amount) ?: null;
        $query = array_filter([
            'amount' => $amount,
            'addInfo' => self::qrText($addInfo),
            'accountName' => self::qrText($accountName),
        ], static fn (?string $value): bool => filled($value));

        return $query === []
            ? $url
            : $url.'?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986);
    }

    public static function accountInfo(
        ?string $bankId,
        ?string $accountNumber,
        ?string $accountName = null,
    ): ?string {
        $bankId = trim((string) $bankId);
        $accountNumber = preg_replace('/\D+/', '', (string) $accountNumber) ?: '';

        if ($bankId === '' || $accountNumber === '') {
            return null;
        }

        $bankName = self::bankOptions()[$bankId] ?? $bankId;
        $lines = [
            'Ngân hàng: '.$bankName,
            'Số TK: '.$accountNumber,
        ];

        if ($accountName = self::clean($accountName)) {
            $lines[] = 'Chủ TK: '.$accountName;
        }

        return implode("\n", $lines);
    }

    private static function clean(?string $value): ?string
    {
        $value = trim((string) $value);

        return $value !== '' ? $value : null;
    }

    private static function qrText(?string $value): ?string
    {
        $value = self::clean($value);

        if (! $value) {
            return null;
        }

        return Str::of($value)
            ->ascii()
            ->upper()
            ->replaceMatches('/[^A-Z0-9 ]+/', ' ')
            ->squish()
            ->toString() ?: null;
    }
}
