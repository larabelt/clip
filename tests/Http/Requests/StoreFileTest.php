<?php

use Ohio\Storage\Http\Requests\StoreFile;

class StoreFileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Storage\Http\Requests\StoreFile::rules
     */
    public function test()
    {

        $request = new StoreFile();

        $this->assertNotEmpty($request->rules());
    }

}