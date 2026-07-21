<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeddingWish;
use Illuminate\Auth\Access\HandlesAuthorization;

class WeddingWishPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Customer accounts use the `role` column as their source of truth for
        // dashboard access. The resource query limits wishes to their weddings.
        return $user->isCustomer() || $user->can('view_any_wedding::wish');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WeddingWish $weddingWish): bool
    {
        if ($user->isCustomer()) {
            return $weddingWish->wedding?->user_id === $user->id;
        }

        return $user->can('view_wedding::wish');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_wedding::wish');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WeddingWish $weddingWish): bool
    {
        return $user->can('update_wedding::wish');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WeddingWish $weddingWish): bool
    {
        return $user->can('delete_wedding::wish');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_wedding::wish');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, WeddingWish $weddingWish): bool
    {
        return $user->can('force_delete_wedding::wish');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_wedding::wish');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, WeddingWish $weddingWish): bool
    {
        return $user->can('restore_wedding::wish');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_wedding::wish');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, WeddingWish $weddingWish): bool
    {
        return $user->can('replicate_wedding::wish');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_wedding::wish');
    }
}
