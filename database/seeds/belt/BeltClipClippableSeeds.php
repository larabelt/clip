<?php

use Illuminate\Database\Seeder;

use Belt\Clip\Attachment;
use Belt\Clip\Album;

class BeltClipClippableSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attachments = Attachment::all();
        $albums = Album::take(25)->get();
        foreach ($albums as $album) {
            $limit = rand(3, 5);
            for ($i = 1; $i <= $limit; $i++) {
                $attachment = $attachments->random();
                $album->attachAttachment($attachment);
            }
        }
    }
}
