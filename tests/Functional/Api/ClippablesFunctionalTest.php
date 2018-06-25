<?php

use Silber\Bouncer\BouncerFacade as Bouncer;
use Belt\Core\Testing;
use Belt\Core\User;
use Belt\Clip\Attachment;
use Belt\Clip\Album;

class ClippablesFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/albums/1/attachments');
        $response->assertStatus(200);

        # attach
        $response = $this->json('POST', '/api/v1/albums/1/attachments', ['id' => 11]);
        $response->assertStatus(201);
        $response = $this->json('GET', "/api/v1/albums/1/attachments/11");
        $position11 = $response->json('position');
        $response->assertStatus(200);
        $response->assertJsonFragment(['id']);

        # attach (fail)
        $response = $this->json('POST', '/api/v1/albums/1/attachments', ['id' => 11]);
        $response->assertStatus(422);

        # update (position: add attachement #12 and then move before #11)
        $this->json('POST', '/api/v1/albums/1/attachments', ['id' => 12]);
        $response = $this->json('GET', "/api/v1/albums/1/attachments/12");
        $position12 = $response->json('position');
        $response->assertJson(['position' => $position11 + 1]);
        $this->json('PUT', '/api/v1/albums/1/attachments/12', ['move' => 'before', 'position_entity_id' => 11]);
        $response = $this->json('GET', "/api/v1/albums/1/attachments/11");
        $response->assertJson(['position' => $position12]);

        # show
        $response = $this->json('GET', "/api/v1/albums/1/attachments/11");
        $response->assertStatus(200);

        # detach
        $response = $this->json('DELETE', "/api/v1/albums/1/attachments/11");
        $response->assertStatus(204);
        $response = $this->json('DELETE', "/api/v1/albums/1/attachments/11");
        $response->assertStatus(422);
    }

    public function testNotSuper()
    {
        $this->refreshDB();

        $album = Album::find(1);
        $attachment = Attachment::find(1);
        $album->attachments()->syncWithoutDetaching(1);

        # update (authorize exception)
        User::unguard();
        $user = factory(User::class)->create(['is_active' => true]);
        $this->actingAs($user);

        Bouncer::allow($user)->to('update', Album::class);
        Bouncer::disallow($user)->to('update', Attachment::class);
        Bouncer::refreshFor($user);

        $response = $this->json('PUT', '/api/v1/albums/1/attachments/1', ['title' => 'foo']);

        $response->assertJson(['title' => $attachment->title]);


    }

}