<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Estudiante;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstudiantePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_estudiante');
    }

    public function view(User $user, Estudiante $estudiante): bool
    {
        return $user->can('view_estudiante');
    }

    public function create(User $user): bool
    {
        return $user->can('create_estudiante');
    }

    public function update(User $user, Estudiante $estudiante): bool
    {
        return $user->can('update_estudiante');
    }

    public function delete(User $user, Estudiante $estudiante): bool
    {
        return $user->can('delete_estudiante');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_estudiante');
    }

    public function forceDelete(User $user, Estudiante $estudiante): bool
    {
        return $user->can('force_delete_estudiante');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_estudiante');
    }

    public function restore(User $user, Estudiante $estudiante): bool
    {
        return $user->can('restore_estudiante');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_estudiante');
    }

    public function replicate(User $user, Estudiante $estudiante): bool
    {
        return $user->can('replicate_estudiante');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_estudiante');
    }
}
