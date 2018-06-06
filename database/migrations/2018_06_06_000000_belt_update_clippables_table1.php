<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeltUpdateClippablesTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clippables', function (Blueprint $table) {
            $table->unique(['attachment_id', 'clippable_id', 'clippable_type'], 'clippable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clippables', function (Blueprint $table) {
            $table->dropUnique('clippable');
        });
    }
}
