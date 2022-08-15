<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
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
        return $user->hasPermissionTo('Browse tag');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create tag');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update tag');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete tag');
    }

}
