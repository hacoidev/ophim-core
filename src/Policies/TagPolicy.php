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
        return $user->hasPermission('Browse tag');
    }

    public function create($user)
    {
        return $user->hasPermission('Create tag');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update tag');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete tag');
    }

}
