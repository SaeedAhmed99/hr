<?php

use App\Models\EmployeePerformance;
use App\Models\PerformanceMetric;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePerformanceScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_performance_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PerformanceMetric::class);
            $table->foreignIdFor(EmployeePerformance::class);
            $table->unsignedTinyInteger('score');
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
        Schema::dropIfExists('employee_performance_scores');
    }
}
