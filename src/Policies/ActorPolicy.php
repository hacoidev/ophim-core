<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ActorPolicy
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
        return $user->hasPermission('Browse user');
    }

    public function create($user)
    {
        return $user->hasPermission('Create user');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update user');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete user');
    }

}
