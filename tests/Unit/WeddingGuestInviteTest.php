<?php

namespace Tests\Unit;

use App\Models\Wedding;
use PHPUnit\Framework\TestCase;

class WeddingGuestInviteTest extends TestCase
{
    public function test_it_generates_the_next_guest_code_after_the_highest_existing_code(): void
    {
        $guests = [
            ['code' => 'KM001', 'name' => 'Đức Thắng và Phương'],
            ['code' => 'km009', 'name' => 'Khách cũ'],
            ['code' => 'vip-20', 'name' => 'Khách VIP'],
        ];

        $this->assertSame('km010', Wedding::nextGuestCode($guests));
    }

    public function test_it_appends_guest_names_without_changing_existing_guests(): void
    {
        $existing = [
            ['code' => 'KM001', 'name' => 'Đức Thắng và Phương'],
        ];

        $guests = Wedding::appendGuestNames($existing, "- Bạn Phương và NT\n- Bạn Thanh và NT");

        $this->assertSame($existing[0], $guests[0]);
        $this->assertSame([
            ['code' => 'km002', 'name' => 'Bạn Phương và NT'],
            ['code' => 'km003', 'name' => 'Bạn Thanh và NT'],
        ], array_slice($guests, 1));
    }

    public function test_it_ignores_blank_and_duplicate_guest_names(): void
    {
        $existing = [
            ['code' => 'km001', 'name' => 'Bạn Phương và NT'],
        ];

        $guests = Wedding::appendGuestNames(
            $existing,
            "Bạn Phương và NT\n  bạn phương VÀ nt  \n\n1. Vợ chồng bạn Ly\n- Vợ chồng bạn Ly",
        );

        $this->assertCount(2, $guests);
        $this->assertSame(['code' => 'km002', 'name' => 'Vợ chồng bạn Ly'], $guests[1]);
    }
}
