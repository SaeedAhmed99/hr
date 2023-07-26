<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTypeOfAttendanceEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_employees', function (Blueprint $table) {
            DB::statement('ALTER TABLE `attendance_employees` CHANGE `late` `late` INT UNSIGNED NULL DEFAULT NULL, CHANGE `early_leaving` `early_leaving` INT UNSIGNED NULL DEFAULT NULL, CHANGE `overtime` `overtime` INT UNSIGNED NULL DEFAULT NULL, CHANGE `total_rest` `total_rest` INT UNSIGNED NULL DEFAULT NULL;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_employees', function (Blueprint $table) {
            //nothing
        });
    }
}
