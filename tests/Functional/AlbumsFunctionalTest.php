<?php

use Belt\Core\Testing;

class AlbumsFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/albums');
        $response->assertStatus(200);

        # store
        $response = $this->json('POST', '/api/v1/albums', [
            'name' => 'test',
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['id']);
        $albumID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/albums/$albumID");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/albums/$albumID", ['name' => 'updated']);
        $response = $this->json('GET', "/api/v1/albums/$albumID");
        $response->assertJson(['name' => 'updated']);

        # copy
        Album::unguard();
        $old = Album::find($albumID);
        $old->attachments()->attach(1);
        $old->tags()->attach(1);
        $response = $this->json('POST', '/api/v1/albums', ['source' => $albumID]);
        $response->assertStatus(201);
        $copiedAlbumID = array_get($response->json(), 'id');
        $response = $this->json('GET', "/api/v1/albums/$copiedAlbumID");
        $response->assertStatus(200);

        # delete
        $response = $this->json('DELETE', "/api/v1/albums/$albumID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/albums/$albumID");
        $response->assertStatus(404);
    }

}