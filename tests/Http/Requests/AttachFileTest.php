<?php

use Ohio\Storage\Http\Requests\AttachFile;

class AttachFileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Storage\Http\Requests\AttachFile::rules
     */
    public function test()
    {

        $request = new AttachFile();

        $this->assertNotEmpty($request->rules());
    }

}