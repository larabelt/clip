<?php

use Ohio\Storage\File\Http\Requests\UpdateFile;

class UpdateFileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Storage\File\Http\Requests\UpdateFile::rules
     */
    public function test()
    {

        $request = new UpdateFile();

        $this->assertNotEmpty($request->rules());
    }

}