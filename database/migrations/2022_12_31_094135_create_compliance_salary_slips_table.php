<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplianceSalarySlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compliance_salary_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class);
            $table->integer('net_payable');
            $table->date('salary_month');
            $table->tinyInteger('status')->default(0)->comment("0 => not payed, 1 => payed");
            $table->integer('basic_salary');
            $table->json('allowance');
            $table->json('commission');
            $table->json('deduction');
            $table->json('other_payment');
            $table->json('overtime');
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
        Schema::dropIfExists('compliance_salary_slips');
    }
}
