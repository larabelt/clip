<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OhioCreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_public')->default(1);
            $table->string('disk');
            $table->string('name');
            $table->string('original_name')->nullable();
            $table->text('file_path'); // relative file path
            $table->text('web_path'); // relative web path
            $table->string('mimetype', 50)->nullable();
            $table->integer('size')->nullable();
            // image specific
            $table->integer('width')->nullable();
            $table->string('height')->nullable();
            // meta data
            $table->string('title')->nullable();
            $table->text('note')->nullable();
            $table->text('credits')->nullable();
            $table->text('alt')->nullable();
            $table->text('target_url')->nullable();
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
        Schema::drop('files');
    }
}
