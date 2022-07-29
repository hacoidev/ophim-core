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
        return $user->hasPermission('Browse studio');
    }

    public function create($user)
    {
        return $user->hasPermission('Create studio');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update studio');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete studio');
    }

}
