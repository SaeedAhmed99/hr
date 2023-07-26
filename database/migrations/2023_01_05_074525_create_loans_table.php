<?php

use App\Models\Employee;
use App\Models\LoanType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class);
            $table->foreignIdFor(LoanType::class);
            $table->integer('amount');
            $table->integer('payable_amount');
            $table->integer('installment_month');
            $table->integer('installment_amount');
            $table->integer('paid_amount')->default(0);
            $table->date('activation_date');
            $table->string('reason')->nullable();
            $table->string('reference_by')->nullable();
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
        Schema::dropIfExists('loans');
    }
}
