<?php

use Belt\Clip\Album;
use Illuminate\Database\Seeder;

class BeltClipAlbumSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Album::class, 25)->create();
    }
}
