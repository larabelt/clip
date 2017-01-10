<?php

use Illuminate\Database\Seeder;

class OhioStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OhioStorageFileSeeds::class);
    }
}
