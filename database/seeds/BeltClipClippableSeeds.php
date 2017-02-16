<?php

use Illuminate\Database\Seeder;

use Belt\Clip\File;
use Belt\Spot\Place;

class BeltClipClippableSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = File::all();
        $places = Place::take(25)->get();
        foreach ($places as $place) {
            $limit = rand(3, 5);
            for ($i = 1; $i <= $limit; $i++) {
                $file = $files->random();
                $place->files()->attach($file);
            }
        }
    }
}
