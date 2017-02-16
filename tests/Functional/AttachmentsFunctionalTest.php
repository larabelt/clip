<?php

use Belt\Core\Testing;

class AttachmentsFunctionalTest extends Testing\BeltTestCase
{
    use Testing\CommonMocks;

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/attachments');
        $response->assertStatus(200);

        $upload = $this->getUploadFile(__DIR__ . '/../testing/test.jpg');

        # store
        $response = $this->json('POST', '/api/v1/attachments', [
            'file' => $upload,
            'note' => 'test',
        ]);
        $response->assertStatus(201);
        $attachmentID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/attachments/$attachmentID");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/attachments/$attachmentID", ['note' => 'updated']);
        $response = $this->json('GET', "/api/v1/attachments/$attachmentID");
        $response->assertJson(['note' => 'updated']);

        # delete
        $response = $this->json('DELETE', "/api/v1/attachments/$attachmentID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/attachments/$attachmentID");
        $response->assertStatus(404);
    }

}