<?php

namespace App\Policies;

use App\Models\job_offer;
use App\Models\User;
use App\Models\JobOffer;
use Illuminate\Auth\Access\Response;

class JobOfferPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow all users to view job offers
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, job_offer $jobOffer): bool
    {
        // Allow all users to view a specific job offer
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Restrict job offer creation to authenticated users
        return $user->id !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, job_offer $jobOffer): bool
    {
        // Only allow the job offer creator to update
        return $user->id === $jobOffer->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, job_offer $jobOffer): bool
    {
        // Only allow the job offer creator to delete
        return $user->id === $jobOffer->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, job_offer $jobOffer): bool
    {
        // Typically only applicable for soft-deleted models
        return $user->id !== null;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, job_offer $jobOffer): bool
    {
        // Restrict permanent deletion
        return false;
    }
}