<?php

namespace Belt\Clip\Policies;

use Belt\Core\User;
use Belt\Core\Policies\BaseAdminPolicy;
use Belt\Clip\Attachment;

/**
 * Class AttachmentPolicy
 * @package Belt\Clip\Policies
 */
class AttachmentPolicy extends BaseAdminPolicy
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
     * @param  Attachment $object
     * @return mixed
     */
    public function view(User $auth, $object)
    {
        return true;
    }
}