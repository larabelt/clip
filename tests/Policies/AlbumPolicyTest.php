<?php

use Belt\Core\Testing;
use Belt\Clip\Policies\AlbumPolicy;

class AlbumPolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Belt\Clip\Policies\AlbumPolicy::view
     */
    public function test()
    {
        $user = $this->getUser();

        $policy = new AlbumPolicy();

        # view
        $this->assertTrue($policy->view($user, 1));
    }

}