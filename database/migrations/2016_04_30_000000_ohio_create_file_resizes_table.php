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
            $table->string('disk', 50);
            $table->integer('file_id')->index();
            $table->string('preset')->index();
            $table->string('name');
            $table->string('original_name')->nullable();
            $table->text('file_path'); // relative file path
            $table->text('web_path'); // relative web path
            $table->string('mimetype', 50)->nullable();
            $table->integer('size')->nullable();
            $table->integer('width')->nullable();
            $table->string('height')->nullable();
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
