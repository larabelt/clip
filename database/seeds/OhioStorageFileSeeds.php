<?php

use Illuminate\Database\Seeder;

use Ohio\Storage\File\File;

class OhioStorageFileSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(File::class, 1)->create();
    }
}
