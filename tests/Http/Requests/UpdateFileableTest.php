<?php

use Ohio\Storage\Http\Requests\UpdateFileable;

class UpdateFileableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Storage\Http\Requests\UpdateFileable::rules
     */
    public function test()
    {

        $request = new UpdateFileable();

        $this->assertNotEmpty($request->rules());
    }

}