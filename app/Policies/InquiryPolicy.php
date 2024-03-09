<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InquiryPolicy
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
    public function view(User $user, Inquiry $inquiry): bool
    {
        // $this->authorize('update', $post);
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
    public function update(User $user, Inquiry $inquiry): bool
    {
        // dd($inquiry);
    }

    /**
     * Determine whether the user can receive the model.
     */
    public function receive(User $user, Inquiry $inquiry)
    {
        return $inquiry->status == Inquiry::STATUS_PENDING ? Response::allow() : Response::deny("Update Failed. Please refresh the page.");
    }

    /**
     * Determine whether the user can invalid the model.
     */
    public function invalid(User $user, Inquiry $inquiry)
    {
        return $inquiry->status == Inquiry::STATUS_PENDING || $inquiry->status == Inquiry::STATUS_RECEIVED ? Response::allow() : Response::deny("Update Failed. Please refresh the page.");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inquiry $inquiry): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Inquiry $inquiry): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Inquiry $inquiry): bool
    {
        //
    }
}
