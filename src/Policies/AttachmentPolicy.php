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
     * @param  mixed $arguments
     * @return mixed
     */
    public function view(User $auth, $arguments = null)
    {
        return true;
    }
}