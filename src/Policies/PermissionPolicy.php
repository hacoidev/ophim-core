<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Backpack\PermissionManager\app\Models\Permission;

class PermissionPolicy
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
        return $user->hasPermissionTo('Browse permission');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create permission');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update permission');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete permission');
    }

}
