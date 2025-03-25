<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Competence;
use Illuminate\Auth\Access\Response;

class CompetencePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow all users to view competences
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Competence $competence): bool
    {
        // Allow all users to view a specific competence
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Restrict competence creation to authenticated users
        return $user->id !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Competence $competence): bool
    {
        // Only allow users associated with the competence to update it
        return $user->competences()->where('competence_id', $competence->id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Competence $competence): bool
    {
        // Only allow users associated with the competence to delete it
        return $user->competences()->where('competence_id', $competence->id)->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Competence $competence): bool
    {
        // Typically only applicable for soft-deleted models
        return $user->id !== null;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Competence $competence): bool
    {
        // Restrict permanent deletion
        return false;
    }
}