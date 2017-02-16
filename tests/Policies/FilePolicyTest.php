<?php

use Belt\Core\Testing;
use Belt\Clip\Policies\FilePolicy;

class FilePolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Belt\Clip\Policies\FilePolicy::index
     * @covers \Belt\Clip\Policies\FilePolicy::view
     */
    public function test()
    {
        $user = $this->getUser();

        $policy = new FilePolicy();

        # index
        $this->assertTrue($policy->index($user, 1));

        # view
        $this->assertTrue($policy->view($user, 1));
    }

}