<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->time("start_time")->nullable();
            $table->mediumInteger('duration')->unsigned()->nullable();
            $table->boolean('persist_time')->default(0);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->tinyInteger('duration')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('start_time');
            $table->dropColumn('duration');
            $table->dropColumn('persist_time');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
}
