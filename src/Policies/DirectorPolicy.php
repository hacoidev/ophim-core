<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class DirectorPolicy
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
        return $user->hasPermission('Browse director');
    }

    public function create($user)
    {
        return $user->hasPermission('Create director');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update director');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete director');
    }

}
