<?php

namespace Tests\Unit;

use App\Models\Wedding;
use Illuminate\Http\Request;
use Tests\TestCase;

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

    public function test_it_keeps_duplicate_guest_names_as_separate_guests(): void
{
    $existing = [
        [
            'code' => 'km001',
            'name' => 'Kim Chi',
        ],
    ];

    $guests = Wedding::appendGuestNames(
        $existing,
        "Kim Chi\nKim Chi\n\n- Bạn Dũng\n- Bạn Dũng"
    );

    $this->assertCount(5, $guests);

    $this->assertSame([
        'code' => 'km001',
        'name' => 'Kim Chi',
    ], $guests[0]);

    $this->assertSame([
        'code' => 'km002',
        'name' => 'Kim Chi',
    ], $guests[1]);

    $this->assertSame([
        'code' => 'km003',
        'name' => 'Kim Chi',
    ], $guests[2]);

    $this->assertSame([
        'code' => 'km004',
        'name' => 'Bạn Dũng',
    ], $guests[3]);

    $this->assertSame([
        'code' => 'km005',
        'name' => 'Bạn Dũng',
    ], $guests[4]);
}

    public function test_personalized_guest_links_are_not_bound_to_a_template(): void
    {
        $wedding = new Wedding([
            'content' => [
                'invited_guests' => [
                    ['code' => 'KM001', 'name' => 'Gia đình anh Minh'],
                ],
            ],
        ]);

        app()->instance('request', Request::create('/demo', 'GET', ['guest_code' => 'km001']));

        foreach (['templates.tht_e_wedding_16', 'templates.tht_e_wedding_17', 'templates.tht_e_wedding_18'] as $templateView) {
            $wedding->template_view = $templateView;

            $this->assertSame('Gia đình anh Minh', $wedding->getGuestName());
        }
    }
}
