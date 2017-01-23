<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OhioCreateFileResizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_resizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id')->index();
            $table->string('mode')->index();
            $table->string('driver', 50);
            $table->text('path')->nullable();
            $table->string('name');
            // data
            $table->string('mimetype', 50)->nullable();
            $table->integer('size')->nullable();
            $table->string('original_name')->nullable();
            // image only data
            $table->integer('width')->nullable();
            $table->string('height')->nullable();
            $table->softDeletes();
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
        Schema::drop('file_resizes');
    }
}
