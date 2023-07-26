<?php

use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class);
            $table->foreignId("old_designation_id");
            $table->foreignId("new_designation_id");
            $table->integer('old_salary');
            $table->integer('new_salary');
            $table->string('promotion_title');
            $table->date('promotion_date');
            $table->string('description')->nullable();
            $table->foreignId("promoted_by");
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
        Schema::dropIfExists('promotions');
    }
}
