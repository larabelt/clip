<?php

use Belt\Clip\Http\Requests\StoreAlbum;

class StoreAlbumTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Clip\Http\Requests\StoreAlbum::rules
     */
    public function test()
    {

        $request = new StoreAlbum();

        $this->assertNotEmpty($request->rules());
    }

}