<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow all users to view categories
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category): bool
    {
        // Allow all users to view a specific category
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Restrict category creation to authenticated users
        return $user->id !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        // Optionally restrict updates to admin or specific roles
        // You might want to add a role check here
        return $user->id !== null;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        // Restrict deletion to prevent accidental removal
        // You might want to add additional checks like admin role
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool
    {
        // Typically only applicable for soft-deleted models
        return $user->id !== null;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        // Restrict permanent deletion
        return false;
    }
}