<?php

use Belt\Core\Testing;
use Belt\Clip\Policies\AlbumPolicy;

class AlbumPolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Belt\Clip\Policies\AlbumPolicy::view
     * @covers \Belt\Clip\Policies\AlbumPolicy::create
     */
    public function test()
    {
        $user = $this->getUser();

        $policy = new AlbumPolicy();

        # create
        $this->assertNotTrue($policy->create($user));
        $this->assertNotEmpty($policy->create($this->getUser('team')));

        # view
        $this->assertTrue($policy->view($user, 1));
    }

}