<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class DirectorPolicy
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
        return $user->hasPermissionTo('Browse director');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create director');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update director');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete director');
    }

}
