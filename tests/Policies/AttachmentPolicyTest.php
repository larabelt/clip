<?php

use Belt\Core\Testing;
use Belt\Clip\Policies\AttachmentPolicy;

class AttachmentPolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Belt\Clip\Policies\AttachmentPolicy::view
     * @covers \Belt\Clip\Policies\AttachmentPolicy::create
     */
    public function test()
    {
        $user = $this->getUser();

        $policy = new AttachmentPolicy();

        # create
        $this->assertNotTrue($policy->create($user));
        $this->assertNotEmpty($policy->create($this->getUser('team')));

        # view
        $this->assertTrue($policy->view($user, 1));
    }

}