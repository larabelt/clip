<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Attachment;
use Belt\Clip\Adapters\S3LambdaAdapter;
use Belt\Clip\Helpers\ClipHelper;
use Belt\Clip\Helpers\SrcHelper;

class S3LambdaAdapterTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Adapters\S3LambdaAdapter::loadMacros
     */
    public function test()
    {
        app()['config']->set('belt.clip.drivers.S3LambdaAdapterTest', [
            'disk' => 's3',
            'adapter' => S3LambdaAdapter::class,
            'prefix' => 'testing',
            'src' => [
                'root' => 'http://localhost/images',
            ],
            'secure' => [
                'root' => 'https://localhost/images',
            ],
        ]);

        # loadMacros
        S3LambdaAdapter::loadMacros('S3LambdaAdapterTest');
        $this->assertTrue(SrcHelper::hasMacro('S3LambdaAdapterTest'));

        # closure
        $attachment = factory(Attachment::class)->make([
            'driver' => 'S3LambdaAdapterTest',
            'name' => 'test.jpg',
            'path' => 'testing',
            'width' => 400,
            'height' => 300,
        ]);

        $clipHelper = new ClipHelper($attachment);

        $this->assertEquals('//localhost/images/100x100/testing/test.jpg', $clipHelper->src(100, 100));
        $this->assertEquals('//localhost/images/100x75/testing/test.jpg', $clipHelper->src(100));
        $this->assertEquals('//localhost/images/133x100/testing/test.jpg', $clipHelper->src(null, 100));
    }

}