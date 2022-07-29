<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class RegionPolicy
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
        return $user->hasPermission('Browse region');
    }

    public function create($user)
    {
        return $user->hasPermission('Create region');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update region');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete region');
    }

}
