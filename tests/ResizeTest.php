<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\File;
use Belt\Clip\Resize;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResizeTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Resize::file
     * @covers \Belt\Clip\Resize::getPresetAttribute
     */
    public function test()
    {
        $file = factory(File::class)->make();
        $resize = factory(Resize::class)->make(['file' => $file, 'width' => 100, 'height' => 100]);

        # file
        $this->assertInstanceOf(BelongsTo::class, $resize->file());

        # preset
        $this->assertEquals('100:100', $resize->preset);
    }

}