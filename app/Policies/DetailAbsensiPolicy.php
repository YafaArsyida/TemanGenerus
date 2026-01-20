<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\DetailAbsensi;
use App\Models\User;

class DetailAbsensiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DetailAbsensi $detailAbsensi): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DetailAbsensi $detailAbsensi): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DetailAbsensi $detailAbsensi): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DetailAbsensi $detailAbsensi): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DetailAbsensi $detailAbsensi): bool
    {
        //
    }
}
