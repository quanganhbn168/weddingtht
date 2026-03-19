<?php

namespace App\Services;

use App\Models\Wedding;
use App\Enums\WeddingTier;

class FeatureGate
{
    /**
     * Kiểm tra wedding có quyền sử dụng tính năng hay không
     *
     * @param Wedding $wedding
     * @param string $feature Tên tính năng
     * @return bool
     */
    public static function can(Wedding $wedding, string $feature): bool
    {
        $isPro = $wedding->tier === WeddingTier::PRO;

        return match ($feature) {
            // Tất cả gói đều có
            'rsvp', 'guestbook', 'gallery', 'family_info', 'event_cards', 'couple_info' => true,

            // Chỉ gói Pro
            'music'               => $isPro,
            'falling_effect'      => $isPro,
            'love_story'          => $isPro,
            'qr_payment'          => $isPro,
            'preload'             => $isPro,
            'invitation_wrapper'  => $isPro,
            'side_splitting'      => $isPro,
            'custom_slug'         => $isPro,
            'password'            => $isPro,
            'guest_name'          => $isPro,
            'public_share'        => $isPro,

            default => true,
        };
    }

    /**
     * Lấy số ảnh gallery tối đa theo gói
     */
    public static function maxPhotos(Wedding $wedding): int
    {
        return $wedding->tier === WeddingTier::PRO ? -1 : 20;
    }

    /**
     * Danh sách tính năng Pro để hiển thị
     */
    public static function proFeatures(): array
    {
        return [
            'music'              => 'Nhạc nền',
            'falling_effect'     => 'Hiệu ứng rơi',
            'love_story'         => 'Love Story timeline',
            'qr_payment'         => 'QR Mừng cưới',
            'preload'            => 'Màn hình chờ (phong bì)',
            'invitation_wrapper' => 'Mở phong bì',
            'side_splitting'     => 'Tách thiệp 2 bên',
            'custom_slug'        => 'Tuỳ chỉnh đường link',
            'password'           => 'Mật khẩu bảo vệ',
            'guest_name'         => 'Tên khách mời (?guest=)',
            'public_share'       => 'Chia sẻ công khai',
        ];
    }
}
