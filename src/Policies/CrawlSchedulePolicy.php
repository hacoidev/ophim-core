<?php

namespace Ophim\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class CrawlSchedulePolicy
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
        return $user->hasPermission('Browse crawl schedule');
    }

    public function create($user)
    {
        return $user->hasPermission('Create crawl schedule');
    }

    public function update($user, $entry)
    {
        return $user->hasPermission('Update crawl schedule');
    }

    public function delete($user, $entry)
    {
        return $user->hasPermission('Delete crawl schedule');
    }

}
