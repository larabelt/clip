<?php

namespace Belt\Clip\Policies;

use Belt\Core\User;
use Belt\Core\Policies\BaseAdminPolicy;
use Belt\Clip\Album;

/**
 * Class AlbumPolicy
 * @package Belt\Clip\Policies
 */
class AlbumPolicy extends BaseAdminPolicy
{
    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @return mixed
     */
    public function index(User $auth)
    {
        return true;
    }

    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  Album $object
     * @return mixed
     */
    public function view(User $auth, $object)
    {
        return true;
    }
}