<?php

use Belt\Core\Testing;

class FilesFunctionalTest extends Testing\BeltTestCase
{
    use Testing\CommonMocks;

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/files');
        $response->assertStatus(200);

        $upload = $this->getUploadFile(__DIR__ . '/../testing/test.jpg');

        # store
        $response = $this->json('POST', '/api/v1/files', [
            'file' => $upload,
            'note' => 'test',
        ]);
        $response->assertStatus(201);
        $fileID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/files/$fileID");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/files/$fileID", ['note' => 'updated']);
        $response = $this->json('GET', "/api/v1/files/$fileID");
        $response->assertJson(['note' => 'updated']);

        # delete
        $response = $this->json('DELETE', "/api/v1/files/$fileID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/files/$fileID");
        $response->assertStatus(404);
    }

}