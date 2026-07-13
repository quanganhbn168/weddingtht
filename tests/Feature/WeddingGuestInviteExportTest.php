<?php

namespace Tests\Feature;

use App\Models\Wedding;
use App\Services\GuestInviteExportService;
use Tests\TestCase;

class WeddingGuestInviteExportTest extends TestCase
{
    public function test_it_exports_guest_codes_names_and_personal_invitation_links(): void
    {
        $wedding = new Wedding([
            'slug' => 'duc-thang-va-phuong-anh',
        ]);
        $guests = [
            ['code' => 'KM001', 'name' => 'Đức Thắng và Phương'],
            ['code' => 'km002', 'name' => 'Bạn Phương và NT'],
            ['code' => '', 'name' => 'Dòng chưa hoàn thiện'],
        ];

        ob_start();
        GuestInviteExportService::txtCallback($wedding, $guests)();
        $text = substr(ob_get_clean(), 3);

        $this->assertStringStartsWith('DANH SÁCH KHÁCH MỜI', $text);
        $this->assertStringContainsString('1. [km001] Đức Thắng và Phương', $text);
        $this->assertStringContainsString($wedding->guestInvitationUrl('km001'), $text);
        $this->assertStringContainsString('2. [km002] Bạn Phương và NT', $text);
        $this->assertStringContainsString($wedding->guestInvitationUrl('km002'), $text);
        $this->assertStringNotContainsString('Dòng chưa hoàn thiện', $text);
        $this->assertSame(
            'danh-sach-khach-moi-duc-thang-va-phuong-anh.txt',
            GuestInviteExportService::filename($wedding),
        );
    }
}
