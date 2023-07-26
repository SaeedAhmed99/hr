<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class);
            $table->tinyInteger('status');
            $table->datetime('clock_in');
            $table->datetime('clock_out')->nullable();
            $table->time('late')->nullable();
            $table->time('early_leaving')->nullable();
            $table->time('overtime')->nullable();
            $table->time('total_rest')->nullable();
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
        Schema::dropIfExists('attendance_employees');
    }
}
