<?php

use Belt\Clip\Http\Requests\UpdateAlbum;

class UpdateAlbumTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Clip\Http\Requests\UpdateAlbum::rules
     */
    public function test()
    {

        $request = new UpdateAlbum();

        $this->assertNotEmpty($request->rules());
    }

}