<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class CatalogPolicy
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
        return $user->hasPermissionTo('Browse catalog');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create catalog');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update catalog');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete catalog');
    }

}
