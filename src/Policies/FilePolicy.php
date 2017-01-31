<?php

namespace Ohio\Storage\Policies;

use Ohio\Core\User;
use Ohio\Core\Policies\BaseAdminPolicy;
use Ohio\Storage\File;

class FilePolicy extends BaseAdminPolicy
{
    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  File $object
     * @return mixed
     */
    public function index(User $auth, $object)
    {
        return true;
    }

    /**
     * Determine whether the user can view the object.
     *
     * @param  User $auth
     * @param  File $object
     * @return mixed
     */
    public function view(User $auth, $object)
    {
        return true;
    }
}