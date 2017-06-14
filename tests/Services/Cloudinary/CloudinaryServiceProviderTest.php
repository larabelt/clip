<?php

use Mockery as m;
use Illuminate\Support\Facades\Storage;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Services\Cloudinary\CloudinaryServiceProvider;

class CloudinaryServiceProviderTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Services\Cloudinary\CloudinaryServiceProvider::register
     * @covers \Belt\Clip\Services\Cloudinary\CloudinaryServiceProvider::boot
     */
    public function test()
    {
        Storage::shouldReceive('extend')->with('cloudinary',
            m::on(function (\Closure $closure) {
                $app = app();
                $closure($app, []);
                return is_callable($closure);
            })
        );

        $provider = new CloudinaryServiceProvider(app());
        $provider->register();
        $provider->boot();
    }

}
