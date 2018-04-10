<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeltCreateClippablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clippables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attachment_id')->index();
            $table->morphs('clippable');
            $table->integer('position')->nullable()->default(1); // Your model must have position field:
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clippables');
    }
}
