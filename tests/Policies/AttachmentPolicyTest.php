<?php

use Belt\Core\Testing;
use Belt\Clip\Policies\AttachmentPolicy;

class AttachmentPolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Belt\Clip\Policies\AttachmentPolicy::index
     * @covers \Belt\Clip\Policies\AttachmentPolicy::view
     */
    public function test()
    {
        $user = $this->getUser();

        $policy = new AttachmentPolicy();

        # index
        $this->assertTrue($policy->index($user, 1));

        # view
        $this->assertTrue($policy->view($user, 1));
    }

}