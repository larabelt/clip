<?php

use Belt\Clip\Http\Requests\UpdateFile;

class UpdateFileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Clip\Http\Requests\UpdateFile::rules
     */
    public function test()
    {

        $request = new UpdateFile();

        $this->assertNotEmpty($request->rules());
    }

}