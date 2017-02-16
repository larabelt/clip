<?php

use Illuminate\Database\Seeder;

class BeltStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BeltStorageFileSeeds::class);
        $this->call(BeltStorageFileableSeeds::class);
    }
}
