<?php

use Belt\Clip\Http\Requests\StoreFile;

class StoreFileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Clip\Http\Requests\StoreFile::rules
     */
    public function test()
    {

        $request = new StoreFile();

        $this->assertNotEmpty($request->rules());
    }

}