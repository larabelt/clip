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
        app()['config']->set('ohio.storage.disks.testing.adapter', LocalAdapter::class);
        app()['config']->set('filesystems.disks.testing.driver', 'local');
        app()['config']->set('filesystems.disks.testing.root', __DIR__);

        $this->assertEmpty(AdapterFactory::$adapters);
        $this->assertInstanceOf(BaseAdapter::class, AdapterFactory::up('testing'));
        $this->assertNotEmpty(AdapterFactory::$adapters);
        $this->assertInstanceOf(BaseAdapter::class, AdapterFactory::up('testing'));

        try {
            $exception = false;
            AdapterFactory::up('invalid');
        } catch (\Exception $e) {
            $exception = true;
        }
        $this->assertTrue($exception);
    }

}