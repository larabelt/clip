<?php

use Belt\Core\Testing;

class ClippablesFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/places/1/attachments');
        $response->assertStatus(200);

        # attach
        $response = $this->json('POST', '/api/v1/places/1/attachments', ['id' => 1]);
        $response->assertStatus(201);
        $response = $this->json('GET', "/api/v1/places/1/attachments/1");
        $response->assertStatus(200);
        $response->assertJsonFragment(['id']);

        # attach (fail)
        $response = $this->json('POST', '/api/v1/places/1/attachments', ['id' => 1]);
        $response->assertStatus(422);

        # update (position: add attachement #2 and then move before #1)
        $this->json('POST', '/api/v1/places/1/attachments', ['id' => 2]);
        $response = $this->json('GET', "/api/v1/places/1/attachments/2");
        $response->assertJson(['position' => 2]);
        $this->json('PUT', '/api/v1/places/1/attachments/2', ['move' => 'before', 'position_entity_id' => 1]);
        $response = $this->json('GET', "/api/v1/places/1/attachments/2");
        $response->assertJson(['position' => 1]);

        # show
        $response = $this->json('GET', "/api/v1/places/1/attachments/1");
        $response->assertStatus(200);

        # detach
        $response = $this->json('DELETE', "/api/v1/places/1/attachments/1");
        $response->assertStatus(204);
        $response = $this->json('DELETE', "/api/v1/places/1/attachments/1");
        $response->assertStatus(422);
    }

}