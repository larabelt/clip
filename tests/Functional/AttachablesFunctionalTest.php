<?php

use Belt\Core\Testing;

class AttachablesFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # attach
        $response = $this->json('POST', '/api/v1/touts/1/attachment', ['id' => 1]);
        $response->assertStatus(201);
        $response = $this->json('GET', "/api/v1/touts/1/attachment");
        $response->assertStatus(200);
        $response->assertJson(['id' => 1]);

        # switch
        $this->json('PUT', '/api/v1/touts/1/attachment', ['id' => 2]);
        $response = $this->json('GET', "/api/v1/touts/1/attachment");
        $response->assertJson(['id' => 2]);

        # detach
        $response = $this->json('DELETE', "/api/v1/touts/1/attachment");
        $response->assertStatus(204);
        $response = $this->json('DELETE', "/api/v1/touts/1/attachment");
        $response->assertStatus(422);
    }

}