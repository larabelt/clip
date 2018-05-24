<?php

use Belt\Clip\Http\Requests\AttachAttachment;

class AttachAttachmentTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Clip\Http\Requests\AttachAttachment::rules
     */
    public function test()
    {

        $request = new AttachAttachment();

        $this->assertNotEmpty($request->rules());
    }

}