<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OhioCreateFileablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fileables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id')->index();
            $table->morphs('fileable');
            $table->float('delta')->default(1)->index();
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
        Schema::drop('fileables');
    }
}
