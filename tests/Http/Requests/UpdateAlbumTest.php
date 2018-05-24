<?php

use Belt\Clip\Http\Requests\UpdateAlbum;

class UpdateAlbumTest extends \PHPUnit\Framework\TestCase
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