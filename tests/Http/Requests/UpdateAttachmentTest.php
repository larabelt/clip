<?php

use Belt\Clip\Http\Requests\UpdateAttachment;

class UpdateAttachmentTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Clip\Http\Requests\UpdateAttachment::rules
     */
    public function test()
    {

        $request = new UpdateAttachment();

        $this->assertNotEmpty($request->rules());
    }

}