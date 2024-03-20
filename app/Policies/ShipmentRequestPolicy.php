<?php

namespace App\Policies;

use App\Models\ShipmentRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShipmentRequestPolicy
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
    public function view(User $user, ShipmentRequest $shipmentRequest): bool
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
    public function update(User $user, ShipmentRequest $shipmentRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShipmentRequest $shipmentRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShipmentRequest $shipmentRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShipmentRequest $shipmentRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can approve the model.
     */
    public function approve(User $user, ShipmentRequest $shipmentRequest): bool
    {
        return $shipmentRequest->status == ShipmentRequest::STATUS_PENDING;
    }

    /**
     * Determine whether the user can decline the model.
     */
    public function decline(User $user, ShipmentRequest $shipmentRequest)
    {
        return $shipmentRequest->status == ShipmentRequest::STATUS_PENDING ? Response::allow() : Response::deny("Update Failed. Please refresh the page.");
    }

    /**
     * Determine whether the user can decline the model.
     */
    public function unapprove(User $user, ShipmentRequest $shipmentRequest): bool
    {
        return $shipmentRequest->status == ShipmentRequest::STATUS_APPROVE;
    }
}
