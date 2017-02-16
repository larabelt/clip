<?php

use Belt\Storage\Http\Requests\UpdateFileable;

class UpdateFileableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Storage\Http\Requests\UpdateFileable::rules
     */
    public function test()
    {

        $request = new UpdateFileable();

        $this->assertNotEmpty($request->rules());
    }

}