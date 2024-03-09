<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\Response;

class UserRolePolicy
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
    public function view(User $user, UserRole $userRole): bool
    {
        //
    }
    /**
     * Determine whether the user can set active the model.
     */
    public function active(User $user, UserRole $userRole)
    {
        return $userRole->status == UserRole::STATUS_INACTIVE ? Response::allow() : Response::deny("Update Failed. Please refresh the page.");
    }
    /**
     * Determine whether the user can set active the model.
     */
    public function inactive(User $user, UserRole $userRole)
    {
        return $userRole->status == UserRole::STATUS_ACTIVE ? Response::allow() : Response::deny("Update Failed. Please refresh the page.");
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
    public function update(User $user, UserRole $userRole): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserRole $userRole): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserRole $userRole): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserRole $userRole): bool
    {
        //
    }
}
