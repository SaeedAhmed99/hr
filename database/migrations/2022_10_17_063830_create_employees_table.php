<?php

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->date('dob')->nullable();
            $table->string('gender', 30);
            $table->string('phone', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('employee_id');
            $table->foreignIdFor(Branch::class)->nullable();
            $table->foreignIdFor(Department::class)->nullable();
            $table->foreignIdFor(Designation::class)->nullable();
            $table->date('date_of_joining')->nullable();
            $table->string('documents')->nullable();
            $table->tinyInteger('salary_type')->nullable();
            $table->integer('salary')->unsigned()->nullable();
            $table->integer('shift_id')->index()->nullable();
            $table->integer('compliance_salary')->unsigned()->nullable();
            $table->boolean('can_overtime')->default(0)->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('persist_time')->default(false);
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
        Schema::dropIfExists('employees');
    }
}
