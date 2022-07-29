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
        return $user->hasPermission('Browse episode');
    }

    public function create($user)
    {
        return $user->hasPermission('Create episode');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update episode');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete episode');
    }
}
