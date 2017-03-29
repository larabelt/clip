<?php

use Belt\Core\Testing;
use Belt\Clip\Policies\AlbumPolicy;

class AlbumPolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Belt\Clip\Policies\AlbumPolicy::index
     * @covers \Belt\Clip\Policies\AlbumPolicy::view
     */
    public function test()
    {
        $user = $this->getUser();

        $policy = new AlbumPolicy();

        # index
        $this->assertTrue($policy->index($user, 1));

        # view
        $this->assertTrue($policy->view($user, 1));
    }

}