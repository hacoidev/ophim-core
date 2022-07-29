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
        return $user->hasPermission('Browse menu');
    }

    public function create($user)
    {
        return $user->hasPermission('Create menu');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update menu');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete menu');
    }

}
