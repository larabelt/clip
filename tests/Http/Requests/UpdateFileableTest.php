<?php

use Belt\Clip\Http\Requests\UpdateFileable;

class UpdateFileableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Clip\Http\Requests\UpdateFileable::rules
     */
    public function test()
    {

        $request = new UpdateFileable();

        $this->assertNotEmpty($request->rules());
    }

}