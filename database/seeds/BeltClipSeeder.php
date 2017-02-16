<?php

use Illuminate\Database\Seeder;

class BeltClipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BeltClipFileSeeds::class);
        $this->call(BeltClipClippableSeeds::class);
    }
}
