<?php

use Belt\Storage\Http\Requests\UpdateFile;

class UpdateFileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Storage\Http\Requests\UpdateFile::rules
     */
    public function test()
    {

        $request = new UpdateFile();

        $this->assertNotEmpty($request->rules());
    }

}