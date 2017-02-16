<?php

use Illuminate\Database\Seeder;

use Belt\Clip\Attachment;

class BeltClipAttachmentSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Attachment::class, 25)->create();
    }
}
