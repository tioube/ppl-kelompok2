<?php

namespace App\Policies;

use App\Models\Silabus;
use App\Models\User;

class SilabusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Super-admin has full access
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->hasPermission('manage-silabus') || $user->hasPermission('view-silabus');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Silabus $silabus): bool
    {
        // Super-admin & Akademik can view all
        if ($user->hasRole(['super-admin', 'akademik'])) {
            return true;
        }

        // Guru can view own silabus
        if ($user->hasRole('guru') && $silabus->created_by === $user->id) {
            return true;
        }

        // Others can only view approved & active silabus
        return $silabus->approval_status === 'approved' && $silabus->status === 'aktif';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Super-admin has full access
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->hasPermission('manage-silabus') || $user->hasPermission('create-silabus');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Silabus $silabus): bool
    {
        // Super-admin can edit all
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Guru can only edit own draft/rejected silabus
        if ($user->hasRole('guru')) {
            return $silabus->created_by === $user->id && $silabus->canBeEdited();
        }

        // Akademik can edit if not approved
        if ($user->hasRole('akademik')) {
            return $silabus->approval_status !== 'approved';
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Silabus $silabus): bool
    {
        // Only super-admin can delete
        if (! $user->hasRole('super-admin')) {
            return false;
        }

        return $silabus->canBeDeleted();
    }

    /**
     * Determine whether the user can approve/reject the model.
     */
    public function approve(User $user, Silabus $silabus): bool
    {
        // Super-admin has full access
        if ($user->isSuperAdmin()) {
            return true;
        }

        return ($user->hasPermission('manage-silabus') || $user->hasPermission('approve-silabus')) &&
               $user->hasRole('akademik');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Silabus $silabus): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Silabus $silabus): bool
    {
        return $user->hasRole('super-admin');
    }
}
