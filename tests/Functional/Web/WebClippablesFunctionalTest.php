<?php

use Mockery as m;
use Illuminate\Support\Facades\Cache;
use Belt\Core\Testing;

class WebClippablesFunctionalTest extends Testing\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test1()
    {
        $this->refreshDB();

        Cache::shouldReceive('get')->once()->with('attachment:albums:1:1:src')->andReturnNull();
        Cache::shouldReceive('put');

        $response = $this->get('/albums/1/attachments');

        $response->assertStatus(200);
    }

    public function test2()
    {
        $this->refreshDB();

        Cache::shouldReceive('get')->once()->with('attachment:albums:1:1:src')->andReturn('test');

        $response = $this->get('/albums/1/attachments');

        $response->assertStatus(200);
    }

    public function test3()
    {
        $this->refreshDB();

        Cache::shouldReceive('get')->once()->with('attachment:albums:1:999:src')->andReturnNull();

        $response = $this->get('/albums/1/attachments/999');
        //$response->dump();

        $response->assertStatus(404);
    }

}