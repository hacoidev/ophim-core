<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class EpisodePolicy
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
        return $user->hasPermissionTo('Browse episode');
    }

    public function create($user)
    {
        return $user->hasPermissionTo('Create episode');
    }

    public function update($user, $entry)
    {
        return $user->hasPermissionTo('Update episode');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermissionTo('Delete episode');
    }
}
