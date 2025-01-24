<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Profesor;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfesorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_profesor');
    }

    public function view(User $user, Profesor $profesor): bool
    {
        return $user->can('view_profesor');
    }

    public function create(User $user): bool
    {
        return $user->can('create_profesor');
    }

    public function update(User $user, Profesor $profesor): bool
    {
        return $user->can('update_profesor');
    }

    public function delete(User $user, Profesor $profesor): bool
    {
        return $user->can('delete_profesor');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_profesor');
    }

    public function forceDelete(User $user, Profesor $profesor): bool
    {
        return $user->can('force_delete_profesor');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_profesor');
    }

    public function restore(User $user, Profesor $profesor): bool
    {
        return $user->can('restore_profesor');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_profesor');
    }

    public function replicate(User $user, Profesor $profesor): bool
    {
        return $user->can('replicate_profesor');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_profesor');
    }
}
