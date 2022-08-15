<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
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
        return $user->hasPermissionTo('Browse menu');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create menu');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update menu');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete menu');
    }

}
