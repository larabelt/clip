<?php

use Illuminate\Database\Seeder;

use Belt\Clip\File;

class BeltClipFileSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(File::class, 25)->create();
    }
}
