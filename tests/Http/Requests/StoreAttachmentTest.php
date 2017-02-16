<?php

use Belt\Clip\Http\Requests\StoreAttachment;

class StoreAttachmentTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Clip\Http\Requests\StoreAttachment::rules
     */
    public function test()
    {

        $request = new StoreAttachment();

        $this->assertNotEmpty($request->rules());
    }

}