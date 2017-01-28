<?php

use Mockery as m;
use Ohio\Core\Testing\OhioTestCase;
use Ohio\Storage\File;
use Ohio\Storage\Resize;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResizeTest extends OhioTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\Resize::file
     * @covers \Ohio\Storage\Resize::getPresetAttribute
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