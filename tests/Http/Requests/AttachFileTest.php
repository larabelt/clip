<?php

use Belt\Clip\Http\Requests\AttachFile;

class AttachFileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Clip\Http\Requests\AttachFile::rules
     */
    public function test()
    {

        $request = new AttachFile();

        $this->assertNotEmpty($request->rules());
    }

}