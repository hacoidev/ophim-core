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
        return $user->hasPermission('Browse role');
    }

    public function create($user)
    {
        return $user->hasPermission('Create role');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update role');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete role');
    }

}
