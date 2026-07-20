<?php

namespace Tests\Feature;

use App\Models\Wedding;
use Tests\TestCase;

class WeddingInvitationSlugTest extends TestCase
{
    public function test_name_order_determines_the_invitation_side(): void
    {
        $wedding = new Wedding([
            'groom_name' => 'Văn Trường',
            'bride_name' => 'Thu Hằng',
            'slug' => 'van-truong-va-thu-hang',
        ]);

        $this->assertSame('thu-hang-va-van-truong', $wedding->brideInvitationSlug());
        $this->assertSame('van-truong-va-thu-hang', $wedding->groomInvitationSlug());
        $this->assertSame('bride', $wedding->invitationSideForSlug('thu-hang-va-van-truong'));
        $this->assertSame('groom', $wedding->invitationSideForSlug('van-truong-va-thu-hang'));
    }

    public function test_name_order_keeps_the_canonical_slug_suffix(): void
    {
        $wedding = new Wedding([
            'groom_name' => 'Văn Trường',
            'bride_name' => 'Thu Hằng',
            'slug' => 'van-truong-va-thu-hang-2026',
        ]);

        $this->assertSame('thu-hang-va-van-truong-2026', $wedding->brideInvitationSlug());
        $this->assertTrue($wedding->matchesInvitationSlug('thu-hang-va-van-truong-2026'));
    }
}
