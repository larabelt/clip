<?php

use Belt\Clip\Http\Requests\UpdateClippable;

class UpdateClippableTest extends \PHPUnit\Framework\TestCase
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