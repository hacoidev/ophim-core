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
        return $user->hasPermission('Browse permission');
    }

    public function create($user)
    {
        return $user->hasPermission('Create permission');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update permission');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete permission');
    }

}
