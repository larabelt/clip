<?php

use Ohio\Core\Testing;
use Ohio\Storage\Policies\FilePolicy;

class FilePolicyTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Ohio\Storage\Policies\FilePolicy::index
     * @covers \Ohio\Storage\Policies\FilePolicy::view
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