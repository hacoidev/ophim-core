<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return $user->hasPermissionTo('Browse user');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create user');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update user');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete user');
    }

}
