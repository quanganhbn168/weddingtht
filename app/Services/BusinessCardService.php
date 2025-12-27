<?php

namespace App\Services;

use App\Models\BusinessCard;
use App\Models\Template;
use App\Models\User;
use Illuminate\Support\Str;

class BusinessCardService
{
    /**
     * Get validated data for business card
     */
    public function getValidationRules(bool $isUpdate = false): array
    {
        return [
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:500',
            'about' => 'nullable|string',
            'template_id' => 'required|exists:templates,id',
        ];
    }

    /**
     * Get user's business cards
     */
    public function getUserCards(User $user, int $perPage = 10)
    {
        return $user->businessCards()->with('template')->latest()->paginate($perPage);
    }

    /**
     * Create a new business card
     */
    public function createCard(User $user, array $data): BusinessCard
    {
        // Generate unique slug
        $data['slug'] = Str::slug($data['name']) . '-' . rand(1000, 9999);
        $data['is_active'] = true;
        
        return $user->businessCards()->create($data);
    }

    /**
     * Update existing business card
     */
    public function updateCard(BusinessCard $card, array $data): bool
    {
        return $card->update($data);
    }

    /**
     * Delete business card
     */
    public function deleteCard(BusinessCard $card): bool
    {
        return $card->delete();
    }

    /**
     * Check if card belongs to user
     */
    public function checkOwnership(User $user, BusinessCard $card): bool
    {
        return $card->user_id === $user->id;
    }

    /**
     * Get details for card view
     */
    public function getCardBySlug(string $slug): ?BusinessCard
    {
        return BusinessCard::where('slug', $slug)->first();
    }
}
