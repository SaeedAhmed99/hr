<?php

use App\Models\Branch;
use App\Models\Trainer;
use App\Models\Employee;
use App\Models\TrainingType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Branch::class);
            $table->foreignIdFor(TrainingType::class);
            $table->foreignIdFor(Trainer::class);
            $table->foreignIdFor(Employee::class);
            $table->enum('trainer_option', ['Internal', 'External']);
            $table->integer('training_cost');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('description')->nullable();
            $table->enum('performance', ['Not Concluded', 'Satisfactory', 'Average', 'Poor', 'Excellent']);
            $table->enum('status', ['Pending', 'Started', 'Completed', 'Terminated']);
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('trainings');
    }
}
