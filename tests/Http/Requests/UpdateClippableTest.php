<?php

use Belt\Clip\Http\Requests\UpdateClippable;

class UpdateClippableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Clip\Http\Requests\UpdateClippable::rules
     */
    public function test()
    {

        $request = new UpdateClippable();

        $this->assertNotEmpty($request->rules());
    }

}