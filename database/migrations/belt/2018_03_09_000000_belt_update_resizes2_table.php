<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeltUpdateResizes2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attachment_resizes', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('driver', 50)->nullable()->change();
            $table->string('mode')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attachment_resizes', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('driver', 50)->nullable(false)->change();
            $table->string('mode')->nullable(false)->change();
        });
    }
}
