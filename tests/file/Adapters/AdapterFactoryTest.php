<?php

use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Storage\File\Adapters\BaseAdapter;
use Ohio\Storage\File\Adapters\AdapterFactory;
use Ohio\Storage\File\Adapters\LocalAdapter;

class AdapterFactoryTest extends OhioTestCase
{

    /**
     * @covers \Ohio\Storage\File\Adapters\AdapterFactory::up
     */
    public function test()
    {
        app()['config']->set('ohio.storage.drivers.AdapterFactoryTest', [
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