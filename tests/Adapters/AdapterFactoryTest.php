<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Storage\Adapters\BaseAdapter;
use Belt\Storage\Adapters\AdapterFactory;
use Belt\Storage\Adapters\LocalAdapter;

class AdapterFactoryTest extends BeltTestCase
{

    /**
     * @covers \Belt\Storage\Adapters\AdapterFactory::up
     */
    public function test()
    {
        app()['config']->set('belt.storage.drivers.AdapterFactoryTest', [
            'disk' => 'public',
            'adapter' => LocalAdapter::class,
            'prefix' => 'testing',
            'src' => [
                'root' => 'http://localhost',
            ],
            'secure' => [
                'root' => 'http://localhost',
            ],
        ]);

        $this->assertEmpty(array_get(AdapterFactory::$adapters, 'AdapterFactoryTest'));
        $this->assertInstanceOf(BaseAdapter::class, AdapterFactory::up('AdapterFactoryTest'));
        $this->assertNotEmpty(AdapterFactory::$adapters);
        $this->assertInstanceOf(BaseAdapter::class, AdapterFactory::up('AdapterFactoryTest'));

        try {
            $exception = false;
            AdapterFactory::up('invalid');
        } catch (\Exception $e) {
            $exception = true;
        }
        $this->assertTrue($exception);
    }

}