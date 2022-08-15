<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class MoviePolicy
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
        return $user->hasPermissionTo('Browse movie');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create movie');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update movie');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete movie');
    }

}
