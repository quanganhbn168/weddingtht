<?php

namespace App\Services;

use App\Models\Wedding;
use App\Models\Template;
use App\Models\User;
use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Enums\FallingEffect;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class WeddingService
{
    /**
     * Validation rules for wedding update
     */
    public static function getValidationRules(Wedding $wedding): array
    {
        return [
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'template_id' => 'required|exists:templates,id',
            'status' => ['nullable', Rule::enum(WeddingStatus::class)],
            'tier' => ['nullable', Rule::enum(WeddingTier::class)],
            'falling_effect' => ['nullable', Rule::enum(FallingEffect::class)],
            'groom_father' => 'nullable|string|max:255',
            'groom_mother' => 'nullable|string|max:255',
            'bride_father' => 'nullable|string|max:255',
            'bride_mother' => 'nullable|string|max:255',
            'groom_address' => 'nullable|string|max:1000',
            'bride_address' => 'nullable|string|max:1000',
            'groom_map_url' => 'nullable|url|max:500',
            'bride_map_url' => 'nullable|url|max:500',
            'groom_reception_venue' => 'nullable|string|max:255',
            'bride_reception_venue' => 'nullable|string|max:255',
            'groom_reception_address' => 'nullable|string|max:1000',
            'bride_reception_address' => 'nullable|string|max:1000',
            'groom_qr_info' => 'nullable|string|max:1000',
            'bride_qr_info' => 'nullable|string|max:1000',
            'slug' => 'nullable|string|max:255|unique:weddings,slug,' . $wedding->id,
            'password' => 'nullable|string|max:255',
        ];
    }

    /**
     * Validate wedding data
     * Returns validated data or throws ValidationException
     */
    public static function validate(array $data, Wedding $wedding): array
    {
        $validator = Validator::make($data, self::getValidationRules($wedding));
        return $validator->validate();
    }

    /**
     * Normalize data before saving (convert string values to proper types)
     */
    public static function normalizeData(array $data): array
    {
        // Convert status string to enum value if needed
        if (isset($data['status'])) {
            $data['status'] = self::normalizeEnum($data['status'], WeddingStatus::class);
        }

        // Convert tier string to enum value if needed
        if (isset($data['tier'])) {
            $data['tier'] = self::normalizeEnum($data['tier'], WeddingTier::class);
        }

        // Convert falling_effect string to enum value if needed
        if (isset($data['falling_effect'])) {
            $data['falling_effect'] = self::normalizeEnum($data['falling_effect'], FallingEffect::class);
        }

        return $data;
    }

    /**
     * Normalize an enum value - accepts both string and enum instance
     */
    private static function normalizeEnum(mixed $value, string $enumClass): ?string
    {
        if ($value === null) {
            return null;
        }

        // If already an enum instance, get its value
        if ($value instanceof $enumClass) {
            return $value->value;
        }

        // If string, verify it's valid and return
        if (is_string($value)) {
            $enum = $enumClass::tryFrom($value);
            return $enum?->value;
        }

        return null;
    }

    /**
     * Update wedding with validated and normalized data
     */
    public static function updateWedding(Wedding $wedding, array $data): Wedding
    {
        // Normalize enums to string values for database
        $data = self::normalizeData($data);

        // Get template for view_path
        if (isset($data['template_id'])) {
            $template = Template::find($data['template_id']);
            if ($template) {
                $data['template_view'] = $template->view_path;
            }
        }

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = $wedding->slug ?: self::generateSlug($data);
        }

        // Update wedding
        $wedding->update($data);

        return $wedding->fresh();
    }

    /**
     * Create new wedding
     */
    public static function createWedding(User $user, array $data): Wedding
    {
        $data = self::normalizeData($data);

        // Set defaults
        $data['user_id'] = $user->id;
        $data['status'] = $data['status'] ?? WeddingStatus::DRAFT->value;
        $data['tier'] = $data['tier'] ?? WeddingTier::STANDARD->value;
        $data['falling_effect'] = $data['falling_effect'] ?? FallingEffect::HEARTS->value;

        // Generate slug
        if (empty($data['slug'])) {
            $data['slug'] = self::generateSlug($data);
        }

        // Get template view path
        if (isset($data['template_id'])) {
            $template = Template::find($data['template_id']);
            if ($template) {
                $data['template_view'] = $template->view_path;
            }
        }

        return Wedding::create($data);
    }

    /**
     * Generate unique slug for wedding
     */
    public static function generateSlug(array $data): string
    {
        $base = Str::slug(
            ($data['groom_name'] ?? 'groom') . '-va-' . 
            ($data['bride_name'] ?? 'bride') . '-' . 
            date('Y')
        );

        $slug = $base;
        $counter = 1;

        while (Wedding::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Get status options for dropdowns (using Enum)
     */
    public static function getStatusOptions(): array
    {
        return WeddingStatus::options();
    }

    /**
     * Get tier options for dropdowns (using Enum)
     */
    public static function getTierOptions(): array
    {
        return WeddingTier::options();
    }

    /**
     * Get falling effect options for dropdowns (using Enum)
     */
    public static function getFallingEffectOptions(): array
    {
        return FallingEffect::options();
    }

    /**
     * Check if user can access this wedding
     */
    public static function canAccess(User $user, Wedding $wedding): bool
    {
        // Owner can always access
        if ($wedding->user_id === $user->id) {
            return true;
        }

        // Admin/Super Admin can access all
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return true;
        }

        // Agent can access their customers' weddings
        if ($user->isAgent()) {
            $customerIds = $user->managedCustomers()->pluck('id')->toArray();
            return in_array($wedding->user_id, $customerIds);
        }

        return false;
    }

    /**
     * Check if user can update this wedding
     */
    public static function canUpdate(User $user, Wedding $wedding): bool
    {
        return self::canAccess($user, $wedding);
    }
}
