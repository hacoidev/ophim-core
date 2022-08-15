<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->hasRole('Admin')) {
            return true;
        }
    }

    public function browse($user)
    {
        return $user->hasPermissionTo('Browse role');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create role');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update role');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete role');
    }

}
