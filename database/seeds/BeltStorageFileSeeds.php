<?php

use Illuminate\Database\Seeder;

use Belt\Storage\File;

class BeltStorageFileSeeds extends Seeder
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
