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

        $request = new StoreAlbum(['source' => 1]);
        $this->assertArrayHasKey('source', $request->rules());
    }

}