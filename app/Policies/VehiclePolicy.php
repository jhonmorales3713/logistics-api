<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\Response;

class VehiclePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }
    /**
     * Determine whether the user can set for maintennance the model.
     */
    public function forMaintennance(User $user, Vehicle $vehicle)
    {
        return $vehicle->status == Vehicle::STATUS_ACTIVE ? Response::allow() : Response::deny("Update Failed. Please refresh the page.");
    }
    /**
     * Determine whether the user can set on maintennance the model.
     */
    public function onMaintennance(User $user, Vehicle $vehicle)
    {
        return $vehicle->status == Vehicle::STATUS_FOR_MAINTENNANCE ? Response::allow() : Response::deny("Update Failed. Please refresh the page.");
    }
    /**
     * Determine whether the user can set active the model.
     */
    public function active(User $user, Vehicle $vehicle)
    {
        return $vehicle->status == Vehicle::STATUS_ON_MAINTENNANCE ? Response::allow() : Response::deny("Update Failed. Please refresh the page.");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vehicle $vehicle): bool
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
    public function update(User $user, Vehicle $vehicle): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vehicle $vehicle): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vehicle $vehicle): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vehicle $vehicle): bool
    {
        //
    }
}
