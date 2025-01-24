<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Director;
use Illuminate\Auth\Access\HandlesAuthorization;

class DirectorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any directors.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_director');
    }

    /**
     * Determine whether the user can view a specific director.
     */
    public function view(User $user, Director $director): bool
    {
        return $user->can('view_director');
    }

    /**
     * Determine whether the user can create a director.
     */
    public function create(User $user): bool
    {
        return $user->can('create_director');
    }

    /**
     * Determine whether the user can update a specific director.
     */
    public function update(User $user, Director $director): bool
    {
        return $user->can('update_director');
    }

    /**
     * Determine whether the user can delete a specific director.
     */
    public function delete(User $user, Director $director): bool
    {
        return $user->can('delete_director');
    }

    /**
     * Determine whether the user can bulk delete directors.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_director');
    }

    /**
     * Determine whether the user can permanently delete a director.
     */
    public function forceDelete(User $user, Director $director): bool
    {
        return $user->can('force_delete_director');
    }

    /**
     * Determine whether the user can permanently bulk delete directors.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_director');
    }

    /**
     * Determine whether the user can restore a specific director.
     */
    public function restore(User $user, Director $director): bool
    {
        return $user->can('restore_director');
    }

    /**
     * Determine whether the user can bulk restore directors.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_director');
    }

    /**
     * Determine whether the user can replicate a specific director.
     */
    public function replicate(User $user, Director $director): bool
    {
        return $user->can('replicate_director');
    }

    /**
     * Determine whether the user can reorder directors.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_director');
    }
}
