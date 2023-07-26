<?php

use App\Models\TimeTracker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreenshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screenshots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TimeTracker::class)->nullable();
            $table->string('image');
            $table->string('activity', 25);
            $table->integer('keystroke');
            $table->integer('mouse_click');
            $table->foreignId('employee_id')->nullable()->comment("Only for no-ui employees those does not have any project specified!");
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
        Schema::dropIfExists('screenshots');
    }
}
