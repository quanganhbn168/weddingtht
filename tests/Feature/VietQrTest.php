<?php

namespace Tests\Feature;

use App\Models\Wedding;
use App\Services\VietQrService;
use Tests\TestCase;

class VietQrTest extends TestCase
{
    public function test_it_builds_a_vietqr_quick_link_from_payment_details(): void
    {
        $url = VietQrService::quickLink(
            '970422',
            '0012 345 678',
            'NGUYEN VAN A',
            '1.000.000',
            'MUNG CUOI',
        );

        $this->assertSame(
            'https://img.vietqr.io/image/970422-0012345678-compact2.png?amount=1000000&addInfo=MUNG%20CUOI&accountName=NGUYEN%20VAN%20A',
            $url,
        );
    }

    public function test_wedding_prefers_the_generated_qr_and_formats_its_account_info(): void
    {
        $wedding = new Wedding([
            'groom_qr_bank_id' => '970422',
            'groom_qr_account_number' => '0012345678',
            'groom_qr_account_name' => 'NGUYEN VAN A',
        ]);

        $this->assertSame(
            'https://img.vietqr.io/image/970422-0012345678-compact2.png?accountName=NGUYEN%20VAN%20A',
            $wedding->getGroomQrUrl(),
        );
        $this->assertSame(
            "Ngân hàng: MB Bank\nSố TK: 0012345678\nChủ TK: NGUYEN VAN A",
            $wedding->getQrPaymentInfo('groom'),
        );
    }

    public function test_it_normalizes_vietnamese_text_for_the_qr_payload(): void
    {
        $url = VietQrService::quickLink(
            '970436',
            '1234567890',
            'Nguyễn Văn A',
            null,
            'Mừng cưới!',
        );

        $this->assertSame(
            'https://img.vietqr.io/image/970436-1234567890-compact2.png?addInfo=MUNG%20CUOI&accountName=NGUYEN%20VAN%20A',
            $url,
        );
    }
}
