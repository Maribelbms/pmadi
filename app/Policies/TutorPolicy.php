<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tutor;
use Illuminate\Auth\Access\HandlesAuthorization;

class TutorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_tutor');
    }

    public function view(User $user, Tutor $tutor): bool
    {
        return $user->can('view_tutor');
    }

    public function create(User $user): bool
    {
        return $user->can('create_tutor');
    }

    public function update(User $user, Tutor $tutor): bool
    {
        return $user->can('update_tutor');
    }

    public function delete(User $user, Tutor $tutor): bool
    {
        return $user->can('delete_tutor');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_tutor');
    }

    public function forceDelete(User $user, Tutor $tutor): bool
    {
        return $user->can('force_delete_tutor');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_tutor');
    }

    public function restore(User $user, Tutor $tutor): bool
    {
        return $user->can('restore_tutor');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_tutor');
    }

    public function replicate(User $user, Tutor $tutor): bool
    {
        return $user->can('replicate_tutor');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_tutor');
    }
}
