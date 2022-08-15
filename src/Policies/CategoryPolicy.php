<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
        return $user->hasPermissionTo('Browse category');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create category');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update category');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete category');
    }

}
