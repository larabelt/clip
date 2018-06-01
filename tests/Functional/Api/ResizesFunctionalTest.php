<?php

use Belt\Core\Testing;

class ResizesFunctionalTest extends Testing\BeltTestCase
{
    use Testing\CommonMocks;

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/attachments/1/resizes');
        $response->assertStatus(200);

        $upload = $this->getUploadFile(__DIR__ . '/../../testing/test.jpg');

        # store
        $response = $this->json('POST', '/api/v1/attachments/1/resizes', [
            'file' => $upload,
            'note' => 'test',
        ]);
        $response->assertStatus(201);
        $resizeID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/attachments/2/resizes/$resizeID");
        $response->assertStatus(404);
        $response = $this->json('GET', "/api/v1/attachments/1/resizes/$resizeID");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/attachments/1/resizes/$resizeID", ['nickname' => 'updated']);
        $response = $this->json('GET', "/api/v1/attachments/1/resizes/$resizeID");
        $response->assertJson(['nickname' => 'updated']);

        # delete
        $response = $this->json('DELETE', "/api/v1/attachments/1/resizes/$resizeID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/attachments/1/resizes/$resizeID");
        $response->assertStatus(404);
    }

}