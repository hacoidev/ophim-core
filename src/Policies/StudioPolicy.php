<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class StudioPolicy
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
        return $user->hasPermissionTo('Browse studio');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create studio');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update studio');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete studio');
    }

}
