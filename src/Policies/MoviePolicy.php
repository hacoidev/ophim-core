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
        return $user->hasPermission('Browse movie');
    }

    public function create($user)
    {
        return $user->hasPermission('Create movie');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update movie');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete movie');
    }

}
