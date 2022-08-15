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
        return $user->hasPermissionTo('Browse region');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create region');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update region');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete region');
    }

}
