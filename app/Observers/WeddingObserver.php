<?php

namespace App\Observers;

use App\Enums\FallingEffect;
use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Helpers\LunarHelper;
use App\Models\Wedding;
use Illuminate\Support\Str;

class WeddingObserver
{
    /**
     * Truoc khi tao thiep moi — defaults + slug.
     */
    public function creating(Wedding $wedding): void
    {
        $this->generateSlug($wedding);
        $this->setDefaults($wedding);
    }

    /**
     * Truoc khi luu (ca tao + sua) — lunar date.
     */
    public function saving(Wedding $wedding): void
    {
        $this->calculateLunarDate($wedding);
    }

    /**
     * Truoc khi cap nhat — auto-update slug neu doi ten.
     */
    public function updating(Wedding $wedding): void
    {
        if (($wedding->isDirty('groom_name') || $wedding->isDirty('bride_name'))
            && !$wedding->isDirty('slug')) {
            $this->generateSlug($wedding);
        }
    }

    /**
     * Sau khi xoa — don dep media.
     */
    public function deleted(Wedding $wedding): void
    {
        $collections = ['cover', 'hero', 'thank_you', 'gallery', 'groom_photo', 'bride_photo', 'groom_qr', 'bride_qr'];

        foreach ($collections as $collection) {
            $wedding->clearMediaCollection($collection);
        }

        // Xoa RSVP + Wishes lien quan
        $wedding->rsvps()->delete();
        $wedding->wishes()->delete();
    }

    // ==========================================
    // PRIVATE HELPERS
    // ==========================================

    private function generateSlug(Wedding $wedding): void
    {
        if (!empty($wedding->slug) && !$wedding->isDirty('groom_name') && !$wedding->isDirty('bride_name')) {
            return;
        }

        $base = Str::slug(($wedding->groom_name ?? 'groom') . '-va-' . ($wedding->bride_name ?? 'bride'));
        $slug = $base;
        $count = 1;

        while (Wedding::where('slug', $slug)
            ->when($wedding->id, fn ($q) => $q->where('id', '!=', $wedding->id))
            ->exists()) {
            $slug = $base . '-' . $count++;
        }

        $wedding->slug = $slug;
    }

    private function setDefaults(Wedding $wedding): void
    {
        $wedding->status ??= WeddingStatus::DRAFT;
        $wedding->tier ??= WeddingTier::STANDARD;
        $wedding->falling_effect ??= FallingEffect::HEARTS;
        $wedding->is_active ??= true;
        $wedding->can_share ??= true;
        $wedding->is_demo ??= false;
        $wedding->show_preload ??= true;
    }

    private function calculateLunarDate(Wedding $wedding): void
    {
        if ($wedding->event_date && $wedding->isDirty('event_date')) {
            $wedding->event_date_lunar = LunarHelper::solarToLunar($wedding->event_date);
        }
    }
}
