<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResolveWeddingUserAction
{
    /**
     * Xác định hoặc tạo user cho thiệp cưới.
     *
     * Ưu tiên:
     * 1. user_id đã chọn từ form
     * 2. Tạo mới bằng customer_email
     * 3. Auto-gen bằng slug (fallback)
     */
    public function execute(array $data, ?string $panel = null, ?int $agentUserId = null): array
    {
        // App panel → customer tự tạo
        if ($panel === 'app') {
            $data['user_id'] = auth()->id();
            return $this->cleanup($data);
        }

        // Đã chọn user hiện có
        if (!empty($data['user_id'])) {
            return $this->cleanup($data);
        }

        // Tạo user mới bằng email thật
        if (!empty($data['customer_email'])) {
            $user = $this->findOrCreateUser(
                email: $data['customer_email'],
                name: $this->buildCoupleName($data),
                password: $data['customer_password'] ?? '12345678',
                agentId: $panel === 'agent' ? $agentUserId : null,
            );
            $data['user_id'] = $user->id;
            return $this->cleanup($data);
        }

        // Fallback: auto-gen email từ slug
        $user = $this->createFromSlug($data, $panel === 'agent' ? $agentUserId : null);
        $data['user_id'] = $user->id;

        return $this->cleanup($data);
    }

    /**
     * Tìm hoặc tạo user từ email.
     */
    private function findOrCreateUser(string $email, string $name, string $password, ?int $agentId = null): User
    {
        return User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => User::ROLE_CUSTOMER,
                'agent_id' => $agentId,
            ]
        );
    }

    /**
     * Tạo user từ slug thiệp (fallback cho data cũ).
     */
    private function createFromSlug(array $data, ?int $agentId = null): User
    {
        $slug = $data['slug'] ?? Str::slug(
            ($data['groom_name'] ?? 'groom') . '-va-' . ($data['bride_name'] ?? 'bride')
        );

        return $this->findOrCreateUser(
            email: $slug . '@wedding.com',
            name: $this->buildCoupleName($data),
            password: '12345678',
            agentId: $agentId,
        );
    }

    /**
     * Ghép tên cặp đôi.
     */
    private function buildCoupleName(array $data): string
    {
        return trim(($data['groom_name'] ?? '') . ' & ' . ($data['bride_name'] ?? ''), ' &');
    }

    /**
     * Loại bỏ fields không thuộc model Wedding.
     */
    private function cleanup(array $data): array
    {
        unset($data['customer_email'], $data['customer_password']);
        return $data;
    }
}
